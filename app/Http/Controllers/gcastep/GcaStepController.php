<?php

namespace App\Http\Controllers\gcastep;

use App\Http\Controllers\Controller;
use App\Models\gcaquerytitle\GcaQueryTitle;
use App\Models\gcasteps\GcaSteps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class GcaStepController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $steps = GcaSteps::orderBy('position', 'ASC')->get();
        return view('gcasteps.index', compact('steps'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $steps = GcaSteps::orderBy('position', 'ASC')->get();
       
       
        return view('gcasteps.create',compact('steps'));
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
            'vehicle_type' => 'bail|required',
            'audit_time' => 'bail|required',
            'position' => 'bail|required',
            'description' => 'bail|required',
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
                    $data = GcaSteps::create($data);
                    $output = [
                        'success' => true,
                        'msg' => "Step Created  Successfully"
                    ];
                    DB::commit();
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
       
            $steps = GcaSteps::orderBy('position', 'ASC')->get();
            $reports=GcaSteps::find($id);
           
            return view('gcasteps.edit',compact('steps','reports'));
                

        
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
        $validator = Validator::make($request->all(), [
            'vehicle_type' => 'bail|required',
            'audit_time' => 'bail|required',
            'position' => 'bail|required',
            'description' => 'bail|required',
        ]);



         // Check validation failure
    if ($validator->fails()) {

       $output = ['success' => false,
                            'msg' => "It appears you have forgotten to complete something",
                            ];
                            
    }

    $data = $request->except('_token');

   
  
    if ($validator->passes()) {

         if (request()->ajax()) {
            try {
                      


            $result = GcaSteps::find($id); 
            $result->update($data);
            $result->touch();
             
           $output = ['success' => true,
                            'msg' => "Steps  Updated Successfully"
                        ];
            } catch (\Exception $e) {
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                    
                $output = ['success' => false,
                            'msg' => $e->getMessage(),
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
        if (request()->ajax()) {
            try {
               

                $can_be_deleted = true;
                $error_msg = '';



                //Check if any routing has been done
               //do logic here

               $exists=GcaQueryTitle::where('gca_stage_id',$id)->exists();
               if($exists){
                   $output = ['success' => false,
                                'msg' => "Record already used!!"
                            ];
                $can_be_deleted = false;

               }

               

                if ($can_be_deleted) {

                    $items = GcaSteps::where('id', $id)
                    ->first();
                    if (!empty($items)) {
                        DB::beginTransaction();
                        $items->delete();

                        DB::commit();
                    }

                    $output = ['success' => true,
                                'msg' => "Step Deleted Successfully"
                            ];
                }
            } catch (\Exception $e) {
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                
                $output = ['success' => false,
                                'msg' => "Something Went Wrong"
                            ];
            }

            return $output;
        }
    }
}
