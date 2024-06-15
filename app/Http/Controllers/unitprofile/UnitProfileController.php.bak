<?php

namespace App\Http\Controllers\unitprofile;

use App\Http\Controllers\Controller;
use App\Models\queryanswer\Queryanswer;
use App\Models\querycategory\Querycategory;
use App\Models\querydefect\Querydefect;
use App\Models\querymodels\QueryModels;
use App\Models\routingquery\Routingquery;
use App\Models\unit_model\Unit_model;
use App\Models\unitmovement\Unitmovement;
use App\Models\vehicle_units\vehicle_units;
use Illuminate\Http\Request;
use App\Models\shop\Shop;
use App\Models\unitmapping\Unitmapping;
use mPDF;
use Illuminate\Support\Facades\Response;
use DB;
class UnitProfileController extends Controller
{
    //

    public function searchunitprofile(Request $request)
    {

        $vehicle=vehicle_units::get();

        $lot = array();
        $data=[];
        foreach( $vehicle  as $rows){

            $lot[$rows->id] = 'Lot No '.$rows->lot_no.' Job No '.$rows->job_no.' Vin No '.$rows->vin_no;



        }

           $vdata=NULL;
            if($request->has('vehicle_id')){
            $vdata=$request->vehicle_id;

            $vehicle_data=vehicle_units::find($request->vehicle_id);
            $q=Unitmovement::where('vehicle_id',$request->vehicle_id);

            $q->when( $vehicle_data->route==1, function ($q) {

                return $q->where('shop_id', '=','8');
            });
            $q->when( $vehicle_data->route==2, function ($q) {

                return $q->where('shop_id', '=','10');
            });
            $q->when( $vehicle_data->route==3, function ($q) {

                return $q->where('shop_id', '=','10');
            });
            $q->when( $vehicle_data->route==4, function ($q) {

                return $q->where('shop_id', '=','13');
            });
            $q->when( $vehicle_data->route==5, function ($q) {

                return $q->where('shop_id', '=','13');
            });
            
            
            $odate=$q->value('datetime_out');

            $fcw=Unitmovement::where('vehicle_id',$request->vehicle_id)->where('shop_id','16')->value('datetime_out');

           
            $fcw= !empty($fcw) ?   dateFormat($fcw) : '';
        
            $offlinedate= !empty($odate) ?   dateFormat($odate) : '';

            $unit_movement=Unitmovement::where('vehicle_id',$request->vehicle_id)->orderBy('shop_id', 'asc')->get();


            $defects=Querydefect::where('vehicle_id',$request->vehicle_id)->get();

              $vid=$request->vehicle_id;
              $model_id= $vehicle_data->model_id;

           

             $answerarray =Queryanswer::where('vehicle_id',$vid)-> get()->unique('category_id')->pluck('category_id');
     

             

            $shops = Shop::with(['querycategory'=>function ($q) use($answerarray) {
                $q->whereIn('id',$answerarray);
            },'querycategory.queryanswers'=>function ($q) use($vid) {
                $q->where('vehicle_id',$vid);
            },'querycategory.queryanswers.queries','querycategory.queryanswers.doneby','querycategory.queryanswers.get_defects'])->whereHas('unitmovement',function($query) use( $vid){
                $query->where('vehicle_id',$vid);
            })->orderBy('shop_no', 'asc')->get();
        


            $token=token_validator('', $vid, true);
            $data=[
                'vehicle_data'=> $vehicle_data,
                 'offlinedate'=> $offlinedate,
                'fcw'=> $fcw,
                 'unit_movements'=>$unit_movement,
                'unit_defects'=>$defects,
                  'shops'=>$shops,
                'token'=>$token
 
            ];

           


     

         

        }

        return view('unitprofile.searchunit')->with(compact('lot','vdata','data'));
    
    }


    public function printprofile($id,$token)
    {

        

            $vid=$id;

            $vehicle_data=vehicle_units::find($vid);
            $q=Unitmovement::where('vehicle_id',$vid);

            $q->when( $vehicle_data->route==1, function ($q) {

                return $q->where('shop_id', '=','8');
            });
            $q->when( $vehicle_data->route==2, function ($q) {

                return $q->where('shop_id', '=','10');
            });
            $q->when( $vehicle_data->route==3, function ($q) {

                return $q->where('shop_id', '=','10');
            });
            $q->when( $vehicle_data->route==4, function ($q) {

                return $q->where('shop_id', '=','13');
            });
            $q->when( $vehicle_data->route==5, function ($q) {

                return $q->where('shop_id', '=','13');
            });
            
            
            $odate=$q->value('datetime_out');

            $fcw=Unitmovement::where('vehicle_id',$vid)->where('shop_id','16')->value('datetime_out');

           
            $fcw= !empty($fcw) ?   dateFormat($fcw) : '';
        
            $offlinedate= !empty($odate) ?   dateFormat($odate) : '';

            $unit_movement=Unitmovement::where('vehicle_id',$vid)->orderBy('shop_id', 'asc')->get();


            $defects=Querydefect::where('vehicle_id',$vid)->get();
             $answerarray =Queryanswer::where('vehicle_id',$vid)-> get()->unique('category_id')->pluck('category_id');
     

             

            $shops = Shop::with(['querycategory'=>function ($q) use($answerarray) {
                $q->whereIn('id',$answerarray);
            },'querycategory.queryanswers'=>function ($q) use($vid) {
                $q->where('vehicle_id',$vid);
            },'querycategory.queryanswers.queries','querycategory.queryanswers.doneby','querycategory.queryanswers.get_defects'])->whereHas('unitmovement',function($query) use( $vid){
                $query->where('vehicle_id',$vid);
            })->orderBy('shop_no', 'asc')->get();
        


            $data=[
                'vehicle_data'=> $vehicle_data,
                 'offlinedate'=> $offlinedate,
                'fcw'=> $fcw,
                 'unit_movements'=>$unit_movement,
                'unit_defects'=>$defects,
                'shops'=>$shops,
 
            ];
         //   dd($data);

           $html = view('unitprofile.print_profile', $data)->render();

           

           $pdf = new \Mpdf\Mpdf(config('pdf'));
           ini_set("pcre.backtrack_limit", "5000000");
        $pdf->WriteHTML($html);

        $headers = array(
            "Content-type" => "application/pdf",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $name = 'Chassis-' . $vehicle_data->vin_no .' .pdf';
      
   return Response::stream($pdf->Output($name, 'I'), 200, $headers);
    
    }

    
}
