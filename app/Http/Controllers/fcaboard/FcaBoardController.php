<?php

namespace App\Http\Controllers\fcaboard;

use App\Http\Controllers\Controller;
use App\Models\fcaboard\FcaBoard;
use App\Models\gcascore\GcaScore;
use App\Models\querydefect\Querydefect;
use DB;
use Illuminate\Http\Request;

class FcaBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $lot = [];
            $data = [];
            if (!empty($request->input('date'))) {
                $date = date_for_database($request->input('date'));
                $selected_date = $request->input('date');
                $start_date = date('Y-m-d 00:00:00', strtotime($date));
                $end_date = date('Y-m-d 23:59:59', strtotime($date));
                $defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->get();
                $drr_defects = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->where('mpa_drr', '1')
                    ->orWhere(function ($query) use ($start_date, $end_date) {
                        $query->where('mpb_drr', 1)
                            ->whereBetween('created_at', [$start_date, $end_date]);
                    })->get();
                $care = Querydefect::with(['getqueryanswer.doneby', 'getqueryanswer.routing.category'])->whereBetween('created_at', [$start_date, $end_date])->where('mpc_drr', '1')
                    ->get();

                     //cv and lcv
            $cvsumdefects = GcaScore::where([['lcv_cv','=','cv'],['date','=',$date ]])->first();
            $lcvsumdefects = GcaScore::where([['lcv_cv','=','lcv'],['date','=',$date ]])->first();
            $cv_sumdefects=0;
            $cv_dpvscore=0;
            $cv_wdpvscore=0;


            if($cvsumdefects){
                $cv_sumdefects=$cvsumdefects->defectcar1+$cvsumdefects->defectcar2;
                $cv_samplsz=$cvsumdefects->units_sampled;
                $cv_dpvscore = ($cv_samplsz == 0) ? 0 : $cv_sumdefects/$cv_samplsz;
                $cv_wdpvscore=$cvsumdefects->mtdwdpv;


            }

            $lcv_sumdefects=0;
            $lcv_dpvscore=0;
            $lcv_wdpvscore=0;

            if($lcvsumdefects){
                $lcv_sumdefects=$lcvsumdefects->defectcar1+$lcvsumdefects->defectcar2;
                $lcv_samplsz=$lcvsumdefects->units_sampled;
                $lcv_dpvscore = ($lcv_samplsz == 0) ? 0 : $cv_sumdefects/$lcv_samplsz;
                $lcv_wdpvscore=$lcvsumdefects->mtdwdpv;


            }

            $cvdpvtarget = (getGCATarget($date) == '0') ? 0 : round(getGCATarget($date)->cvdpv,1);
            $cvwdpvtarget= (getGCATarget($date) == '0') ? 0 : round(getGCATarget($date)->cvwdpv,1);
            $lcvdpvtarget = (getGCATarget($date) == '0') ? 0 : round(getGCATarget($date)->lcvdpv,1);
            $lcvwdpvtarget = (getGCATarget($date) == '0') ? 0 : round(getGCATarget($date)->lcvwdpv,1);

         //$check drl
         $drl_check=[];
         $drl_defect=[];
         foreach($defects as $defect){
            $defect_id = $defect->id;
            $refid=FcaBoard::where('report_type','Drl')->where('date',$date)->where('ref_id',$defect_id)->first();
            $result = isset($refid) ? 'checked' : '';
            $drl_check[$defect_id] = $result;
            $drl_defect[$defect_id]= isset($refid) ? $refid->defect : '';

         }

           //$check drr
           $drr_check=[];
           $drr_defect=[];
           foreach($defects as $defect){
              $defect_id = $defect->id;
              $refid=FcaBoard::where('report_type','Drr')->where('date',$date)->where('ref_id',$defect_id)->first();
              $result = isset($refid) ? 'checked' : '';
              $drr_check[$defect_id] = $result;
              $drr_defect[$defect_id]= isset($refid) ? $refid->defect : '';



           }


            //$check drr
            $care_check=[];
            $drr_care=[];
            foreach($defects as $defect){
               $defect_id = $defect->id;
               $refid=FcaBoard::where('report_type','Care')->where('date',$date)->where('ref_id',$defect_id)->first();
               $result = isset($refid) ? 'checked' : '';
               $care_check[$defect_id] = $result;
               $drr_care[$defect_id]= isset($refid) ? $refid->defect : '';

            }
            $gca_cv=FcaBoard::where('report_type','gca_cv')->where('date',$date)->get();
            $gca_lcv=FcaBoard::where('report_type','gca_lcv')->where('date',$date)->get();







            return view('fcaboard.index')->with(compact('gca_cv','gca_lcv','care_check','drr_check','drl_check','selected_date', 'defects', 'drr_defects', 'care','cv_sumdefects','cv_dpvscore','cv_wdpvscore','lcv_sumdefects','lcv_dpvscore','lcv_wdpvscore','cvdpvtarget','cvwdpvtarget','lcvdpvtarget','lcvwdpvtarget','drl_defect','drr_defect','drr_care'));
            }
            return view('fcaboard.index')->with(compact('lot'));
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
    try {
        $drl_data = [];
        $drr_data = [];
        $care_data = [];
        $gca_data = [];
        $gca_lcv_data = [];

        $date = date_for_database($request->input('date'));

        if (!empty($request->input('drl_check'))) {
            foreach ($request->input('drl_check') as $key => $value) {
                $drl_data[] = [
                    'ref_id' => $value,
                    'defect' => $request->input('drl_defect')[$value],
                    'shop' => $request->input('drl_shop')[$value],
                    'weight' => $request->input('drl_weight')[$value],
                    'lot_job' => $request->input('drl_lot_job')[$value],
                    'model' => $request->input('drl_model')[$value],
                    'date' => $date,
                    'report_type' => 'Drl',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }
        if (!empty($request->input('drr_check'))) {

            foreach ($request->input('drr_check') as $key => $value) {
                $drr_data[] = array(
                    'ref_id' =>  $value,
                    'defect' => $request->input('drr_defect')[$value],
                    'shop' => $request->input('drr_shop')[$value],
                    'weight' => $request->input('drr_weight')[$value],
                    'lot_job' => $request->input('drr_lot_job')[$value],
                    'model' => $request->input('drr_model')[$value],
                    'date' => $date,
                    'report_type' => 'Drr',
                    'created_at' => now(),
                    'updated_at' => now(),
                );

            }
        }
        if (!empty($request->input('care_check'))) {

            foreach ($request->input('care_check') as $key => $value) {
                $care_data[] = array(
                    'ref_id' =>  $value,
                    'defect' => $request->input('care_defect')[$value],
                    'shop' => $request->input('care_shop')[$value],
                    'weight' => $request->input('care_weight')[$value],
                    'lot_job' => $request->input('care_lot_job')[$value],
                    'model' => $request->input('care_model')[$value],
                    'date' => $date,
                    'report_type' => 'Care',
                    'created_at' => now(),
                    'updated_at' => now(),
                );

            }
        }
        if (!empty($request->input('gca_defect'))) {

            foreach ($request->input('gca_defect') as $key => $value) {
                $gca_data[] = array(
                    'ref_id' =>  0,
                    'defect' => $request->input('gca_defect')[$key],
                    'shop' => $request->input('shop_captured')[$key],
                    'weight' => $request->input('weight')[$key],
                    'lot_job' => $request->input('lot_job')[$key],
                    'model' => $request->input('model')[$key],
                    'date' => $date,
                    'report_type' => 'gca_cv',
                    'created_at' => now(),
                    'updated_at' => now(),
                );

            }
        }

        if (!empty($request->input('lcv_gca_defect'))) {

            foreach ($request->input('lcv_gca_defect') as $key => $value) {
                $gca_lcv_data[] = array(
                    'ref_id' =>  0,
                    'defect' => $request->input('lcv_gca_defect')[$key],
                    'shop' => $request->input('lcv_shop_captured')[$key],
                    'weight' => $request->input('lcv_weight')[$key],
                    'lot_job' => $request->input('lcv_lot_job')[$key],
                    'model' => $request->input('lcv_model')[$key],
                    'date' => $date,
                    'report_type' => 'gca_lcv',
                    'created_at' => now(),
                    'updated_at' => now(),
                );

            }
        }


        // Repeat the same process for other data types (drr, care, gca, gca_lcv)

        $master = array_merge($drl_data, $drr_data, $care_data, $gca_data, $gca_lcv_data);

        if (!empty($master)) {
            DB::beginTransaction();

            // Remove existing records for the given date
            FcaBoard::where('date', $date)->delete();

            // Insert new records
            FcaBoard::insert($master);

            DB::commit();

            $output = [
                'success' => true,
                'msg' => 'Report Created Successfully'
            ];
        } else {
            $output = [
                'success' => false,
                'msg' => "It appears you have forgotten to complete something",
            ];
        }
    } catch (\Exception $e) {
        DB::rollBack();
        $bug = $e->getMessage();
        $output = [
            'success' => false,
            'msg' => $bug
        ];
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
