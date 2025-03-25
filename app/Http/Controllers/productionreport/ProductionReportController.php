<?php

namespace App\Http\Controllers\productionreport;

use App\Http\Controllers\Controller;
use App\Models\unitmovement\Unitmovement;
use App\Models\shop\Shop;
use App\Models\unit_model\Unit_model;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use App\Models\queryanswer\Queryanswer;
use App\Models\querydefect\Querydefect;
use App\Models\float_settings\FloatSetting;
use App\Models\drr\Drr;
use App\Models\drrtarget\DrrTarget;
use App\Models\drrtargetshop\DrrTargetShop;
use Illuminate\Http\Request;
use App\Models\vehicle_units\vehicle_units;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DrrExport;
use App\Exports\DrlExport;
use Illuminate\Support\Facades\Validator;

class ProductionReportController extends Controller
{
  public function currentunitstage()
  {
    if (request()->ajax()) {
      $unitmovement = Unitmovement::where('current_shop', '>', 0)->get();
      return DataTables::of($unitmovement)
        ->addColumn('action', function ($unitmovement) {
          return '
                <button data-href="' . route('moveunit', [$unitmovement->id]) . '" title="Change"  class="btn btn-xs btn-primary edit_unit_button"><i class="mdi mdi-tooltip-edit"></i> Change </button>
                   &nbsp;
                <a href="' . route('moveunit', [$unitmovement->id]) . '" title="Delete"  class="btn btn-xs btn-danger delete-query "><i class="mdi mdi-delete"></i> Delete </a>';
        })
        ->addColumn('unit_vin', function ($unitmovement) {
          return $unitmovement->vehicle->vin_no;
        })
        ->addColumn('unit_lot', function ($unitmovement) {
          return $unitmovement->vehicle->lot_no;
        })
        ->addColumn('unit_job', function ($unitmovement) {
          return $unitmovement->vehicle->job_no;
        })
        ->addColumn('shop', function ($unitmovement) {
          return $unitmovement->shop->shop_name;
        })
        ->addColumn('datein', function ($unitmovement) {
          return dateTimeFormat($unitmovement->created_at);
        })
        ->addColumn('doneby', function ($unitmovement) {
          return $unitmovement->user->name;
        })
        ->make(true);
    }
    return view('production_report.current-stage');
  }
  public function moveunit($id, $from, $to)
  {
    if (request()->ajax()) {
      $shops = Shop::pluck('shop_name', 'id');
      return view('production_report.moveunit')->with(compact('id', 'shops'));
    }
  }
  public function drl($section, $period, $date)
  {
    $section = decrypt_data($section);
    $period = decrypt_data($period);
    $date = decrypt_data($date);
    //plant section
    if ($section == 'plant') {
      //today
      if ($period == 'today') {
        $heading = $heading = 'PLANT DAILY  DIRECT RUN LOSS RESULTS FOR ' . date("d F Y", strtotime($date));
        $start = date_for_database($date);
        $first_of_month = Carbon::createFromFormat('Y-m-d', $start)->startOfMonth();
        $first_of_month = $first_of_month->format("Y-m-d");
        $datepicker_month = date("F Y", strtotime($date));
        $datepicker_day = date("d-m-Y", strtotime($date));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start) {
          $query->where('current_shop', $current_shop);
          $query->where('datetime_out', $start);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('check_point', '=', '1')->orderBy('group_order', 'asc')->get();
       
        unset($shops[0], $shops[5], $shops[7], $shops[10], $shops[13]);
        $drl_arr = [];
        $unit_count = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->count();
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->pluck('id')->all();
            $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();
          }
        }
        $totals_pershop = [];
        foreach ($shops as $shop) {
          $offlineunits = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('shop_id', $shop->id)->count();
          $movement_array = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('group_shop_id', $shop->id)->pluck('id')->all();
          $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          $drl_target = DrrTarget::where('target_type', 'Drl')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drl_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drl_target_value = $drl_shop_target->target_value;
          }
          $drl_pershop = 0;
          if ($offlineunits > 0) {
            $drl_pershop = round(($total_defects / $offlineunits) * 100);
          }
          $totals_pershop[$shop->id]['offlineunit'] = $offlineunits;
          $totals_pershop[$shop->id]['total_defects'] =  $total_defects;
          $totals_pershop[$shop->id]['target'] =  $drl_target_value;
          $totals_pershop[$shop->id]['drl_pershop'] =  $drl_pershop;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drl_arr' => $drl_arr,
          'unit_count' => $unit_count,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
          'totals_pershop' => $totals_pershop,
          'plant_drl' => drl_today($date)['drl'],
          'plant_target' => drl_today($date)['drl_target_value'],
        );
        return view('productionreport.drl-month-todate')->with($data);
      }
      //this month
      if ($period == 'month_to_date') {
        $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
        $start = $start->format("Y-m-d");
        $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
        $end = $end->format("Y-m-d");
        $today = Carbon::now();
        $today = $today->format("d-m-Y");
        $datepicker_month = $date;
        $datepicker_day = $today;
        $heading = 'PLANT MTD DRL RESULTS FOR ' . date("F Y", strtotime($start));
        //Units Produced per month
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start, $end) {
          $query->where('current_shop', $current_shop);
          $query->whereBetween('datetime_out', [$start, $end]);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('check_point', '=', '1')->orderBy('group_order', 'asc')->get();
        unset($shops[0], $shops[5], $shops[7], $shops[10], $shops[13]);
       
        $drl_arr = [];
        $unit_count = [];
        $vehicleid = [];
        $plant_defect = 0;
        $total_units_pershop = [];
        //get vehicles
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->count();
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->pluck('id')->all();
            $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();
          }
        }
        $totals_pershop = [];
        foreach ($shops as $shop) {
          $offlineunits = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('shop_id', $shop->id)->count();
          $movement_array = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('group_shop_id', $shop->id)->pluck('id')->all();
          $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          $drl_target = DrrTarget::where('target_type', 'Drl')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drl_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drl_target_value = $drl_shop_target->target_value;
          }
          $drl_pershop = 0;
          if ($offlineunits > 0) {
            $drl_pershop = round(($total_defects / $offlineunits) * 100);
          }
          $totals_pershop[$shop->id]['offlineunit'] = $offlineunits;
          $totals_pershop[$shop->id]['total_defects'] =  $total_defects;
          $totals_pershop[$shop->id]['target'] =  $drl_target_value;
          $totals_pershop[$shop->id]['drl_pershop'] =  $drl_pershop;
        }
        //dd($drl_arr );
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drl_arr' => $drl_arr,
          'unit_count' => $unit_count,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($start),
          'totals_pershop' => $totals_pershop,
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
          'plant_drl' => month_to_date_drl($date)['drl'],
          'plant_target' => month_to_date_drl($date)['drl_target_value'],
        );
        return view('productionreport.drl-month-todate')->with($data);
      }
      //end plant section
    } elseif ($section == 'cv') {
      //start cv
      if ($period == 'today') {
        $heading = $heading = 'CV DAILY  DIRECT RUN LOSS RESULTS FOR ' . date("d F Y", strtotime($date));
        $start = date_for_database($date);
        $first_of_month = Carbon::createFromFormat('Y-m-d', $start)->startOfMonth();
        $first_of_month = $first_of_month->format("Y-m-d");
        $datepicker_month = date("F Y", strtotime($date));
        $datepicker_day = date("d-m-Y", strtotime($date));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start) {
          $query->where('current_shop', $current_shop);
          $query->where('datetime_out', $start);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('check_point', '=', '1')->orderBy('group_order', 'asc')->get();
        unset($shops[0], $shops[5], $shops[7], $shops[9], $shops[10], $shops[11], $shops[13]);
        $drl_arr = [];
        $unit_count = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            if ($shopid == 15 || $shopid == 16 || $shopid == 28) {
              $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();;
            } else {
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();
            }
          }
        }
        $totals_pershop = [];
        foreach ($shops as $shop) {
          $inline_units = 0;
          $offline_units = 0;
          $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
          if ($shop->id == 15 || $shop->id == 16 || $shop->id == 28) {
            $offlineunits = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->count();
            $movement_array = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('group_shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          } else {
            $offlineunits = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('shop_id', $shop->id)->count();
            $movement_array = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('group_shop_id', $shop->id)->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          }
          $drl_target = DrrTarget::where('target_type', 'Drl')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drl_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drl_target_value = $drl_shop_target->target_value;
          }
          $drl_pershop = 0;
          if ($offlineunits > 0) {
            $drl_pershop = round(($total_defects / $offlineunits) * 100);
          }
          $totals_pershop[$shop->id]['offlineunit'] = $offlineunits;
          $totals_pershop[$shop->id]['total_defects'] =  $total_defects;
          $totals_pershop[$shop->id]['target'] =  $drl_target_value;
          $totals_pershop[$shop->id]['drl_pershop'] =  $drl_pershop;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drl_arr' => $drl_arr,
          'unit_count' => $unit_count,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
          'totals_pershop' => $totals_pershop,
          'plant_drl' => drl_today_cv($date)['drl'],
          'plant_target' => drl_today_cv($date)['drl_target_value'],
        );
        return view('productionreport.drl-month-todate')->with($data);
      }
      if ($period == 'month_to_date') {
        $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
        $start = $start->format("Y-m-d");
        $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
        $end = $end->format("Y-m-d");
        $today = Carbon::now();
        $today = $today->format("d-m-Y");
        $datepicker_month = $date;
        $datepicker_day = $today;
        $heading = 'CV MTD DRL RESULTS FOR ' . date("F Y", strtotime($start));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start, $end) {
          $query->where('current_shop', $current_shop);
          $query->whereBetween('datetime_out', [$start, $end]);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('check_point', '=', '1')->orderBy('group_order', 'asc')->get();
        unset($shops[0], $shops[5], $shops[7], $shops[9], $shops[10], $shops[11], $shops[13]);
        $drl_arr = [];
        $unit_count = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            if ($shopid == 15 || $shopid == 16 || $shopid == 28) {
              $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();;
            } else {
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();
            }
          }
        }
        $totals_pershop = [];
        foreach ($shops as $shop) {
          $inline_units = 0;
          $offline_units = 0;
          $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
          if ($shop->id == 15 || $shop->id == 16 || $shop->id == 28) {
            $offlineunits = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->count();
            $movement_array = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('group_shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          } else {
            $offlineunits = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('shop_id', $shop->id)->count();
            $movement_array = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('group_shop_id', $shop->id)->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          }
          $drl_target = DrrTarget::where('target_type', 'Drl')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drl_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drl_target_value = $drl_shop_target->target_value;
          }
          $drl_pershop = 0;
          if ($offlineunits > 0) {
            $drl_pershop = round(($total_defects / $offlineunits) * 100);
          }
          $totals_pershop[$shop->id]['offlineunit'] = $offlineunits;
          $totals_pershop[$shop->id]['total_defects'] =  $total_defects;
          $totals_pershop[$shop->id]['target'] =  $drl_target_value;
          $totals_pershop[$shop->id]['drl_pershop'] =  $drl_pershop;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drl_arr' => $drl_arr,
          'unit_count' => $unit_count,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($start),
          'totals_pershop' => $totals_pershop,
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
          'plant_drl' => month_to_date_drl_cv($date)['drl'],
          'plant_target' => month_to_date_drl_cv($date)['drl_target_value'],
        );
        return view('productionreport.drl-month-todate')->with($data);
      }
      //end month to date 
      // end cv
    } elseif ($section == 'lcv') {
      //start lcv
      if ($period == 'today') {
        $heading = $heading = 'LCV DAILY  DIRECT RUN LOSS RESULTS FOR ' . date("d F Y", strtotime($date));
        $start = date_for_database($date);
        $first_of_month = Carbon::createFromFormat('Y-m-d', $start)->startOfMonth();
        $first_of_month = $first_of_month->format("Y-m-d");
        $datepicker_month = date("F Y", strtotime($date));
        $datepicker_day = date("d-m-Y", strtotime($date));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start) {
          $query->where('current_shop', $current_shop);
          $query->where('datetime_out', $start);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('check_point', '=', '1')->orderBy('group_order', 'asc')->get();
        unset($shops[0], $shops[1], $shops[2], $shops[3], $shops[4], $shops[5], $shops[6], $shops[7], $shops[8], $shops[10], $shops[13]);
        $drl_arr = [];
        $unit_count = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            if ($shopid == 15 || $shopid == 16 || $shopid == 28) {
              $cv_route_array = array(0 => 4, 1 => 5);
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();;
            } else {
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();
            }
          }
        }
        $totals_pershop = [];
        foreach ($shops as $shop) {
          $inline_units = 0;
          $offline_units = 0;
          $cv_route_array = array(0 => 4, 1 => 5);
          if ($shop->id == 15 || $shop->id == 16 || $shop->id == 28) {
            $offlineunits = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->count();
            $movement_array = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('group_shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          } else {
            $offlineunits = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('shop_id', $shop->id)->count();
            $movement_array = Unitmovement::where('datetime_out', $start)->where('current_shop', 0)->where('group_shop_id', $shop->id)->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          }
          $drl_target = DrrTarget::where('target_type', 'Drl')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drl_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drl_target_value = $drl_shop_target->target_value;
          }
          $drl_pershop = 0;
          if ($offlineunits > 0) {
            $drl_pershop = round(($total_defects / $offlineunits) * 100);
          }
          $totals_pershop[$shop->id]['offlineunit'] = $offlineunits;
          $totals_pershop[$shop->id]['total_defects'] =  $total_defects;
          $totals_pershop[$shop->id]['target'] =  $drl_target_value;
          $totals_pershop[$shop->id]['drl_pershop'] =  $drl_pershop;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drl_arr' => $drl_arr,
          'unit_count' => $unit_count,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
          'totals_pershop' => $totals_pershop,
          'plant_drl' => drl_today_lcv($date)['drl'],
          'plant_target' => drl_today_lcv($date)['drl_target_value'],
        );
        return view('productionreport.drl-month-todate')->with($data);
      }
      if ($period == 'month_to_date') {
        $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
        $start = $start->format("Y-m-d");
        $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
        $end = $end->format("Y-m-d");
        $today = Carbon::now();
        $today = $today->format("d-m-Y");
        $datepicker_month = $date;
        $datepicker_day = $today;
        $heading = 'LCV MTD DRL RESULTS FOR ' . date("F Y", strtotime($start));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start, $end) {
          $query->where('current_shop', $current_shop);
          $query->whereBetween('datetime_out', [$start, $end]);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('check_point', '=', '1')->orderBy('group_order', 'asc')->get();
        unset($shops[0], $shops[1], $shops[2], $shops[3], $shops[4], $shops[5], $shops[6], $shops[7], $shops[8], $shops[10], $shops[13]);
        $drl_arr = [];
        $unit_count = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            if ($shopid == 15 || $shopid == 16 || $shopid == 28) {
              $cv_route_array = array(0 => 4, 1 => 5);
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();;
            } else {
              $drl_arr[$modelid][$lot_no][$shopid]['units'] = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->count();
              $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
                $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
              })->pluck('id')->all();
              $drl_arr[$modelid][$lot_no][$shopid]['defects'] = Querydefect::whereIn('unit_movement_id', $movement_array)->where([['is_defect', '=', 'Yes']])->count();
            }
          }
        }
        $totals_pershop = [];
        foreach ($shops as $shop) {
          $inline_units = 0;
          $offline_units = 0;
          $cv_route_array = array(0 => 4, 1 => 5);
          if ($shopid == 15 || $shopid == 16 || $shopid == 28) {
            $offlineunits = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->count();
            $movement_array = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('group_shop_id', $shop->id)->whereHas('vehicle', function ($query) use ($cv_route_array) {
              $query->whereIn('route', $cv_route_array);
            })->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          } else {
            $offlineunits = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('shop_id', $shop->id)->count();
            $movement_array = Unitmovement::whereBetween('datetime_out', [$start, $end])->where('current_shop', 0)->where('group_shop_id', $shop->id)->pluck('id')->all();
            $total_defects = Querydefect::whereIn('unit_movement_id', $movement_array)->where('is_defect', 'Yes')->count();
          }
          $drl_target = DrrTarget::where('target_type', 'Drl')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drl_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drl_target_value = $drl_shop_target->target_value;
          }
          $drl_pershop = 0;
          if ($offlineunits > 0) {
            $drl_pershop = round(($total_defects / $offlineunits) * 100);
          }
          //dd( $drl_pershop );
          $totals_pershop[$shop->id]['offlineunit'] = $offlineunits;
          $totals_pershop[$shop->id]['total_defects'] =  $total_defects;
          $totals_pershop[$shop->id]['target'] =  $drl_target_value;
          $totals_pershop[$shop->id]['drl_pershop'] =  $drl_pershop;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drl_arr' => $drl_arr,
          'unit_count' => $unit_count,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($start),
          'totals_pershop' => $totals_pershop,
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
          'plant_drl' => month_to_date_drl_lcv($date)['drl'],
          'plant_target' => month_to_date_drl_lcv($date)['drl_target_value'],
        );
        return view('productionreport.drl-month-todate')->with($data);
      }
    }
    //end  lcv
  }
  //drr report
  public function drr($section, $period, $date)
  {
    $section = decrypt_data($section);
    $period = decrypt_data($period);
    $date = decrypt_data($date);
    //plant section
    if ($section == 'plant') {
      //today
      if ($period == 'today') {
        $heading = $heading = 'PLANT DAILY  DIRECT RUN RATE RESULTS FOR ' . date("d F Y", strtotime($date));
        $start = date_for_database($date);
        $first_of_month = Carbon::createFromFormat('Y-m-d', $start)->startOfMonth();
        $first_of_month = $first_of_month->format("Y-m-d");
        $datepicker_month = date("F Y", strtotime($date));
        $datepicker_day = date("d-m-Y", strtotime($date));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start) {
          $query->where('current_shop', $current_shop);
          $query->where('datetime_out', $start);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('offline', '=', '1')->where('group_order', '!=', '0')->orderBy('group_order')->get();
        $drr_arr = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            $all_units = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->count();
            $drr_arr[$modelid][$lot_no][$shopid]['units'] = $all_units;
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->pluck('vehicle_id')->all();
            $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shopid)->where([['use_drr', '=', '1']])->count();
            $okunits = $drr_arr[$modelid][$lot_no][$shopid]['units'] - $nok;
            $drr_arr[$modelid][$lot_no][$shopid]['okunits'] = $okunits;
            $drr_arr[$modelid][$lot_no][$shopid]['score'] = 0;
            if ($all_units > 0) {
              $drr_arr[$modelid][$lot_no][$shopid]['score'] = round((($okunits / $all_units) * 100), 2);
            }
          }
        }
        $plant_drr = [];
        foreach ($shops as $shop) {
          $all_units = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle')->count();
          $movement_array = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle')->pluck('vehicle_id')->all();
          $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shop->id)->where([['use_drr', '=', '1']])->count();
          $okunits = $all_units - $nok;
          $plant_drr[$shop->id]['units'] = $all_units;
          $plant_drr[$shop->id]['okunits'] = $okunits;
          $plant_drr[$shop->id]['score'] = 0;
          if ($all_units > 0) {
            $plant_drr[$shop->id]['score'] = round((($okunits / $all_units) * 100), 2);
          }
          $drl_target = DrrTarget::where('target_type', 'Drr')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drr_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drr_target_value = $drl_shop_target->target_value;
          }
          $plant_drr[$shop->id]['drr_target'] = $drr_target_value;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drr_arr' => $drr_arr,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'plant_drr_pershop' => $plant_drr,
          'plant_drr' => today_drr($date)['plant_drr'],
          'drr_target_value' => today_drr($date)['drr_target_value'],
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
        );
        return view('productionreport.drr-month-todate')->with($data);
      }
      if ($period == 'month_to_date') {
        $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
        $start = $start->format("Y-m-d");
        $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
        $end = $end->format("Y-m-d");
        $today = Carbon::now();
        $today = $today->format("d-m-Y");
        $datepicker_month = $date;
        $datepicker_day = $today;
        $heading = 'PLANT MTD DRR RESULTS FOR ' . date("F Y", strtotime($start));
        //Units Produced per month
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start, $end) {
          $query->where('current_shop', $current_shop);
          $query->whereBetween('datetime_out', [$start, $end]);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('offline', '=', '1')->where('group_order', '!=', '0')->orderBy('group_order')->get();
        $drr_arr = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $wq = compact('modelid', 'lot_no');
            $all_units = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->count();
            $drr_arr[$modelid][$lot_no][$shopid]['units'] = $all_units;
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no']);
            })->pluck('vehicle_id')->all();
            $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shopid)->where([['use_drr', '=', '1']])->count();
            $okunits = $drr_arr[$modelid][$lot_no][$shopid]['units'] - $nok;
            $drr_arr[$modelid][$lot_no][$shopid]['okunits'] = $okunits;
            $drr_arr[$modelid][$lot_no][$shopid]['score'] = 0;
            if ($all_units > 0) {
              $drr_arr[$modelid][$lot_no][$shopid]['score'] = round((($okunits / $all_units) * 100), 2);
            }
          }
        }
        $plant_drr = [];
        foreach ($shops as $shop) {
          $all_units = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle')->count();
          $movement_array = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle')->pluck('vehicle_id')->all();
          $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shop->id)->where([['use_drr', '=', '1']])->count();
          $okunits = $all_units - $nok;
          $plant_drr[$shop->id]['units'] = $all_units;
          $plant_drr[$shop->id]['okunits'] = $okunits;
          $plant_drr[$shop->id]['score'] = 0;
          if ($all_units > 0) {
            $plant_drr[$shop->id]['score'] = round((($okunits / $all_units) * 100), 2);
          }
          $drr_target = DrrTarget::where('target_type', 'Drr')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drr_target_value = 0;
          if (isset($drr_target)) {
            $drr_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drr_target->id)->first();
            $drr_target_value = $drr_shop_target->target_value;
          }
          $plant_drr[$shop->id]['drr_target'] = $drr_target_value;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drr_arr' => $drr_arr,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'plant_drr_pershop' => $plant_drr,
          'plant_drr' => month_to_date_drr($date)['plant_drr'],
          'drr_target_value' => month_to_date_drr($date)['drr_target_value'],
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
        );
        return view('productionreport.drr-month-todate')->with($data);
      }
    }
    //end plant
    elseif ($section == 'cv') {
      if ($period == 'today') {
        $heading = $heading = 'CV DAILY  DIRECT RUN RATE RESULTS FOR ' . date("d F Y", strtotime($date));
        $start = date_for_database($date);
        $first_of_month = Carbon::createFromFormat('Y-m-d', $start)->startOfMonth();
        $first_of_month = $first_of_month->format("Y-m-d");
        $datepicker_month = date("F Y", strtotime($date));
        $datepicker_day = date("d-m-Y", strtotime($date));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start) {
          $query->where('current_shop', $current_shop);
          $query->where('datetime_out', $start);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('offline', '=', '1')->where('group_order', '!=', '0')->orderBy('group_order')->get();
        $drr_arr = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
            $wq = compact('modelid', 'lot_no');
            $all_units = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
            })->count();
            $drr_arr[$modelid][$lot_no][$shopid]['units'] = $all_units;
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);;
            })->pluck('vehicle_id')->all();
            $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shopid)->where([['use_drr', '=', '1']])->count();
            $okunits = $drr_arr[$modelid][$lot_no][$shopid]['units'] - $nok;
            $drr_arr[$modelid][$lot_no][$shopid]['okunits'] = $okunits;
            $drr_arr[$modelid][$lot_no][$shopid]['score'] = 0;
            if ($all_units > 0) {
              $drr_arr[$modelid][$lot_no][$shopid]['score'] = round((($okunits / $all_units) * 100), 2);
            }
          }
        }
        $plant_drr = [];
        foreach ($shops as $shop) {
          $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
          $all_units = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($cv_route_array) {
            $query->whereIn('route', $cv_route_array);
          })->count();
          $movement_array = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($cv_route_array) {
            $query->whereIn('route', $cv_route_array);
          })->pluck('vehicle_id')->all();
          $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shop->id)->where([['use_drr', '=', '1']])->count();
          $okunits = $all_units - $nok;
          $plant_drr[$shop->id]['units'] = $all_units;
          $plant_drr[$shop->id]['okunits'] = $okunits;
          $plant_drr[$shop->id]['score'] = 0;
          if ($all_units > 0) {
            $plant_drr[$shop->id]['score'] = round((($okunits / $all_units) * 100), 2);
          }
          $drl_target = DrrTarget::where('target_type', 'Drr')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drr_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drr_target_value = $drl_shop_target->target_value;
          }
          $plant_drr[$shop->id]['drr_target'] = $drr_target_value;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drr_arr' => $drr_arr,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'plant_drr_pershop' => $plant_drr,
          'plant_drr' => today_drr_cv($date)['plant_drr'],
          'drr_target_value' => today_drr_cv($date)['drr_target_value'],
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
        );
        return view('productionreport.drr-month-todate')->with($data);
      }
      if ($period == 'month_to_date') {
        $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
        $start = $start->format("Y-m-d");
        $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
        $end = $end->format("Y-m-d");
        $today = Carbon::now();
        $today = $today->format("d-m-Y");
        $datepicker_month = $date;
        $datepicker_day = $today;
        $heading = 'PLANT MTD DRR RESULTS FOR ' . date("F Y", strtotime($start));
        //Units Produced per month
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start, $end) {
          $query->where('current_shop', $current_shop);
          $query->whereBetween('datetime_out', [$start, $end]);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('offline', '=', '1')->where('group_order', '!=', '0')->orderBy('group_order')->get();
        $drr_arr = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
            $wq = compact('modelid', 'lot_no');
            $all_units = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
            })->count();
            $drr_arr[$modelid][$lot_no][$shopid]['units'] = $all_units;
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $cv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $cv_route_array);
            })->pluck('vehicle_id')->all();
            $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shopid)->where([['use_drr', '=', '1']])->count();
            $okunits = $drr_arr[$modelid][$lot_no][$shopid]['units'] - $nok;
            $drr_arr[$modelid][$lot_no][$shopid]['okunits'] = $okunits;
            $drr_arr[$modelid][$lot_no][$shopid]['score'] = 0;
            if ($all_units > 0) {
              $drr_arr[$modelid][$lot_no][$shopid]['score'] = round((($okunits / $all_units) * 100), 2);
            }
          }
        }
        $plant_drr = [];
        foreach ($shops as $shop) {
          $cv_route_array = array(0 => 1, 1 => 2, 2 => 3);
          $all_units = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($cv_route_array) {
            $query->whereIn('route', $cv_route_array);
          })->count();
          $movement_array = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($cv_route_array) {
            $query->whereIn('route', $cv_route_array);
          })->pluck('vehicle_id')->all();
          $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shop->id)->where([['use_drr', '=', '1']])->count();
          $okunits = $all_units - $nok;
          $plant_drr[$shop->id]['units'] = $all_units;
          $plant_drr[$shop->id]['okunits'] = $okunits;
          $plant_drr[$shop->id]['score'] = 0;
          if ($all_units > 0) {
            $plant_drr[$shop->id]['score'] = round((($okunits / $all_units) * 100), 2);
          }
          $drr_target = DrrTarget::where('target_type', 'Drr')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drr_target_value = 0;
          if (isset($drr_target)) {
            $drr_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drr_target->id)->first();
            $drr_target_value = $drr_shop_target->target_value;
          }
          $plant_drr[$shop->id]['drr_target'] = $drr_target_value;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drr_arr' => $drr_arr,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'plant_drr_pershop' => $plant_drr,
          'plant_drr' => month_to_date_drr_cv($date)['plant_drr'],
          'drr_target_value' => month_to_date_drr_cv($date)['drr_target_value'],
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
        );
        return view('productionreport.drr-month-todate')->with($data);
      }
      //end cv
    } elseif ($section == 'lcv') {
      if ($period == 'today') {
        $heading = $heading = 'LCV DAILY  DIRECT RUN RATE RESULTS FOR ' . date("d F Y", strtotime($date));
        $start = date_for_database($date);
        $first_of_month = Carbon::createFromFormat('Y-m-d', $start)->startOfMonth();
        $first_of_month = $first_of_month->format("Y-m-d");
        $datepicker_month = date("F Y", strtotime($date));
        $datepicker_day = date("d-m-Y", strtotime($date));
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start) {
          $query->where('current_shop', $current_shop);
          $query->where('datetime_out', $start);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('offline', '=', '1')->where('group_order', '!=', '0')->orderBy('group_order')->get();
        $drr_arr = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $lcv_route_array = array(0 => 4, 1 => 5);
            $wq = compact('modelid', 'lot_no');
            $all_units = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $lcv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $lcv_route_array);
            })->count();
            $drr_arr[$modelid][$lot_no][$shopid]['units'] = $all_units;
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($wq, $lcv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $lcv_route_array);;
            })->pluck('vehicle_id')->all();
            $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shopid)->where([['use_drr', '=', '1']])->count();
            $okunits = $drr_arr[$modelid][$lot_no][$shopid]['units'] - $nok;
            $drr_arr[$modelid][$lot_no][$shopid]['okunits'] = $okunits;
            $drr_arr[$modelid][$lot_no][$shopid]['score'] = 0;
            if ($all_units > 0) {
              $drr_arr[$modelid][$lot_no][$shopid]['score'] = round((($okunits / $all_units) * 100), 2);
            }
          }
        }
        $plant_drr = [];
        foreach ($shops as $shop) {
          $lcv_route_array = array(0 => 4, 1 => 5);
          $all_units = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($lcv_route_array) {
            $query->whereIn('route', $lcv_route_array);
          })->count();
          $movement_array = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->where('datetime_out', $start)->whereHas('vehicle', function ($query) use ($lcv_route_array) {
            $query->whereIn('route', $lcv_route_array);
          })->pluck('vehicle_id')->all();
          $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shop->id)->where([['use_drr', '=', '1']])->count();
          $okunits = $all_units - $nok;
          $plant_drr[$shop->id]['units'] = $all_units;
          $plant_drr[$shop->id]['okunits'] = $okunits;
          $plant_drr[$shop->id]['score'] = 0;
          if ($all_units > 0) {
            $plant_drr[$shop->id]['score'] = round((($okunits / $all_units) * 100), 2);
          }
          $drl_target = DrrTarget::where('target_type', 'Drr')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drr_target_value = 0;
          if (isset($drl_target)) {
            $drl_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drl_target->id)->first();
            $drr_target_value = $drl_shop_target->target_value;
          }
          $plant_drr[$shop->id]['drr_target'] = $drr_target_value;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drr_arr' => $drr_arr,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'plant_drr_pershop' => $plant_drr,
          'plant_drr' => today_drr_lcv($date)['plant_drr'],
          'drr_target_value' => today_drr_lcv($date)['drr_target_value'],
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
        );
        return view('productionreport.drr-month-todate')->with($data);
      }
      if ($period == 'month_to_date') {
        $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
        $start = $start->format("Y-m-d");
        $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
        $end = $end->format("Y-m-d");
        $today = Carbon::now();
        $today = $today->format("d-m-Y");
        $datepicker_month = $date;
        $datepicker_day = $today;
        $heading = 'PLANT MTD DRR RESULTS FOR ' . date("F Y", strtotime($start));
        //Units Produced per month
        $current_shop = 0;
        $vehicles = vehicle_units::groupBy('lot_no', 'model_id')->whereHas('unitmovement', function ($query) use ($current_shop, $start, $end) {
          $query->where('current_shop', $current_shop);
          $query->whereBetween('datetime_out', [$start, $end]);
          return $query;
        })->get(['lot_no', 'model_id']);
        $shops = Shop::where('offline', '=', '1')->where('group_order', '!=', '0')->orderBy('group_order')->get();
        $drr_arr = [];
        foreach ($vehicles as $vehicle) {
          $modelid = $vehicle->model_id;
          $lot_no = $vehicle->lot_no;
          foreach ($shops as $shop) {
            $shopid = $shop->id;
            $lcv_route_array = array(0 => 4, 1 => 5);
            $wq = compact('modelid', 'lot_no');
            $all_units = Unitmovement::where([['shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $lcv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $lcv_route_array);
            })->count();
            $drr_arr[$modelid][$lot_no][$shopid]['units'] = $all_units;
            $movement_array = Unitmovement::where([['group_shop_id', '=', $shopid], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($wq, $lcv_route_array) {
              $query->where('model_id', $wq['modelid'])->where('lot_no', $wq['lot_no'])->whereIn('route', $lcv_route_array);
            })->pluck('vehicle_id')->all();
            $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shopid)->where([['use_drr', '=', '1']])->count();
            $okunits = $drr_arr[$modelid][$lot_no][$shopid]['units'] - $nok;
            $drr_arr[$modelid][$lot_no][$shopid]['okunits'] = $okunits;
            $drr_arr[$modelid][$lot_no][$shopid]['score'] = 0;
            if ($all_units > 0) {
              $drr_arr[$modelid][$lot_no][$shopid]['score'] = round((($okunits / $all_units) * 100), 2);
            }
          }
        }
        $plant_drr = [];
        foreach ($shops as $shop) {
          $lcv_route_array = array(0 => 4, 1 => 5);
          $all_units = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($lcv_route_array) {
            $query->whereIn('route', $lcv_route_array);
          })->count();
          $movement_array = Unitmovement::where([['shop_id', '=', $shop->id], ['current_shop', '=', 0]])->whereBetween('datetime_out', [$start, $end])->whereHas('vehicle', function ($query) use ($lcv_route_array) {
            $query->whereIn('route', $lcv_route_array);
          })->pluck('vehicle_id')->all();
          $nok = Drr::whereIn('vehicle_id', $movement_array)->where('shop_id', $shop->id)->where([['use_drr', '=', '1']])->count();
          $okunits = $all_units - $nok;
          $plant_drr[$shop->id]['units'] = $all_units;
          $plant_drr[$shop->id]['okunits'] = $okunits;
          $plant_drr[$shop->id]['score'] = 0;
          if ($all_units > 0) {
            $plant_drr[$shop->id]['score'] = round((($okunits / $all_units) * 100), 2);
          }
          $drr_target = DrrTarget::where('target_type', 'Drr')->where('fromdate', '<=', $start)->where('todate', '>=', $start)->first();
          $drr_target_value = 0;
          if (isset($drr_target)) {
            $drr_shop_target = DrrTargetShop::where('shop_id', $shop->id)->where('target_id', $drr_target->id)->first();
            $drr_target_value = $drr_shop_target->target_value;
          }
          $plant_drr[$shop->id]['drr_target'] = $drr_target_value;
        }
        $data = array(
          'heading' => $heading,
          'shops' => $shops,
          'vehicles' => $vehicles,
          'drr_arr' => $drr_arr,
          'section' => encrypt_data($section),
          'period' => encrypt_data($period),
          'date' => encrypt_data($date),
          'plant_drr_pershop' => $plant_drr,
          'plant_drr' => month_to_date_drr_lcv($date)['plant_drr'],
          'drr_target_value' => month_to_date_drr_lcv($date)['drr_target_value'],
          'datepicker_month' => $datepicker_month,
          'datepicker_day' => $datepicker_day,
        );
        return view('productionreport.drr-month-todate')->with($data);
      }
    }
  }
  public function filterdailydrl(Request $request)
  {
    if ($request->period == 'today') {
      $section = encrypt_data($request->section);
      $period = encrypt_data($request->period);
      $date = encrypt_data($request->daily_date);
      return redirect()->route('drl', ['section' => $section, 'period' => $period, 'date' => $date]);
    } elseif ($request->period == 'month_to_date') {
      $section = encrypt_data($request->section);
      $period = encrypt_data($request->period);
      $date = encrypt_data($request->month_date);
      return redirect()->route('drl', ['section' => $section, 'period' => $period, 'date' => $date]);
    }
  }
  public function filterdailydrr(Request $request)
  {
    if ($request->period == 'today') {
      $section = encrypt_data($request->section);
      $period = encrypt_data($request->period);
      $date = encrypt_data($request->daily_date);
      return redirect()->route('drr', ['section' => $section, 'period' => $period, 'date' => $date]);
    } elseif ($request->period == 'month_to_date') {
      $section = encrypt_data($request->section);
      $period = encrypt_data($request->period);
      $date = encrypt_data($request->month_date);
      return redirect()->route('drr', ['section' => $section, 'period' => $period, 'date' => $date]);
    }
  }
  public function exportdrl($section, $from, $to, $target_id)
  {
    $data = array();
    $data['section'] = $section;
    $data['from'] = $from;
    $data['to'] = $to;
    $data['target_id'] = $target_id;
    return Excel::download(new DrlExport($data), '' . decrypt_data($section) . '_DRL_Report.xlsx');
  }
  public function exportdrr($section, $from, $to, $target_id)
  {
    $data = array();
    $data['section'] = $section;
    $data['from'] = $from;
    $data['to'] = $to;
    $data['target_id'] = $target_id;
    //dd($data);
    return Excel::download(new DrrExport($data), '' . decrypt_data($section) . '_DRR_Report.xlsx');
  }
  public function defectsummary(Request $request)
  {
    if (count($request->all())) {
      $from = date_for_database($request->from_custom_date_single);
      $to = date_for_database($request->to_custom_date_single);
      $heading = 'DEFECT  SUMMARY FROM <span class="text-warning">' . $request->from_custom_date_single . ' </span>  TO <span class="text-warning">' . $request->to_custom_date_single . '</span> ';
      $start_date = date('Y-m-d 00:00:00', strtotime($from));
      $end_date = date('Y-m-d 23:59:59', strtotime($to));
      $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date]);
      $defects->when(request('shop_id'), function ($defects) {
        return $defects->where('shop_id', '=', request('shop_id', 0));
      });
      $defects->when(request('is_defect'), function ($defects) {
        return $defects->where('is_defect', '=', request('is_defect', 0));
      });
      $defects = $defects->get();
    } else {
      $heading = 'MTD  DEFECT SUMMARY FOR <span class="text-warning"> ' . date('F Y') . '</span>';
      $startDate = Carbon::now(); //returns current day
      $endDate = Carbon::now(); //returns current day
      $firstDay = $startDate->firstOfMonth();
      $endDay = $endDate->endOfMonth();
      $start = $firstDay->format("Y-m-d");
      $end = $endDay->format("Y-m-d");
      //target
      $today = Carbon::now();
      $today = $today->format("Y-m-d");
      $start_date = date('Y-m-d 00:00:00', strtotime($start));
      $end_date = date('Y-m-d 23:59:59', strtotime($end));
      $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->get();
    }
    $shops = Shop::where('check_point', '=', '1')->get();
    $shopselect = Shop::where('check_point', 1)->pluck('shop_name', 'id');
    $shopdata = [];
    foreach ($shops as  $shop) {
      $shopdata[] = array(
        'value' => $shop->id,
        'text' => $shop->shop_name,
      );
    }
    $floatsettings = FloatSetting::get();
    $defectcategory = [];
    foreach ($floatsettings as  $floatsetting) {
      $defectcategory[] = array(
        'value' => $floatsetting->float_name,
        'text' => $floatsetting->float_name,
      );
    }
    $data = array(
      'heading' => $heading,
      'defects' => $defects,
      'shops' => json_encode($shopdata),
      'shops' => $shopselect,
      'defectcategory' => json_encode($defectcategory),
    );
    return view('defects.index')->with($data);;
  }
  public function drrlist(Request $request)
  {
    if (count($request->all())) {
      $from = date_for_database($request->from_custom_date_single);
      $to = date_for_database($request->to_custom_date_single);
      $heading = 'DRR  LIST FROM <span class="text-warning">' . $request->from_custom_date_single . ' </span>  TO <span class="text-warning">' . $request->to_custom_date_single . '</span> ';
      $start_date = date('Y-m-d 00:00:00', strtotime($from));
      $end_date = date('Y-m-d 23:59:59', strtotime($to));
      if ($request->shop == 'mpa') {
        $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->where('mpa_drr', '1')->get();
      } else if ($request->shop == 'mpb') {
        $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->where('mpb_drr', '1')->get();
      } else if ($request->shop == 'mpc') {
        $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->where('mpc_drr', '1')->get();
      } else {
        $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->where('mpa_drr', '1')
          ->orWhere(function ($query) use ($start_date, $end_date) {
            $query->where('mpb_drr', 1)
              ->whereBetween('created_at', [$start_date, $end_date]);
          })
          ->orWhere(function ($query) use ($start_date, $end_date) {
            $query->where('mpc_drr', 1)
              ->whereBetween('created_at', [$start_date, $end_date]);
          })->get();
      }
    } else {
      $heading = 'MTD  DRR LIST  FOR <span class="text-warning"> ' . date('F Y') . '</span>';
      $startDate = Carbon::now(); //returns current day
      $endDate = Carbon::now(); //returns current day
      $firstDay = $startDate->firstOfMonth();
      $endDay = $endDate->endOfMonth();
      $start = $firstDay->format("Y-m-d");
      $end = $endDay->format("Y-m-d");
      //target
      $today = Carbon::now();
      $today = $today->format("Y-m-d");
      $start_date = date('Y-m-d 00:00:00', strtotime($start));
      $end_date = date('Y-m-d 23:59:59', strtotime($end));
      $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->where('mpa_drr', '1')
        ->orWhere(function ($query) use ($start_date, $end_date) {
          $query->where('mpb_drr', 1)
            ->whereBetween('created_at', [$start_date, $end_date]);
        })
        ->orWhere(function ($query) use ($start_date, $end_date) {
          $query->where('mpc_drr', 1)
            ->whereBetween('created_at', [$start_date, $end_date]);
        })->get();
    }
    $shops = Shop::where('check_point', '=', '1')->get();
    $shopdata = [];
    foreach ($shops as  $shop) {
      $shopdata[] = array(
        'value' => $shop->id,
        'text' => $shop->shop_name,
      );
    }
    $floatsettings = FloatSetting::get();
    $defectcategory = [];
    foreach ($floatsettings as  $floatsetting) {
      $defectcategory[] = array(
        'value' => $floatsetting->float_name,
        'text' => $floatsetting->float_name,
      );
    }
    //$thismonth=Carbon::now();
    //$thismonth=$today->format("F Y");
    //$thisyear=$today->format("Y");
    $data = array(
      'heading' => $heading,
      //  'record'=>$record,
      //'date'=>$date, 
      'defects' => $defects,
      'shops' => json_encode($shopdata),
      'defectcategory' => json_encode($defectcategory),
    );
    return view('drrlist.index')->with($data);;
  }
  public function updatedefect(Request $request, $id)
  {
    if (decrypt_data($id) == 'gca') {
      if ($request->ajax()) {
        Querydefect::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
        return response()->json(['success' => true, 'data' => $request->input('name')]);
      }
    } else if (decrypt_data($id) == 'shop') {
      if ($request->ajax()) {
        Queryanswer::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
        return response()->json(['success' => true, 'data' => $request->input('name')]);
      }
    } elseif (decrypt_data($id) == 'defect_category') {
      if ($request->ajax()) {
        Querydefect::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
        return response()->json(['success' => true, 'data' => $request->input('name')]);
      }
    } elseif (decrypt_data($id) == 'stakeholder') {
      if ($request->ajax()) {
        Querydefect::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
        return response()->json(['success' => true, 'data' => $request->input('name')]);
      }
    }
  }
  public function filterdefect(Request $request)
  {
    // filter difect
    $fromdate = encrypt_data($request->from_custom_date_single);
    $todate = encrypt_data($request->to_custom_date_single);
    return redirect()->route('defectsummary', ['from' => $fromdate, 'to' => $todate]);
  }
  public function filterdrrdefect(Request $request)
  {
    // filter monthly difect
    $date = encrypt_data($request->month_date);
    $record = encrypt_data($request->record);
    return redirect()->route('drrlist', ['from' => $date, 'to' => $record]);
  }
  public function updatedrr(Request $request, $id)
  {
    if ($request->ajax()) {
      $updatedata = Querydefect::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
      //book drr and if not booked
      if ($updatedata) {
        $units_details = Querydefect::find($request->input('pk'));
        if ($request->input('name') == 'mpb_drr') {
          $shop_id = 15;
          $count_defects = Querydefect::where('vehicle_id', $units_details->vehicle_id)->where('mpb_drr', '1')->count();
        } else if ($request->input('name') == 'mpc_drr') {
          $shop_id = 16;
          $count_defects = Querydefect::where('vehicle_id', $units_details->vehicle_id)->where('mpc_drr', '1')->count();
        } else {
          $shop_id = 28;
          $count_defects = Querydefect::where('vehicle_id', $units_details->vehicle_id)->where('mpa_drr', '1')->count();
        }
        $drrrecord = array();
        if ($count_defects > 0) {
          $drr_exist = $this->check_drr($units_details->vehicle_id, $shop_id);
          if (!$drr_exist) {
            $drrrecord['vehicle_id'] = $units_details->vehicle_id;
            $drrrecord['shop_id'] = $shop_id;
            $drrrecord['is_app_or_system'] = 1;
            $drrrecord['done_by'] = auth()->user()->id;
            $drrsave = Drr::create($drrrecord);
          } else {
            //existing but status changed
            $v_update = Drr::where('vehicle_id', $units_details->vehicle_id);
            $v_update->update(['use_drr' => '1']);
          }
        } else {
          $v_update = Drr::where('vehicle_id', $units_details->vehicle_id);
          $v_update->update(['use_drr' => '0']);
        }
      }
      return response()->json(['success' => true, 'data' => $request->input('name')]);
    }
  }
  public function check_drr($value, $value1)
  {
    return  Drr::where('vehicle_id', $value)->where('shop_id', $value1)->exists();
  }
  public function changedefect($id)
  {
    if (request()->ajax()) {
      return view('defects.changedefect')->with(compact('id'));
    }
  }
  public function savechangedefect(Request $request)
  {
    if (request()->ajax()) {
      $data = $request->only(['is_defect', 'correct_value', 'defect_id']);
      $validator = Validator::make($request->all(), [
        'is_defect' => 'bail|required|max:20',
        'correct_value' => 'required',
      ]);
      // Check validation failure
      if ($validator->fails()) {
        $output = [
          'success' => false,
          'msg' => "It appears you have forgotten to complete something",
        ];
        return $output;
        exit;
      }
      DB::beginTransaction();
      try {
        $defect = Querydefect::find($request->defect_id);
        $queryanswer = Queryanswer::find($defect->query_anwer_id);
        if ($request->is_defect == 'Yes') {
          //change answer
          $queryanswer->answer = $request->correct_value;
          $queryanswer->save();
          if ($defect->mpa_drr == 1) {
            $shop_id = 28;
            $drr = Drr::where('vehicle_id', $defect->vehicle_id)->where('shop_id', $shop_id)->first();
            $drr->delete();
          } else if ($defect->mpb_drr == 1) {
            $shop_id = 15;
            $drr = Drr::where('vehicle_id', $defect->vehicle_id)->where('shop_id', $shop_id)->first();
            $drr->delete();
          } else if ($defect->mpc_drr == 1) {
            $shop_id = 16;
            $drr = Drr::where('vehicle_id', $defect->vehicle_id)->where('shop_id', $shop_id)->first();
            $drr->delete();
          }
          //delete defect
          $defect->delete();
        } else {
          //change answer given
          $queryanswer->answer = $request->correct_value;
          $queryanswer->save();
          //change defect
          $defect->defect_name = $request->correct_value;
          $defect->save();
        }
        DB::commit();
        $output = [
          'success' => true,
          'msg' => "Defect Corrected   Successfully"
        ];
      } catch (\Exception $e) {
        \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
        $output = [
          'success' => false,
          'msg' => $e->getMessage(),
        ];
      }
    }
    return $output;
  }
}
