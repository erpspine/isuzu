<?php

namespace App\Http\Controllers\qcosschedule;

use App\Http\Controllers\Controller;
use App\Models\tcm\Tcm;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class QcosscheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            if (request()->ajax()) {
              
                $datas=Tcm::whereNotNull('id');
                $status = request()->get('status', null);
                $date_captured = request()->get('date_captured', null);
                if (!empty($status)) {
                    if($status=='NOK'){
                        $datas->whereDate('next_calibration_date', '<', date('Y-m-d'));

                    }else{
                        $datas->where('next_calibration_date', '>=', date('Y-m-d')); 
                    }    
                }

                if (!empty($daterange)) {
                    $datearr = explode('-', $daterange);
                    $datefrom = Carbon::createFromFormat('d/m/Y', $datearr[0])->format('Y-m-d');
                     $dateto = Carbon::createFromFormat('d/m/Y', $datearr[1])->format('Y-m-d');
                     $datas->whereBetween('next_calibration_date', [$datefrom, $dateto]);
                 }
                
                $datas->get();
                return DataTables::of($datas)
                ->addColumn('shop', function ($datas) {
                    return $datas->shop->shop_name;
                })
                ->addColumn('days', function ($datas) {
                    $calibration_date = $datas->next_calibration_date;
                    $status = Carbon::createFromFormat('Y-m-d', $calibration_date)->isPast();
                    $dateclass='success';
                    $datesign="+";
                    if($status && $calibration_date !=date('Y-m-d') ){
                        $dateclass='danger';
                        $datesign="-";
                    }



                    $day = $datas->next_calibration_date;
                    $date = Carbon::createFromFormat('Y-m-d', $day);
                    $now = Carbon::now();
                    $diff = $date->diffInDays($now);


                    return  '<span class="badge badge-'.$dateclass.'">'.$datesign.' '.$diff.'</span>';
                })

                   ->rawColumns(['days'])
                    ->make(true);
            }
            return view('qcosschedule.reportlist');
        } catch (\Exception $e) {
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
    public function schedule_report()
    {
       
        //$date = today()->format('Y-m-d');
       // where('next_calibration_date', '<=', $date)->
        $datas=Tcm::get();
        //dd($datas);
    
        return view('qcosschedule.index',compact('datas'));
    }

    
}
