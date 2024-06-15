<?php

namespace App\Http\Controllers\lcvinstractions;

use App\Http\Controllers\AppHelper;
use App\Http\Controllers\Controller;
use App\Models\cvzones\CvZone;
use App\Models\drr\Drr;
use App\Models\vehicle_units\vehicle_units;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LCVInstractionController extends Controller
{
   /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $appearance = CvZone::where('vehicle_type', 'LCV')->where('template_type', 'Appearance')->first();
        //$szonedata = CvZone::where('template_type','Static')->first(); 
        $specification = CvZone::where('vehicle_type', 'LCV')->where('template_type', 'Specification')->first();
        $static = CvZone::where('vehicle_type', 'LCV')->where('template_type', 'Static')->first();
        $running = CvZone::where('vehicle_type', 'LCV')->where('template_type', 'Running')->first();
        $waterleaks =  CvZone::where('vehicle_type', 'LCV')->where('template_type', 'Water-Leaks-Notes')->first();
        $measurement =  CvZone::where('vehicle_type', 'LCV')->where('template_type', 'Measurement')->first();
        return view('lcvinstructions.index', compact('appearance', 'static', 'running', 'waterleaks', 'measurement', 'specification'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('lcvinstructions.create');
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
        $check_exist = CvZone::where('template_type', $data['template_type'])->where('vehicle_type', $data['vehicle_type'])->exists();
        if ($check_exist) {
            $falidate = false;
            $output = [
                'success' => false,
                'msg' => "Item  already created!!",
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
                   // $result->zoneitems()->createMany($data['zones']);
                    DB::commit();
                    $output = [
                        'success' => true,
                        'msg' => "Record Created  Successfully!!"
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
    public function edit(CvZone $cvzone,$id)
    {
        $cvzone = CvZone::find($id);
        return view('lcvinstructions.edit', compact('cvzone'));
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
       
        $input = $request->only('vehicle_type','template_type','note');
     
            $validator = Validator::make($request->all(), [
                'note' => 'bail|required',
                'vehicle_type' => 'bail|required',
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
        if ($falidate) {
            if (request()->ajax()) {
                DB::beginTransaction();
                try {
                   
                        $input['user_id'] = Auth()->User()->id;
                        if ($request->image_one && $request->image_one != "undefined") {
                            $input['image_one'] = (new AppHelper)->saveImageDynamic($request, 'image_one');
                        }
                    
                        if ($request->image_two && $request->image_two != "undefined") {
                            $input['image_two'] = (new AppHelper)->saveImageDynamic($request, 'image_two');
                        }
                        if ($request->image_three && $request->image_three != "undefined") {
                            $input['image_three'] = (new AppHelper)->saveImageDynamic($request, 'image_three');
                        }
                        $result = CvZone::find($id);
                        $result ->update($input);

                   
                        DB::commit();
               
                    $output = [
                        'success' => true,
                        'msg' => "Instruction Updated  Successfully"
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
}
