<?php

namespace App\Http\Controllers\appearancezones;

use App\Http\Controllers\Controller;
use App\Models\cvzones\CvZone;
use App\Models\gcazone\GcaZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppHelper;
use App\Models\cvzoneitems\CvZoneItem;
use DB;

class AppearanceZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = GcaZone::all();
        return view('appearancezones.index', compact('zones'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except('_token');
        $validator = Validator::make($request->all(), [
            'note' => 'bail|required',
            'template_type' => 'bail|required',
        ]);
        $falidate = true;
        if ($validator->fails()) {
            $falidate = false;
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something",
            ];
        }
        $check_exist = CvZone::where('template_type', 'Appearance')->where('vehicle_type', $data['vehicle_type'])->exists();
        if ($check_exist) {
            $falidate = false;
            $output = [
                'success' => false,
                'msg' => "Zone and appearance  already created!!",
            ];
        }
        if ($falidate) {
            if (request()->ajax()) {
                DB::beginTransaction();
                try {
                    $data['user_id'] = Auth()->User()->id;
                    DB::commit();
                    $data['image_one'] = 'default.jpg';
                    if ($request->image_one && $request->image_one != "undefined") {
                        $data['image_one'] = (new AppHelper)->saveImageDynamic($request, 'image_one');
                    }
                    $data['image_two'] = 'default.jpg';
                    if ($request->image_two && $request->image_two != "undefined") {
                        $data['image_two'] = (new AppHelper)->saveImageDynamic($request, 'image_two');
                    }
                    $data['image_three'] = 'default.jpg';
                    if ($request->image_three && $request->image_three != "undefined") {
                        $data['image_three'] = (new AppHelper)->saveImageDynamic($request, 'image_three');
                    }
                    $result = CvZone::create($data);
                    $result->zoneitems()->createMany($data['zones']);
                    DB::commit();
                    $output = [
                        'success' => true,
                        'msg' => "Zone & Apperance Created  Successfully!!"
                    ];
                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                    $output = [
                        'success' => false,
                        'msg' => $e->getMessage(),
                    ];
                }
            }
        }
        return $output;
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(CvZone $cvzone, $id)
    {
        try {
            $cvzone = CvZone::find($id);
            return view('appearancezonescv.edit', compact('cvzone'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
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
        $data = $request->only('zones');
        $input = $request->only('car_type', 'zone', 'defination', 'applicable_portion');
        if ($input['car_type'] = 'cv') {
            $validator = Validator::make($request->all(), [
                'note' => 'bail|required',
                'car_type' => 'bail|required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'bail|required',
                'car_type' => 'bail|required',
            ]);
        }
        $falidate = true;
        if ($validator->fails()) {
            $falidate = false;
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something",
            ];
        }
        if ($falidate) {
            if (request()->ajax()) {
                DB::beginTransaction();
                try {
                    if ($input['car_type'] = 'cv') {
                        $input['user_id'] = Auth()->User()->id;
                        if ($request->image_one && $request->image_one != "undefined") {
                            $input['image_one'] = (new AppHelper)->saveImageDynamic($request, 'image_one');
                        }
                        if ($request->image_two && $request->image_two != "undefined") {
                            $input['image_two'] = (new AppHelper)->saveImageDynamic($request, 'image_two');
                        }
                        $result = CvZone::find($id);
                        $result->update($input);
                        foreach ($data['zones'] as $key => $val) {
                            $zone_item = CvZoneItem::find($val['id']);
                            $zone_item->zone = $val['zone'];
                            $zone_item->defination = $val['defination'];
                            $zone_item->applicable_portion = $val['applicable_portion'];
                            $zone_item->save();
                        }
                        DB::commit();
                    } else {
                        $data = GcaZone::create($data);
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Zone Updated  Successfully"
                    ];
                } catch (\Exception $e) {
                    DB::rollBack();
                    \Log::emergency("File:" . $e->getFile() . "Line:" . $e->getLine() . "Message:" . $e->getMessage());
                    $output = [
                        'success' => false,
                        'msg' => $e->getLine(),
                    ];
                }
            }
        }
        return $output;
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
 
    public function appearance_zones_cv()
    {
        $zonedata = CvZone::where('template_type', 'Appearance')->first();
        //$szonedata = CvZone::where('template_type','Static')->first(); 
        $specification = CvZone::where('vehicle_type', 'CV')->where('template_type', 'Specification')->first();
        $static = CvZone::where('vehicle_type', 'CV')->where('template_type', 'Static')->first();
        $running = CvZone::where('vehicle_type', 'CV')->where('template_type', 'Running')->first();
        $waterleaks =  CvZone::where('vehicle_type', 'CV')->where('template_type', 'Water-Leaks-Notes')->first();
        $measurement =  CvZone::where('vehicle_type', 'CV')->where('template_type', 'Measurement')->first();
        return view('appearancezonescv.index', compact('zonedata', 'static', 'running', 'waterleaks', 'measurement', 'specification'));
    }
    public function appearance_zones_cv_add()
    {
        $zones = GcaZone::where('vehicle_type', 'CV')->get();
        return view('appearancezonescv.create', compact('zones'));
    }
    public function appearance_zones_lcv_add()
    {
        $zones = GcaZone::where('vehicle_type', 'LCV')->get();
        return view('appearancezoneslcv.create', compact('zones'));
    }
    public function add_instructions_cv()
    {
        return view('appearancezonescv.add');
    }
    public function edit_instructions_cv(CvZone $cvzone, $id)
    {
        $cvzone = CvZone::find($id);
        return view('appearancezonescv.update', compact('cvzone'));
    }
    public function add_instructions_lcv()
    {
        return view('appearancezoneslcv.add');
    }

    
}
