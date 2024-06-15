<?php

namespace App\Http\Controllers\instructions;

use App\Http\Controllers\Controller;
use App\Models\gcazone\GcaZone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppHelper;
use App\Models\cvzoneitems\CvZoneItem;
use App\Models\cvzones\CvZone;
use DB;

class CvStaticController extends Controller
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
        $zones = GcaZone::all();
        return view('cvinstructions.create', compact('zones'));
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
        if ($data['car_type'] = 'cv') {
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
                    if ($data['car_type'] = 'cv') {
                        $data['user_id'] = Auth()->User()->id;
                        $data['image_one'] = 'default.jpg';
                        if ($request->image_one && $request->image_one != "undefined") {
                            $data['image_one'] = (new AppHelper)->saveImageDynamic($request, 'image_one');
                        }
                       
                        $result = CvZone::create($data);
                        $result->zoneitems()->createMany($data['procedures']);
                        $result->zoneitems()->createMany($data['zones']);
                        DB::commit();
                    } else {
                        $data = GcaZone::create($data);
                    }
                    $output = [
                        'success' => true,
                        'msg' => "Static Created  Successfully"
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
}
