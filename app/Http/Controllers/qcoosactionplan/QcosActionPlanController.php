<?php

namespace App\Http\Controllers\qcoosactionplan;

use App\Http\Controllers\Controller;
use App\Models\qcoscontainemnt\QcosContainment;
use App\Models\shop\Shop;
use App\Models\tcmjoint\TcmJoint;
use Carbon\Carbon;
use DataTables;
use Illuminate\Http\Request;

class QcosActionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

       $daterange='02/04/2023-12/04/2023';
       $datearr = explode('-', $daterange);

       $datefrom = Carbon::createFromFormat('d/m/Y', $datearr[0])->format('Y-m-d');
       $dateto = Carbon::createFromFormat('d/m/Y', $datearr[1])->format('Y-m-d');
 
        try {
            // $result = QcosMonitoringSheet::with(['vehicle.model'])->get();
           //  dd($result);
             if (request()->ajax()) {
              
                 $result = QcosContainment::whereNotNull('id');

                 $date_captured = request()->get('date_captured', null);
                 $status = request()->get('status', null);
                 $joint_id = request()->get('joint_id', null);
                 $daterange = request()->get('daterange', null);
                 $shop_id = request()->get('shop_id', null);
                 if (!empty($date_captured)) {
                    $date=date_for_database($date_captured);
                    $result->where('date_open', $date);
                }
                if (!empty($joint_id)) {
                    $result->where('joint_id', $joint_id);
                }
                if (!empty($shop_id)) {
                    $result->where('shop_id', $shop_id);
                }

                if (!empty($status)) {
                    $result->where('status', $status);
                }
                if (!empty($daterange)) {
                   $datearr = explode('-', $daterange);
                   $datefrom = Carbon::createFromFormat('d/m/Y', $datearr[0])->format('Y-m-d');
                    $dateto = Carbon::createFromFormat('d/m/Y', $datearr[1])->format('Y-m-d');


                    $result->whereBetween('date_open', [$datefrom, $dateto]);
                }
                $result->get();
                 return DataTables::of($result)
                 ->addColumn('actions', function ($result) {
                    return $result->action;
                })
                ->addColumn('generatedby', function ($result) {
                   return $result->doneby->name;
               })
               ->addColumn('shops', function ($result) {
                return $result->shop->shop_name;
            })
            ->addColumn('joints', function ($result) {
                return $result->joint->part_name_joint_id;
            })
               
                
                     
                  
                     ->make(true);
             }
             $shops = Shop::where('is_gca_shop', 1)->get()->pluck('report_name', 'id');
             $joints = TcmJoint::get()->pluck('part_name_joint_id', 'id');
             return view('qcosactionplan.index',compact('shops','joints'));
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
}
