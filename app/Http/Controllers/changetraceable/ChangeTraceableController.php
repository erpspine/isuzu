<?php

namespace App\Http\Controllers\changetraceable;

use App\Http\Controllers\Controller;
use App\Models\queryanswer\Queryanswer;
use App\Models\unit_model\Unit_model;
use App\Models\vehicle_units\vehicle_units;
use Illuminate\Http\Request;

class ChangeTraceableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $vin_no = vehicle_units::distinct('vin_no')->pluck('vin_no', 'id');
            $data=[];
            return view('changetraceable.index')->with(compact('vin_no'));


          
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with('error', $e->getMessage());
        }
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
  
    
    public function loadbyjob(Request $request)
    {
        $q = $request->lot_no;
        $result = vehicle_units::with(['model'])->get()->where('lot_no', '=', $q);
        return json_encode($result);
    }
    public function filter_job(Request $request)
    {

        try {
        $vehicle_id=$request->vin_no;
    
        $queries=Queryanswer::with('vehicle')->where('vehicle_id',$vehicle_id)->where( function ( $query ){
            $query->whereHas('queries', function ($subquery ) {
                $subquery ->where('quiz_type','traceable');
            })->orWhereHas('querycategory', function ($subquery ) {
                $subquery ->where('quiz_type','traceable');
            });
            
        })->get();
            $vin_no = vehicle_units::distinct('vin_no')->pluck('vin_no', 'id');
            return view('changetraceable.index')->with(compact('vin_no','queries','vehicle_id'));

    } catch (\Exception $e) {
        dd($e->getMessage());
        return redirect()->back()->with('error', $e->getMessage());
    }

        

    
    }

    public function updatetraceable(Request $request)
    {
      
      if($request->ajax()){
        Queryanswer::find($request->input('pk'))->update([$request->input('name') => $request->input('value')]);
          return response()->json(['success' => true,'data'=>$request->input('name')]);
      }

    



    }
    
}
