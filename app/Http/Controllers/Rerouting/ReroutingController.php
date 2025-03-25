<?php
namespace App\Http\Controllers\Rerouting;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\vehicle_units\vehicle_units;
use App\Models\unit_model\Unit_model;
use Illuminate\Support\Facades\Response;
use App\Models\unitroute\Unitroutes;
use App\Models\unitmovement\Unitmovement;
use App\Models\ReroutingDetails\ReroutingDetails;
use App\Models\Rerouting\Rerouting;
use App\Models\unitmapping\Unitmapping;
use App\Models\shop\Shop;
use Illuminate\Support\Facades\DB;
use Batch;
use App\Models\queryanswer\Queryanswer;
use App\Models\querydefect\Querydefect;
use App\Models\drr\Drr;
class ReroutingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $lot = vehicle_units::where('status', '!=', '2')->distinct('lot_no')->pluck('lot_no', 'lot_no');
        $job = vehicle_units::where('status', '!=', '2')->distinct('job_no')->pluck('job_no', 'job_no');
        $model = Unit_model::pluck('model_name', 'id');
        $data = [];
        return view('rerouting.create')->with(compact('lot', 'job', 'model', 'data'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function filtererouting(Request $request)
    {
        if (!empty($request->lot_no) || !empty($request->job_no) ||  !empty($request->model_id)) {
            $vehicle = vehicle_units::where('status', '!=', '2')->where('model_id', '!=', '0');
            if (!empty($request->lot_no)) {
                $vehicle->whereIn('lot_no', $request->lot_no);
            }
            if (!empty($request->job_no)) {
                $vehicle->whereIn('job_no', $request->job_no);
            }
            if (!empty($request->model_id)) {
                $vehicle->whereIn('model_id', $request->model_id);
            }
            $data = $vehicle->get();
            $lot = vehicle_units::where('status', '!=', '2')->distinct('lot_no')->pluck('lot_no', 'lot_no');
            $job = vehicle_units::where('status', '!=', '2')->distinct('job_no')->pluck('job_no', 'job_no');
            $model = Unit_model::pluck('model_name', 'id');
            // return redirect()->route('qrcodefilterresult', ['lot'=>$lot,'job'=>$job,'model'=>$model,'data'=>$data]);
            //return redirect()->route('qrcode.index')->with(compact('lot','job','model','data'));
            return view('rerouting.create')->with(compact('lot', 'job', 'model', 'data'));
        } else {
            return redirect()->route('qrcode.index')->with('message', 'choose one record!!!');
        }
    }
    public function completererouting($id)
    {
        $vehicle = vehicle_units::find($id);
        $data = Unitmovement::where('vehicle_id', $id)->get();
        $shops = Shop::where('check_point', 1)->orderBy('shop_no', 'asc')->get();
        $fromroute = Unitroutes::where('route_number',$vehicle->route)->distinct('route_number')->pluck('name', 'route_number');
        $caseStatus = $vehicle->route;
        $newshop=[];
        switch ($caseStatus) {
            case 1:
                $swithshwith=['2'];
                break;
            case 2:
                $swithshwith=['1','5'];
                break;
           case 5:
           $swithshwith=['2'];
            break;
            default:
            $swithshwith=0;
                break;
        }
        if($swithshwith==0){
            return redirect()->route('rerouting.create')->withErrors(['error' => 'Invalid Route!!']);
        }
        $route = Unitroutes::whereIn('route_number',[$swithshwith])->distinct('route_number')->pluck('name', 'route_number');
        return view('rerouting.complete')->with(compact('route', 'vehicle', 'data','fromroute', 'shops', 'id'));
    }
    public function saverouting(Request $request)
    {
        $data = $request->only(['vehicle_id', 'from_route_id', 'to_route_id', 'description']);
        $data['user_id'] = auth()->user()->id;
        $item_data['rerouting_item']  = $request->only(['unit_movement_id', 'shop_id', 'current_shop', 'route_id','route_number','group_shop_id']);
        $datas = array();
        $i = 0;
        if (request()->ajax()) {
            try {
                DB::beginTransaction();
                $result = ReroutingDetails::create($data);
                if ($result->id) {
                    $deleted_array = array();
                    $unit_movement_update = array();
                    $shop_array = array();
                    foreach ($item_data['rerouting_item']['unit_movement_id'] as $key => $value) {
                        $deleted = 0;
                        $is_shop = 0;
                        $save = 1;
                        if ($result->from_route_id == 1) {
                            //From F-Series to N-Series
                            $movement = Unitmovement::find($value);
                            if ($movement->shop_id == 7) {
                                $movement->shop_id = 9;
                                $movement->save();
                            }
                            if ($movement->shop_id == 8) {
                                $movement->shop_id = 10;
                                $movement->save();
                            }
                            if ($movement->group_shop_id == 7) {
                                $movement->group_shop_id = 9;
                                $movement->save();
                            }
                            if ($movement->group_shop_id == 8) {
                                $movement->group_shop_id = 10;
                                $movement->save();
                            }
                            if ($movement->route_id == 1) {
                                $movement->route_id = 3;
                                $movement->save();
                            }
                            if ($movement->route_id == 2) {
                                $movement->route_id = 4;
                                $movement->save();
                            }
                            $movement->route_number = 2;
                            $movement->save();
                            if ($movement->current_shop > 0) {
                                $movement->current_shop = $movement->shop_id;
                                $movement->save();
                            }
                        }
                        if ($result->from_route_id == 2) {
                            //From N-Series to F-Series
                            $movement = Unitmovement::find($value);
                            if ($movement->shop_id == 9) {
                                $movement->shop_id = 7;
                                $movement->save();
                            }
                            if ($movement->shop_id == 10) {
                                $movement->shop_id = 8;
                                $movement->save();
                            }
                            if ($movement->group_shop_id == 9) {
                                $movement->group_shop_id = 7;
                                $movement->save();
                            }
                            if ($movement->group_shop_id == 10) {
                                $movement->group_shop_id = 8;
                                $movement->save();
                            }
                            if ($movement->route_id == 3) {
                                $movement->route_id = 1;
                                $movement->save();
                            }
                            if ($movement->route_id == 4) {
                                $movement->route_id = 2;
                                $movement->save();
                            }
                            $movement->route_number = 1;
                            $movement->save();
                            if ($movement->current_shop > 0) {
                                $movement->current_shop = $movement->shop_id;
                                $movement->save();
                            }
                        }
                    }
                    DB::commit();
                    $output = [
                        'success' => true,
                        'msg' => "Re-Routing Done  Successfully"
                    ];
                }else{
                    $output = [
                        'success' => false,
                        'msg' => "Error Updating record",
                    ];
                    DB::rollBack(); // roll back transaction if not completely saved
                }
            } catch (\Exception $e) {
                DB::rollBack(); // roll back transaction if not completely saved
                \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                $output = [
                    'success' => false,
                    'msg' => $e->getMessage(),
                ];
            }
        }
        return $output;
    }
    public function updateRoute($route, $array)
    {
        //F to N
        if ($route == 1) {
            foreach ($array as & $value) {
                switch ($value) {
                    case 1:
                        $value = 1;
                        break;
                    case 2:
                        $value = 2;
                        break;
                    case 1036:
                        $value = 1036;
                        break;
                    case 3:
                        $value = 3;
                        break;
                    case 4:
                        $value = 4;
                        break;
                    case 5:
                        $value = 5;
                        break;
                    case 6:
                        $value = 6;
                        break;
                    case 7:
                        $value = 9;
                        break;
                    case 8:
                        $value = 10;
                        break;
                    case 28:
                        $value = 28;
                        break;
                    case 14:
                        $value = 14;
                        break;
                    case 15:
                        $value = 15;
                        break;
                    case 16:
                        $value = 16;
                        break;
                }
            }
        }   if ($route == 2) { //N to F
            foreach ($array as &$value) {
                switch ($value) {
                    case 1:
                        $value = 1;
                        break;
                    case 2:
                        $value = 2;
                        break;
                    case 1036:
                        $value = 1036;
                        break;
                    case 3:
                        $value = 3;
                        break;
                    case 4:
                        $value = 4;
                        break;
                    case 5:
                        $value = 5;
                        break;
                    case 6:
                        $value = 6;
                        break;
                    case 9:
                        $value = 7;
                        break;
                    case 10:
                        $value = 8;
                        break;
                    case 28:
                        $value = 28;
                        break;
                    case 14:
                        $value = 14;
                        break;
                    case 15:
                        $value = 15;
                        break;
                    case 16:
                        $value = 16;
                        break;
                }
            }
        }
        return $array;
    }
}
