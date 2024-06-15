<?php

namespace App\Http\Controllers\gcareports;

use App\Http\Controllers\Controller;
use App\Http\Controllers\gcaauditreportcategory\GcaAuditReportCategoryController;
use App\Models\discrepancyweight\DiscrepancyWeight;
use App\Models\gcaauditcategory\GcaAuditReportCategory;
use App\Models\gcaqueryanswer\GcaQueryAnswer;
use App\Models\gcatarget\GcaTarget;
use App\Models\shop\Shop;
use App\Models\unitmovement\Unitmovement;
use App\Models\vehicle_units\vehicle_units;
use App\Models\vehicletype\VehicleType;
use DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use View;

class GcaReportsController extends Controller
{
    //
    public function gcarawdata(Request $request)
    {
        try {
            if ($request->input()) {
                $daterange = $request->input('daterange');
                $datearr = explode('-', $daterange);
                $datefrom = Carbon::parse($datearr[0])->format('Y-m-d');
                $dateto = Carbon::parse($datearr[1])->format('Y-m-d');
                $period = CarbonPeriod::create($datefrom, $dateto);
                $dates = [];
                foreach ($period as $date) {
                    $dates[] = array(
                        'date_formated' => $date->format('jS'),
                        'date_db' => $date->format('Y-m-d'),
                        'dayOfTheWeek' => Carbon::parse($date->format('Y-m-d'))->dayOfWeek,
                    );
                }
                $vehicletype = VehicleType::get();
                $data = array(
                    'today' => Carbon::today()->format('j M Y'),
                    'daterange' => $daterange,
                    'vehicletype' => $vehicletype,
                );
                return view('gcareports.rawdata')->with($data);
            }
            return view('gcareports.rawdata');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function printgcarawdata($vehicle_type, $date_range)
    {
        try {
            $vehicletype = decrypt_data($vehicle_type);
            $daterange = $date_range;
            $datearr = explode('-', decrypt_data($daterange));
            $datefrom = Carbon::parse($datearr[0])->format('Y-m-d');
            $dateto = Carbon::parse($datearr[1])->format('Y-m-d');
            $period = CarbonPeriod::create($datefrom, $dateto);
            $categories = GcaAuditReportCategory::get();
            $weighteddefects = DiscrepancyWeight::where('vehicle_type', $vehicletype)->get();
            if ($vehicletype == 'CV') {
                $total_vehicles = vehicle_units::where('gca_audit_complete', 1)->whereBetween('gca_completion_date', [$datefrom, $dateto])->whereHas('model', function ($query) {
                    $query->where('vehicle_type_id', '1')->orWhere('vehicle_type_id', '2');
                })->with(['model' => function ($q) {
                    $q->where('vehicle_type_id', '1')->orWhere('vehicle_type_id', '2');
                }])->count();
            } else {
                $total_vehicles = vehicle_units::where('gca_audit_complete', 1)->whereBetween('gca_completion_date', [$datefrom, $dateto])->whereHas('model', function ($query) {
                    $query->where('vehicle_type_id', '3')->orWhere('vehicle_type_id', '4');
                })->with(['model' => function ($q) {
                    $q->where('vehicle_type_id', '3')->orWhere('vehicle_type_id', '4');
                }])->count();
            }
            //  $gcaanswers = GcaQueryAnswer::where('vehicle_type_id',$vehicle_type)->get();
            $gcaanswers = GcaQueryAnswer::where('vehicle_type', $vehicletype)->with(['vehicle' => function ($query) use ($datefrom, $dateto) {
                $query->whereBetween('gca_completion_date', [$datefrom, $dateto]);
                $query->where('gca_audit_complete', '1');
            }])->whereHas('vehicle', function ($query) use ($datefrom, $dateto) {
                $query->whereBetween('gca_completion_date', [$datefrom, $dateto]);
                $query->where('gca_audit_complete', '1');
            })->get();
            $dates = [];
            $master = [];
            $mastercategory = [];
            $mastercategorycount = [];
            $masterperdatecount = [];
            $masterdpvcount = [];
            $masterwdpv = [];
            $masterdpvtotal = [];
            $masterdatetotal = [];
            $test = [];
            foreach ($period as $date) {
                $rdate = $date->format('Y-m-d');
                $totaldatecat = 0;
                foreach ($categories as  $cat) {
                    $cat_id = $cat->id;
                    $totalweight = 0;
                    $totalweightcat = 0;
                    foreach ($weighteddefects as  $weighteddefect) {
                        $weight = $weighteddefect->factor;
                        $count = 0;
                        $catcount = 0;
                        $weightcount = 0;
                        $dpvcount = 0;
                        $totaldpvcount = 0;
                        foreach ($gcaanswers as $answer) {
                            $dbdate = $answer->vehicle->gca_completion_date;
                            //  $dbdate=$dbdate->format('Y-m-d');
                            if ($rdate == $dbdate &&  $answer->weight == $weight && $answer->gca_audit_report_category_id == $cat_id) {
                                $dpv = $answer->defect_count;
                                $count += $dpv;
                            } else {
                                $count;
                            }
                            if ($rdate == $dbdate &&  $answer->gca_audit_report_category_id == $cat_id) {
                                $dpv = $answer->defect_count;
                                $catcount += $dpv;
                            } else {
                                $catcount;
                            }
                            if ($answer->weight == $weight && $answer->gca_audit_report_category_id == $cat_id) {
                                $weightcount++;
                            } else {
                                $weightcount;
                            }
                            if ($answer->gca_audit_report_category_id == $cat_id) {
                                $dpvcount++;
                            } else {
                                $dpvcount;
                            }
                            if ($rdate == $dbdate) {
                                $totaldpvcount++;
                            } else {
                                $totaldpvcount;
                            }
                        }
                        $master[$rdate][$cat_id][$weight] = $count;
                        $totalweight += $count * $weight;
                        $masterperdatecount[$cat_id][$weight] = $weightcount;
                        $totalweightcat += $weightcount * $weight;
                        $masterdpvtotal[$rdate] = $totaldpvcount;
                    }
                    $mastercategorycount[$rdate][$cat_id] = $catcount;
                    $mastercategory[$rdate][$cat_id] = $totalweight;
                    $masterdpvcount[$cat_id] = $dpvcount;
                    $masterwdpv[$cat_id] = $totalweightcat;
                    $totaldatecat += $totalweight;
                }
                //end Category
                $masterdatetotal[$rdate] = $totaldatecat;
                $dates[] = array(
                    'date_formated' => $date->format('jS'),
                    'date_db' => $date->format('Y-m-d'),
                    'dayOfTheWeek' => Carbon::parse($date->format('Y-m-d'))->dayOfWeek,
                );
            }
            //dd($master);
            $range = Carbon::createFromFormat('Y-m-d', $datefrom)->format('jS M Y') . ' To ' . Carbon::createFromFormat('Y-m-d', $dateto)->format('jS M Y');
            $data = array(
                'master' => $master,
                'range' => $range,
                'dates' => $dates,
                'categories' => $categories,
                'weighteddefects' => $weighteddefects,
                'mastercategory' => $mastercategory,
                'mastercategorycount' => $mastercategorycount,
                'vehicletype' => $vehicletype,
                'masterperdatecount' => $masterperdatecount,
                'masterdpvcount' => $masterdpvcount,
                'masterwdpv' => $masterwdpv,
                'masterdpvtotal' => $masterdpvtotal,
                'masterdatetotal' => $masterdatetotal,
            );
            /* $html = view('gcareports.rawdatapdf', $data)->render();
            $pdf = new \Mpdf\Mpdf(config('pdflandscape'));
           // $pdf->SetWatermarkText($approved);
           //;
            $pdf->WriteHTML($html);
            $headers = array(
                "Content-type" => "application/pdf",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            );
           return Response::stream($pdf->Output('gcareport.pdf', 'I'), 200, $headers);*/
            return view('gcareports.rawdatapdf')->with($data);
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function gcapreweek(Request $request)
    {
        try {
            if ($request->input()) {
                $vehicletype = $request->input('vehicle_type');
                $date = $request->input('date');
                $dateto = Carbon::parse($date)->format('Y-m-d');
                $datefrom = Carbon::parse($date)->subWeeks(4)->format('Y-m-d');
                $categories = GcaAuditReportCategory::get();
                $vehicletype = VehicleType::where('vehicletypev', $vehicletype)->get();
                $typetotal = [];
                $total = 0;
                $answertypetotal = [];
                $typegrandtotal = 0;
                foreach ($vehicletype as $row) {
                    $vt_id = $row->id;
                    $typetotal[$vt_id] = Unitmovement::whereHas('models', function ($query) use ($vt_id) {
                        $query->where('vehicle_type_id', $vt_id);
                    })->where('shop_id', 16)->whereBetween('datetime_out', [$datefrom, $dateto])->count();
                    $total += $typetotal[$vt_id];
                    $answertypetotal[$vt_id] = GcaQueryAnswer::where('vehicle_type_id', $vt_id)->whereDate('created_at', '>', $datefrom)->whereDate('created_at', '<', $dateto)->sum('weight');
                    $typegrandtotal += $typetotal[$vt_id] * $answertypetotal[$vt_id];
                }
                //  dd( $typegrandtotal);
                /*
                $typetotal[1]=Unitmovement::whereHas('models', function ($query)  {
                    $query->where('vehicle_type_id',1);
                })->where('shop_id',16)->whereBetween('datetime_out', [$datefrom, $dateto])->count();
                $typetotal[2]=Unitmovement::whereHas('models', function ($query)  {
                    $query->where('vehicle_type_id',2);
                })->where('shop_id',16)->whereBetween('datetime_out', [$datefrom, $dateto])->count();*/
                // dd( $total);
                //dd( $typetotal[1]+$typetotal[2]);
                $vehicle_type_array = $vehicletype->pluck('id');
                $gcaanswers = GcaQueryAnswer::whereIn('vehicle_type_id', $vehicle_type_array)->whereDate('created_at', '>', $datefrom)->whereDate('created_at', '<', $dateto)->get();
                $master = [];
                $mastertotal = [];
                foreach ($vehicletype as $type) {
                    $vtype = $type->id;
                    foreach ($categories as $cat) {
                        $cat_id = $cat->id;
                        $count = 0;
                        foreach ($gcaanswers as $answer) {
                            if ($answer->gca_audit_report_category_id == $cat_id && $answer->vehicle_type_id == $vtype) {
                                $count = 0;
                            } else {
                                $count;
                            }
                        }
                        $master[$vtype][$cat_id] = $count;
                        $mastertotal[$vtype][$cat_id] = $count * $typetotal[$vtype];
                    }
                }
                $data = array(
                    'date' => $date,
                    'datefrom' => $datefrom,
                    'vehicletypes' => $vehicletype,
                    'categories' => $categories,
                    'master' => $master,
                    'typetotal' => $typetotal,
                    'mastertotal' => $mastertotal,
                    'gcatotal' => $total,
                    'answertypetotal' => $answertypetotal,
                    'typegrandtotal' => $typegrandtotal
                );
                return view('gcareports.preweek')->with($data);
            }
            return view('gcareports.preweek');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function gcasamplesize(Request $request)
    {
        try {
            if ($request->input()) {
                $vehicletype = $request->input('vehicle_type');
                $date = date_for_database($request->input('date'));
                $datefrom = Carbon::parse($date)->subWeeks(3);
                $dateto = Carbon::parse($date)->subWeeks(3);
                $vehicletype = VehicleType::where('vehicletypev', $vehicletype)->get();
                $master = [];
                $gtotal = 0;
                $stotal = 0;
                $sumatyperray = array();
                $sumitemrray = array();
                $sumtsampledrray = array();
                for ($i = 1; $i < 5; $i++) {
                    $start_of_week = $datefrom->startOfWeek();
                    $end_of_week = $dateto->endOfWeek();
                    $period = CarbonPeriod::create($start_of_week, $end_of_week);
                    foreach ($period as $dates) {
                        $dateloop = $dates->toDateString();
                        $master[$i]['datesarray'][] = $dateloop;
                        $checkproductday = Unitmovement::wheredate('datetime_out',  $dates->toDateString())->exists();
                        $master[$i]['productionday'][] = ($checkproductday) ? 2 : 0;
                        $master[$i]['totalunitssampled'][] = GcaQueryAnswer::whereDate('created_at', $dates->toDateString())->count(DB::raw('DISTINCT vehicle_id'));
                        foreach ($vehicletype as $row) {
                            $vt_id = $row->id;
                            $totals = Unitmovement::whereHas('models', function ($query) use ($vt_id) {
                                $query->where('vehicle_type_id', $vt_id);
                            })->where('shop_id', 16)->wheredate('datetime_out',  $dates->toDateString())->count();
                            $master[$i][$vt_id]['typetotal'][] = $totals;
                            $sample = GcaQueryAnswer::where('vehicle_type_id', $vt_id)->whereDate('created_at', $dates->toDateString())->count(DB::raw('DISTINCT vehicle_id'));
                            $master[$i][$vt_id]['unitssampled'][] = $sample;
                            if (!isset($sumitemrray[$dateloop])) {
                                $sumitemrray[$dateloop] = $totals;
                            } else {
                                $sumitemrray[$dateloop] += $totals;
                            }
                            if (!isset($sumatyperray[$vt_id])) {
                                $sumatyperray[$vt_id] = $totals;
                            } else {
                                $sumatyperray[$vt_id] += $totals;
                            }
                            if (!isset($sumtsampledrray[$vt_id])) {
                                $sumtsampledrray[$vt_id] = $sample;
                            } else {
                                $sumtsampledrray[$vt_id] += $sample;
                            }
                            $gtotal += $totals;
                            $stotal += $sample;
                        }
                    }
                    $datefrom->addWeek(1);
                    $dateto->addWeek(1);
                }
                // dd($date);
                $data = array(
                    'date' => $request->input('date'),
                    'vtpype' => $request->input('vehicle_type'),
                    'vehicletypes' => $vehicletype,
                    'master' => $master,
                    'sumitemrray' => $sumitemrray,
                    'sumatyperray' => $sumatyperray,
                    'gtotal' => $gtotal,
                    'stotal' => $stotal,
                    'sumtsampledrray' => $sumtsampledrray,
                );
                return view('gcareports.samplesize')->with($data);
            }
            return view('gcareports.samplesize');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function reportbycar(Request $request)
    {
        try {
            if ($request->input()) {
                $vehicletype = $request->input('vehicle_type');
                $date = date_for_database($request->input('date'));
                $carnumber = $request->input('car_number');
                $data = GcaQueryAnswer::where('vehicle_type', $vehicletype)->where('car_number', $carnumber)->whereDate('created_at', $date)->get();
                $wdpv = GcaQueryAnswer::where('vehicle_type', $vehicletype)->where('car_number', $carnumber)->whereDate('created_at', $date)->sum('weight');
                $dpv = GcaQueryAnswer::where('vehicle_type', $vehicletype)->where('car_number', $carnumber)->whereDate('created_at', $date)->count('weight');
                $dweights = DiscrepancyWeight::where('vehicle_type', $vehicletype)->get();
                $auditcategories = GcaAuditReportCategory::get();
                $master = [];
                $sumtdpv = array();
                $sumwdpv = array();
                $sumgwdpv = array();
                $sumgdpv = 0;
                $sumgwpv = 0;
                foreach ($dweights as $dweight) {
                    $weightv = $dweight->factor;
                    foreach ($auditcategories as $auditcategory) {
                        $cat_id = $auditcategory->id;
                        $wdpvcount = 0;
                        $wdpvweight = 0;
                        $wdpvweightsum = 0;
                        foreach ($data as $row) {
                            if ($row->gca_audit_report_category_id == $cat_id && $row->weight == $weightv) {
                                $wdpvcount++;
                            } else {
                                $wdpvcount;
                            }
                            if ($row->gca_audit_report_category_id == $cat_id && $row->weight == $weightv) {
                                $wdpvweight = $row->weight;
                                $wdpvweightsum += $row->weight;
                            }
                        }
                        $master[$weightv][$cat_id]['wdpvdpv'] = $wdpvweight * $wdpvcount;
                        if (!isset($sumtdpv[$cat_id])) {
                            $sumtdpv[$cat_id] = $wdpvcount;
                        } else {
                            $sumtdpv[$cat_id] += $wdpvcount;
                        }
                        if (!isset($sumwdpv[$cat_id])) {
                            $sumwdpv[$cat_id] = $wdpvweightsum;
                        } else {
                            $sumwdpv[$cat_id] += $wdpvweightsum;
                        }
                        if (!isset($sumgdpv)) {
                            $sumgdpv = $wdpvcount;
                        } else {
                            $sumgdpv += $wdpvcount;
                        }
                        if (!isset($sumgwpv)) {
                            $sumgwpv = $wdpvweightsum;
                        } else {
                            $sumgwpv += $wdpvweightsum;
                        }
                        if (!isset($sumgwdpv[$weightv])) {
                            $sumgwdpv[$weightv] = $wdpvweightsum;
                        } else {
                            $sumgwdpv[$weightv] += $wdpvweightsum;
                        }
                    }
                }
                // dd($sumwdpv);
                $data = array(
                    'date' => $request->input('date'),
                    'vtpype' => $request->input('vehicle_type'),
                    'cnumber' => $request->input('car_number'),
                    'datas' => $data,
                    'wdpv' => $wdpv,
                    'dpv' => $dpv,
                    'master' => $master,
                    'dweights' => $dweights,
                    'auditcategories' => $auditcategories,
                    'sumtdpv' => $sumtdpv,
                    'sumwdpv' => $sumwdpv,
                    'sumgdpv' => $sumgdpv,
                    'sumgwpv' => $sumgwpv,
                    'sumgwdpv' => $sumgwdpv,
                );
                return view('gcareports.reportbycar')->with($data);
            }
            return view('gcareports.reportbycar');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function reportbyyear(Request $request)
    {
        try {
            if ($request->input()) {
                $vehicletype = $request->input('vehicle_type');
                $year = $request->input('date');
                $months = [];
                $year_start = Carbon::createFromDate($year, 1, 1)->startOfYear()->format('Y-m-d');
                $year_end = Carbon::createFromDate($year, 12, 31)->endOfYear()->format('Y-m-d');
                $gcaanswers = GcaQueryAnswer::whereDate('created_at', '>', $year_start)->whereDate('created_at', '<', $year_end)->get();
                $dweights = DiscrepancyWeight::where('vehicle_type', $vehicletype)->get();
                $samples = GcaQueryAnswer::whereDate('created_at', '>', $year_start)->whereDate('created_at', '<', $year_end)->get(DB::raw('DISTINCT vehicle_id'));
                $pgcaanswers = GcaQueryAnswer::where('gca_audit_report_category_id', 3)->whereDate('created_at', '>', $year_start)->whereDate('created_at', '<', $year_end)->count();
                //$uniqueItems = collect($gcaanswers->toArray())->unique('vehicle_id');
                // Loop through all 12 months of the selected year
                $master = [];
                $sumdefects = array();
                $sumpdefects = array();
                $sumpvehivle = array();
                foreach (CarbonPeriod::create("$year-01-01", "$year-12-31")->months() as $month) {
                    $month_start = $month->startOfMonth()->format('Y-m-d'); // Get start of the month date
                    $month_end = $month->endOfMonth()->format('Y-m-d'); // Get end of the month date
                    foreach ($dweights as $dweight) {
                        $weightv = $dweight->factor;
                        $countdpv = 0;
                        $counttotaldpv = 0;
                        $countpdefect = 0;
                        $countvehicles = 0;
                        foreach ($gcaanswers as $row) {
                            // && $row->weight==$weightv
                            if (strtotime($row->created_at) > strtotime($month_start) &&  strtotime($row->created_at) < strtotime($month_end) && $row->weight == $weightv) {
                                $countdpv++;
                            } else {
                                $countdpv;
                            }
                            if (strtotime($row->created_at) > strtotime($month_start) &&  strtotime($row->created_at) < strtotime($month_end)  && $row->weight == $weightv  && $row->gca_audit_report_category_id = 3) {
                                $countpdefect++;
                            } else {
                                $countpdefect;
                            }
                            if (strtotime($row->created_at) > strtotime($month_start) &&  strtotime($row->created_at) < strtotime($month_end)  && $row->weight == $weightv  && $row->gca_query_item_id = 3) {
                                $countvehicles++;
                            } else {
                                $countvehicles;
                            }
                            if ($row->weight == $weightv) {
                                $counttotaldpv++;
                            } else {
                                $counttotaldpv;
                            }
                            //  $months[]=date_for_database($row->created_at);
                            $master[$month->format('M')][$weightv]['dpv'] = $countdpv;
                            $master[$month->format('M')][$weightv]['paint'] = $countpdefect;
                            $master[$month->format('M')][$weightv][$row->vehicle_id]['vaudited'] = $countpdefect;
                            $master[$weightv]['totaldpv'] = $counttotaldpv;
                        }
                        foreach ($gcaanswers as $uniqueItem) {
                            if (strtotime($uniqueItem['created_at']) > strtotime($month_start) &&  strtotime($uniqueItem['created_at']) < strtotime($month_end)) {
                                $sumpvehivle[$month->format('M')][] = $uniqueItem['vehicle_id'];
                            }
                        }
                        if (!isset($sumdefects[$month->format('M')])) {
                            $sumdefects[$month->format('M')] = $countdpv;
                        } else {
                            $sumdefects[$month->format('M')] += $countdpv;
                        }
                        if (!isset($sumpdefects[$month->format('M')])) {
                            $sumpdefects[$month->format('M')] = $countpdefect;
                        } else {
                            $sumpdefects[$month->format('M')] += $countpdefect;
                        }
                    }
                    $months[] = $month->format('M');
                    // $months[] = ['name' => $month->format('F'), 'start' => $month_start, 'end' => $month_end]; // Add month name, start and end date to the array
                }
                // Output the array of month names, start and end dates
                $data = array(
                    'date' => $request->input('date'),
                    'vtpype' => $request->input('vehicle_type'),
                    'months' => $months,
                    'master' => $master,
                    'dweights' => $dweights,
                    'sumdefects' => $sumdefects,
                    'sumpdefects' => $sumpdefects,
                    'sumpvehivle' => $sumpvehivle,
                    'totaldefects' => count($gcaanswers),
                    'totalpdefects' => $pgcaanswers,
                );
                return view('gcareports.reportbyyear')->with($data);
            }
            return view('gcareports.reportbyyear');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function gcadpvwdpv(Request $request)
    {
        if (!empty($request->period)) {
            if ($request->period == 'daily') {
                $validator = Validator::make($request->all(), [
                    'date' => 'bail|required',
                    'period' => 'bail|required',
                    'section' => 'bail|required',
                ]);
            }
            if ($request->period == 'month_to_date') {
                $validator = Validator::make($request->all(), [
                    'period' => 'bail|required',
                    'section' => 'bail|required',
                    'month_date' => 'bail|required',
                ]);
            }
            if ($request->period == 'year_to_date') {
                $validator = Validator::make($request->all(), [
                    'period' => 'bail|required',
                    'section' => 'bail|required',
                    'year_date' => 'bail|required',
                ]);
            }
            // Check validation failure
            if ($validator->fails()) {
                return redirect()->back()->with('message', 'It appears you have forgotten to complete something');
            }
            $dailyselecteddate = null;
            $monthlyselecteddate = null;
            $yealyselecteddate = null;
            if ($request->period == 'daily') {
                $date = $request->date;
                $dateselected = $date;
                $start = date_for_database($date);
                $end = date_for_database($date);
                $startDate = Carbon::create($start)->startOfMonth();
                $firstDayOfTheMonth = date_for_database($startDate->firstOfMonth());
                $target = GcaTarget::where('month', '<=', $start)->where('date_to', '>=', $start);
                if ($request->section == 'cv') {
                    $salesData = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('vehicle_units.gca_completion_date as gca_date', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('vehicle_units.gca_completion_date')
                        ->get();
                    $shopData = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                    $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                        $dpv_target =$target->value('cvdpv'); 
                        $wdpv_target =$target->value('cvwdpv');  

                        
                } else {
                    $salesData = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('vehicle_units.gca_completion_date as gca_date', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('vehicle_units.gca_completion_date')
                        ->get();
                    $shopData = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                        $dpv_target =$target->value('lcvdpv'); 
                        $wdpv_target =$target->value('lcvwdpv');  
                }
                $dailyselecteddate = $request->date;
                $title = 'DAILY REPORT FOR ' . dateFormat($date);
               

          
            }
            if ($request->period == 'month_to_date') {
                $date = $request->month_date;
                $dateselected = $date;
                $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
                $start = $start->format("Y-m-d");
                $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
                $end = $end->format("Y-m-d");
                $monthlyselecteddate = $request->month_date;
                $title = 'MTD REPORT FOR ' . $date;
                $startDate = Carbon::create($start)->startOfMonth();
                $firstDayOfTheMonth = date_for_database($startDate->firstOfMonth());
                $target = GcaTarget::where('month', '<=', $start)->where('date_to', '>=', $start); 
                if ($request->section == 'cv') {
                    $salesData = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('vehicle_units.gca_completion_date as gca_date', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('vehicle_units.gca_completion_date')
                        ->get();
                    $shopData = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                                 
             $dpv_target =$target->value('cvdpv'); 
             $wdpv_target =$target->value('cvwdpv');  
                        
                } else {
                    $salesData = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('vehicle_units.gca_completion_date as gca_date', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('vehicle_units.gca_completion_date')
                        ->get();
                    $shopData = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                     
             $dpv_target =$target->value('lcvdpv'); 
             $wdpv_target =$target->value('lcvwdpv');  
                }
               
            }
            if ($request->period == 'year_to_date') {
                $date = $request->year_date;
                $dateselected = $date;
                $start = Carbon::createFromFormat('Y', $date)->startOfYear();
                $start = $start->format("Y-m-d");
                $end = Carbon::createFromFormat('Y', $date)->endOfYear();
                $end = $end->format("Y-m-d");
                $yealyselecteddate = $request->year_date;
              
                $title = 'YTD REPORT FOR ' . $date;
                $startDate = Carbon::create($start)->startOfMonth();
                $firstDayOfTheMonth = date_for_database($startDate->firstOfMonth());
                if ($request->section == 'cv') {
                    $salesData = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select(
                            DB::raw("FORMAT(vehicle_units.gca_completion_date, 'yyyy-MM') as dates"),
                            DB::raw('SUM(defect_count) as defect_count'),
                            DB::raw('SUM(weight) as total_weight'),
                            DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units')
                        )
                        ->groupBy(DB::raw("FORMAT(vehicle_units.gca_completion_date, 'yyyy-MM')"))
                        ->get();
                    $shopData = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                 $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'CV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
                      

                        $dpv_target = GcaTarget::where('year_date', $date)->avg('cvdpv');
                        $wdpv_target =GcaTarget::where('year_date', $date)->avg('cvwdpv'); 


                      

                        
                } else {
                    $salesData = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select(
                            DB::raw("FORMAT(vehicle_units.gca_completion_date, 'yyyy-MM') as dates"),
                            DB::raw('SUM(defect_count) as defect_count'),
                            DB::raw('SUM(weight) as total_weight'),
                            DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units')
                        )
                        ->groupBy(DB::raw("FORMAT(vehicle_units.gca_completion_date, 'yyyy-MM')"))
                        ->get();
                    $shopData = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$firstDayOfTheMonth, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();
               $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get(); 
                        
                        $dpv_target = GcaTarget::where('year_date', $date)->avg('lcvdpv');
                        $wdpv_target =GcaTarget::where('year_date', $date)->avg('lcvwdpv'); 
                }
               
            }
            if ($request->section == 'cv') {
                $total_vehicles = vehicle_units::where('gca_audit_complete', 1)->whereBetween('gca_completion_date', [$start, $end])->whereHas('model', function ($query) {
                    $query->where('vehicle_type_id', '1')->orWhere('vehicle_type_id', '2');
                })->with(['model' => function ($q) {
                    $q->where('vehicle_type_id', '1')->orWhere('vehicle_type_id', '2');
                }])->count();
                $dpv = GcaQueryAnswer::where('vehicle_type', 'CV')->whereHas('vehicle', function ($query) use ($start, $end) {
                    $query->whereBetween('gca_completion_date', [$start, $end]);
                })->sum('defect_count');
                $wdpv = GcaQueryAnswer::where('vehicle_type', 'CV')->whereHas('vehicle', function ($query) use ($start, $end) {
                    $query->whereBetween('gca_completion_date', [$start, $end]);
                })->sum('weight');
               
            } else {
                $total_vehicles = vehicle_units::where('gca_audit_complete', 1)->whereBetween('gca_completion_date', [$start, $end])->whereHas('model', function ($query) {
                    $query->where('vehicle_type_id', '3')->orWhere('vehicle_type_id', '4');
                })->with(['model' => function ($q) {
                    $q->where('vehicle_type_id', '3')->orWhere('vehicle_type_id', '4');
                }])->count();
                $dpv = GcaQueryAnswer::where('vehicle_type', 'LCV')->whereHas('vehicle', function ($query) use ($start, $end) {
                    $query->whereBetween('gca_completion_date', [$start, $end]);
                })->sum('defect_count');
                $wdpv = GcaQueryAnswer::where('vehicle_type', 'LCV')->whereHas('vehicle', function ($query) use ($start, $end) {
                    $query->whereBetween('gca_completion_date', [$start, $end]);
                })->sum('weight');
              
            }

            $dvpWdpvChartData = [];
            foreach ($salesData as $item) {
                $date = $date = Carbon::parse($item->gca_date);
                $dvpWdpvChartData['dates'][] = $date->format('d/m');
                $dvpWdpvChartData['defect_count'][] = round(($item->defect_count / $item->total_units),2);
                $dvpWdpvChartData['total_weight'][] = round(($item->total_weight / $item->total_units),2);
            }
            $shopChartData = [];
            foreach ($shopData as $item) {
                $shopChartData['shops'][] = $item->shop_name;
                $shopChartData['defect_count'][] = round(($item->defect_count / $item->total_units),2);
                $shopChartData['total_weight'][] = round(($item->total_weight / $item->total_units),2);
            }
            $dpv_count = 0;
            if ($dpv > 0) {
                $dpv_count = $dpv / $total_vehicles;
            }
            $wdpv_count = 0;
            if ($wdpv > 0) {
                $wdpv_count = $wdpv / $total_vehicles;
            }
            $cat = GcaAuditReportCategory::withSum(['answers' => function ($query) use ($start, $end) {
                $query->whereHas('vehicle', function ($q) use ($start, $end) {
                    $q->whereBetween('gca_completion_date', [$start, $end]);
                    $q->where('gca_audit_complete', '1');
                });
            }], 'defect_count')->with(['answers' => function ($query) use ($start, $end) {
                $query->select('gca_audit_report_category_id', DB::raw('SUM( weight) as total_price'))
                    ->whereHas('vehicle', function ($q) use ($start, $end) {
                        $q->whereBetween('gca_completion_date', [$start, $end]);
                        $q->where('gca_audit_complete', '1');
                    })
                    ->groupBy('gca_audit_report_category_id');
            }]);
            $categories = $cat->get();
            $defects = GcaQueryAnswer::with(['vehicle' => function ($query) use ($start, $end) {
                $query->where('gca_audit_complete', '1');
                $query->whereBetween('gca_completion_date', [$start, $end]);
            }])->whereHas('vehicle', function ($query) use ($start, $end) {
                $query->where('gca_audit_complete', '1');
                $query->whereBetween('gca_completion_date', [$start, $end]);
            })->get();
            $master = [];
            foreach ($categories as $row) {
                $dpv = 0;
                $wdpv = 0;
                if ($row->answers_sum_defect_count > 0 && $total_vehicles > 0) {
                    $dpv = $row->answers_sum_defect_count / $total_vehicles;
                    $wdpv = @$row->answers->first()->total_price / $total_vehicles;
                }
                $master['dpv'][] = $dpv;
                $master['wdpv'][] = $wdpv;
            }
            $catArray = $cat->pluck('name')->toArray();
            $catjson = json_encode($catArray, JSON_UNESCAPED_SLASHES);
            // dd($catjson);
            $dpvjson = json_encode($master['dpv']);
            $wdpvjson = json_encode($master['wdpv']);
            //dd($json);
            //json_encode($categories->,JSON_NUMERIC_CHECK);
            $dpvtatus = ($dpv > $dpv_target) ? 'OK' : 'NOK';
            $wdpvtatus = ($wdpv > $wdpv_target) ? 'OK' : 'NOK';
            //graphs
           
            $data = array(
                'title' => $title,
                'dpv' => $dpv_count,
                'wdpv' => $wdpv_count,
                'sample_size' => $total_vehicles,
                'period' => $request->period,
                'section' => $request->section,
                'dailyselecteddate' => $dailyselecteddate,
                'monthlyselecteddate' => $monthlyselecteddate,
                'yealyselecteddate' => $yealyselecteddate,
                'categories' => $categories,
                'catjson' => $catjson,
                'dpvjson' => $dpvjson,
                'wdpvjson' => $wdpvjson,
                'dpv_target' => $dpv_target,
                'wdpv_target' => $wdpv_target,
                'dpvtatus' => $dpvtatus,
                'wdpvtatus' => $wdpvtatus,
                'dateselected' => $dateselected,
                'dvpWdpvChartData' => $dvpWdpvChartData,
                'shopChartData' => $shopChartData,
                'defects' => $defects,
                'shopDataToday'=>$shopDataToday
            );
            return view('gcareports.gcadpvwdpv')->with($data);
        }
        return view('gcareports.gcadpvwdpv');
    }
    public function print_gca($period, $section, $date,$dpv_target,$wdvp_target)
    {
        $period = decrypt_data($period);
        $section = decrypt_data($section);
        $date = decrypt_data($date);
        $dpv_target = decrypt_data($wdvp_target);
        $wdpv_target = decrypt_data($wdvp_target);
        $dailyselecteddate = null;
        $monthlyselecteddate = null;
        $yealyselecteddate = null;
        if ($period == 'daily') {
            $date = $date;
            $dateselected = $date;
            $start = date_for_database($date);
            $end = date_for_database($date);
            $dailyselecteddate = $date;

            $title = 'DAILY GCA REPORT FOR ' . dateFormat($date);
           
        }
        if ($period == 'month_to_date') {
            $date = $date;
            $dateselected = $date;
            $start = Carbon::createFromFormat('F Y', $date)->startOfMonth();
            $start = $start->format("Y-m-d");
            $end = Carbon::createFromFormat('F Y', $date)->endOfMonth();
            $end = $end->format("Y-m-d");
            $monthlyselecteddate = $date;
            $title = 'GCA MTD REPORT FOR ' . $date;
           
        }
        if ($period == 'year_to_date') {
            $date = $date;
            $dateselected = $date;
            $start = Carbon::createFromFormat('Y', $date)->startOfYear();
            $start = $start->format("Y-m-d");
            $end = Carbon::createFromFormat('Y', $date)->endOfYear();
            $end = $end->format("Y-m-d");
            $yealyselecteddate = $date;
            $title = 'GCA YTD REPORT FOR ' . $date;
        }
        if ($section == 'cv') {
            $total_vehicles = vehicle_units::where('gca_audit_complete', 1)->whereBetween('gca_completion_date', [$start, $end])->whereHas('model', function ($query) {
                $query->where('vehicle_type_id', '1')->orWhere('vehicle_type_id', '2');
            })->with(['model' => function ($q) {
                $q->where('vehicle_type_id', '1')->orWhere('vehicle_type_id', '2');
            }])->count();
            $dpv = GcaQueryAnswer::where('vehicle_type', 'CV')->whereHas('vehicle', function ($query) use ($start, $end) {
                $query->whereBetween('gca_completion_date', [$start, $end]);
            })->sum('defect_count');
            $wdpv = GcaQueryAnswer::where('vehicle_type', 'CV')->whereHas('vehicle', function ($query) use ($start, $end) {
                $query->whereBetween('gca_completion_date', [$start, $end]);
            })->selectRaw('SUM(defect_count * weight) as aggregate')->first()->aggregate;
            $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'CV')
            ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
            ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
            ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
            ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
            ->groupBy('shops.report_name')
            ->get();
        } else {
            $total_vehicles = vehicle_units::where('gca_audit_complete', 1)->whereBetween('gca_completion_date', [$start, $end])->whereHas('model', function ($query) {
                $query->where('vehicle_type_id', '3')->orWhere('vehicle_type_id', '4');
            })->with(['model' => function ($q) {
                $q->where('vehicle_type_id', '3')->orWhere('vehicle_type_id', '4');
            }])->count();
            $dpv = GcaQueryAnswer::where('vehicle_type', 'LCV')->whereHas('vehicle', function ($query) use ($start, $end) {
                $query->whereBetween('gca_completion_date', [$start, $end]);
            })->sum('defect_count');
            $wdpv = GcaQueryAnswer::where('vehicle_type', 'LCV')->whereHas('vehicle', function ($query) use ($start, $end) {
                $query->whereBetween('gca_completion_date', [$start, $end]);
            })->selectRaw('SUM(defect_count * weight) as aggregate')->first()->aggregate;
         

                $shopDataToday = GcaQueryAnswer::where('vehicle_type', 'LCV')
                        ->join('vehicle_units', 'gca_query_answers.vehicle_id', '=', 'vehicle_units.id')
                        ->join('shops', 'gca_query_answers.shop_id', '=', 'shops.id')
                        ->whereBetween('vehicle_units.gca_completion_date', [$start, $end])
                        ->select('shops.report_name as shop_name', DB::raw('SUM(defect_count) as defect_count'), DB::raw('SUM(weight) as total_weight'), DB::raw('COUNT(DISTINCT vehicle_units.id) as total_units'))
                        ->groupBy('shops.report_name')
                        ->get();  
        }
        $dpv_count = 0;
        if ($dpv > 0) {
            $dpv_count = $dpv / $total_vehicles;
        }
        $wdpv_count = 0;
        if ($wdpv > 0) {
            $wdpv_count = $wdpv / $total_vehicles;
        }
        $cat = GcaAuditReportCategory::withSum(['answers' => function ($query) use ($start, $end) {
            $query->whereHas('vehicle', function ($q) use ($start, $end) {
                $q->whereBetween('gca_completion_date', [$start, $end]);
                $q->where('gca_audit_complete', '1');
            });
        }], 'defect_count')->with(['answers' => function ($query) use ($start, $end) {
            $query->select('gca_audit_report_category_id', DB::raw('SUM(defect_count * weight) as total_price'))
                ->whereHas('vehicle', function ($q) use ($start, $end) {
                    $q->whereBetween('gca_completion_date', [$start, $end]);
                    $q->where('gca_audit_complete', '1');
                })
                ->groupBy('gca_audit_report_category_id');
        }]);
        $categories = $cat->get();

        $defects = GcaQueryAnswer::with(['vehicle' => function ($query) use ($start, $end) {
            $query->where('gca_audit_complete', '1');
            $query->whereBetween('gca_completion_date', [$start, $end]);
        }])->whereHas('vehicle', function ($query) use ($start, $end) {
            $query->where('gca_audit_complete', '1');
            $query->whereBetween('gca_completion_date', [$start, $end]);
        })->get();
        $master = [];
        foreach ($categories as $row) {
            $dpv = 0;
            $wdpv = 0;
            if ($row->answers_sum_defect_count > 0 && $total_vehicles > 0) {
                $dpv = $row->answers_sum_defect_count / $total_vehicles;
                $wdpv = @$row->answers->first()->total_price / $total_vehicles;
            }
            $master['dpv'][] = $dpv;
            $master['wdpv'][] = $wdpv;
        }
        $catArray = $cat->pluck('name')->toArray();
        $catjson = json_encode($catArray, JSON_UNESCAPED_SLASHES);
        // dd($catjson);
        $dpvjson = json_encode($master['dpv']);
        $wdpvjson = json_encode($master['wdpv']);
        //dd($json);
        //json_encode($categories->,JSON_NUMERIC_CHECK);
        $dpvtatus = ($dpv > $dpv_target) ? 'OK' : 'NOK';
        $wdpvtatus = ($wdpv > $wdpv_target) ? 'OK' : 'NOK';
        $data = array(
            'title' => $title,
            'dpv' => $dpv_count,
            'wdpv' => $wdpv_count,
            'sample_size' => $total_vehicles,
            'period' => $period,
            'section' => $section,
            'dailyselecteddate' => $dailyselecteddate,
            'monthlyselecteddate' => $monthlyselecteddate,
            'yealyselecteddate' => $yealyselecteddate,
            'categories' => $categories,
            'catjson' => $catjson,
            'dpvjson' => $dpvjson,
            'wdpvjson' => $wdpvjson,
            'dpv_target' => $dpv_target,
            'wdpv_target' => $wdpv_target,
            'dpvtatus' => $dpvtatus,
            'wdpvtatus' => $wdpvtatus,
            'dateselected' => $dateselected,
            'defects' => $defects,
            'shopDataToday'=>$shopDataToday
        );

        $html = view('gcareports.print_gca_report', $data)->render();
        $pdf = new \Mpdf\Mpdf(config('pdf'));
        ini_set("pcre.backtrack_limit", "5000000");
        $pdf->WriteHTML($html);
        $headers = array(
            "Content-type" => "application/pdf",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );
        $name = 'GcaReport.pdf';
        return Response::stream($pdf->Output($name, 'I'), 200, $headers);


       // return view('gcareports.print_gca_report')->with($data);
    }
    public function pdf_test()
    {
        return view('gcareports.graph');
    }
    public function print_pdf()
    {
        $data = ['name'];
        $imageUrl = View::make('gcareports.graph')->render();
        $graphImage = 'data:image/png;base64,' . base64_encode(($imageUrl));
        dd($imageUrl);
        $html = '<img src="' . $graphImage . '" alt="Graph Image">';
        // $html = view('gcareports.graph', $data)->render();
        $pdf = new \Mpdf\Mpdf(config('pdflandscape'));
        // $pdf->SetWatermarkText($approved);
        //;
        $pdf->WriteHTML($html);
        $headers = array(
            "Content-type" => "application/pdf",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        );
        return Response::stream($pdf->Output('GcaReport.pdf', 'I'), 200, $headers);
        //return view('gcareports.graph');
    }
    public function save_graph_image(Request $request)
    {
        $chartDataURL = $request->input('chartDataURL');
        $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $chartDataURL));
        // Specify the file path where you want to save the chart image
        if ($request->input('graph_type') == 'category') {
            $filePath = public_path('/upload/category_chart.png');
        } else if ($request->input('graph_type') == 'bydate') {
            $filePath = public_path('/upload/date_chart.png');
        } else if ($request->input('graph_type') == 'shop') {
            $filePath = public_path('/upload/shop_chart.png');
        }
        // Adjust the path as needed
        // Save the chart image to the specified file path
        file_put_contents($filePath, $imageData);
        return response()->json(['message' => 'Chart image saved successfully']);
    }
}
