<?php

namespace App\Http\Controllers\qcossheet;

use App\Http\Controllers\Controller;
use App\Models\shop\Shop;
use App\Models\tcmjoint\TcmJoint;
use App\Models\unit_model\Unit_model;
use App\Models\unitmovement\Unitmovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use BarPlot;
use Graph;
use LinePlot;
use AccBarPlot;
use App\Models\employee\Employee;
use App\Models\qcosmonitoringsheet\QcosMonitoringSheet;
use App\Models\user\User;
use DateScale;
use ScatterPlot;
use Illuminate\Support\Facades\Validator;


class QcosSheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            
            
            $shops = Shop::where('is_gca_shop', 1)->get()->pluck('report_name', 'id');
            $models = Unit_model::get()->pluck('model_name', 'id');
            return view('qcossheet.index')->with(compact('shops','models'));
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
    public function printqcos()
    {
        //return view('qcossheet.print');
        $date='2022-10-28';
            $startDate = Carbon::create($date)->startOfMonth();
            $firstDayOfTheMonth = date_for_database($startDate->firstOfMonth());
             $period = CarbonPeriod::create($firstDayOfTheMonth, $date);

             $dates = Unitmovement::whereBetween('datetime_in', [$firstDayOfTheMonth, $date])->groupBy('datetime_in')->get('datetime_in');
            // dd($dates );
            
             foreach ($dates as $row) {
                //check if day exist
               // $pday = $row->format('Y-m-d');
               
                $production_days[] =  date('d/m',strtotime($row->datetime_in)); 
             }
             $data=[
                'production_days'=> $production_days,

             ];
            

        $html = view('qcossheet.print',$data)->render();

           

        $pdf = new \Mpdf\Mpdf(config('pdflandscape'));
        ini_set("pcre.backtrack_limit", "5000000");
     $pdf->WriteHTML($html);

     $headers = array(
         "Content-type" => "application/pdf",
         "Pragma" => "no-cache",
         "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
         "Expires" => "0"
     );

   
   
return Response::stream($pdf->Output('profile', 'I'), 200, $headers);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
           //return $request;
           $validator = Validator::make($request->all(), [
            'shop_id' => 'required',
            'model_id' => 'required',
            'joint_id' => 'required',
            'daterange' => 'required'
        ]);
                 // Check validation failure
    if ($validator->fails()) {

        $output = ['success' => false,
                             'msg' => "It appears you have forgotten to complete something",
                             ];
                             
     }

     if ($validator->passes()) {
        $data=  $request->only(['shop_id','model_id', 'joint_id', 'daterange']);
        $output = ['success' => true,
        'msg' => "User Created Successfully",
        'data'=>$data,
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
    public function loadbyjoint(Request $request)
    {
        $s = $request->shop_id;
        $m = $request->model_id;
        $result = TcmJoint::where('shop_id',$s)->whereHas('toolmodel', function ($query) use($m) {
            $query->where('model_id',$m);
        })->with(['tool'])->get();



        return json_encode($result);
    }

    public function generategraph() {
    // Some (random) data
$ydata   = array(11, 3, 8, 12, 5, 1, 9, 13, 5, 7);
$ydata2  = array(1, 19, 15, 7, 22, 14, 5, 9, 21, 13 );
$ydata3  = array(10, 10, 10, 10, 10, 10, 10, 10, 10, 10 );
 
// Size of the overall graph
$width=450;
$height=350;
 
// Create the graph and set a scale.
// These two calls are always required
$graph = new Graph($width,$height);
$graph->SetScale('intlin');
$graph->SetShadow();
 
// Setup margin and titles
$graph->SetMargin(40,20,20,100);
$graph->title->Set('Calls per operator (June,July)');
$graph->subtitle->Set('(March 12, 2008)');
$graph->xaxis->title->Set('Operator');
$graph->yaxis->title->Set('# of calls');
 
$graph->yaxis->title->SetFont( FF_FONT1 , FS_BOLD );
$graph->xaxis->title->SetFont( FF_FONT1 , FS_BOLD );
 
// Create the first data series
$lineplot=new LinePlot($ydata);
$lineplot->SetWeight( 2 );   // Two pixel wide
 
// Add the plot to the graph
$graph->Add($lineplot);
 
// Create the second data series
$lineplot2=new LinePlot($ydata2);
$lineplot2->SetWeight( 2 );   // Two pixel wide
 
// Add the second plot to the graph
$graph->Add($lineplot2);


// Create the second data series
$lineplot3=new LinePlot($ydata3);
$lineplot3->SetWeight( 2 );   // Two pixel wide
 
// Add the second plot to the graph
$graph->Add($lineplot3);

// Set the legends for the plots
$lineplot->SetLegend('Plot 1');
$lineplot2->SetLegend('Plot 2');
$lineplot3->SetLegend('Plot 3');
 
// Adjust the legend position
//$graph->legend->Pos(0.05,0.5,'right','center');
$graph->legend->SetFrameWeight(1);
 
// Display the graph
$graph->Stroke();



       /* $line1D = array(1497844800,1498449600,1505102400,1516597200);
        $line1Y = array(79.00,76.00,53.00,14.00);
        $line2D = array(1504584000,1507521600);
        $line2Y = array(9.87,9.93);
        
        $line3D = array_merge($line1D,$line2D);
        $line3Y = array_merge($line1Y,$line2Y);
        
        $graph = new Graph(640,480);
        $graph->clearTheme();
        $graph->SetScale('datlin');
        
        $graph->xaxis->SetLabelAngle(60);
        $graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,8);
        $graph->xaxis->SetLabelFormatString('m/d/Y',true);
        $graph->yaxis->scale->SetGrace(5);
        
        $line1=new ScatterPlot($line1Y,$line1D);
        $line1->SetColor('#4A6EC6');
        $line1->SetWeight(2);
        $line1->mark->SetFillColor('#4A6EC6');
        $line1->mark->SetType(MARK_FILLEDCIRCLE);
        $graph->Add($line1);
        
        $line2=new ScatterPlot($line2Y,$line2D);
        $line2->SetColor('#4A6EC6');
        $line2->SetWeight(2);
        $line2->mark->SetType(MARK_CIRCLE);
        $line2->mark->SetColor('#4A6EC6');
        $graph->Add($line2);
        
        $line3=new LinePlot($line3Y,$line3D);
        $line3->SetColor('#4A6EC6');
        $line3->SetWeight(2);
        $graph->Add($line3);*/
        
        return $graph->Stroke();  // display the graph
        
        
         
        // Display the graph

//return $graph->Stroke();
    }

    public function generateqcosreport(Request $request)
    {
//dd(22);
    
         $shop_id=$request->shop_id;
         $daterange=$request->daterange;
         $model_id=$request->model_id;
         $joint_id=$request->joint_id;
         $type=$request->type;

         $datearr = explode('-',$daterange);
         $datefrom = Carbon::parse($datearr[0])->format('Y-m-d');
         $dateto = Carbon::parse($datearr[1])->format('Y-m-d');
      
    

         $records = QcosMonitoringSheet::whereBetween('reading_date', [$datefrom, $dateto])->where('joint_id',$joint_id)->orderBy('reading_date','ASC')->get()->unique('qcos_ref');
         $qcosvalues = QcosMonitoringSheet::whereBetween('reading_date', [$datefrom, $dateto])->where('joint_id',$joint_id)->orderBy('reading_date','ASC')->get();

         $joint_details=TcmJoint::find($joint_id);
         $production_days=[];
         $mean=[];
         $usl=[];
         $lsu=[];
         $lcl=[];
         $ucl=[];
         $mean=[];
         $quality_plot=[];
         $production_plot=[];
         $production=[];
         $quality=[];
        $production_days_plot=[];    
        $production_vin=[];   
        $quality_vin=[];       
         foreach ($records as $data) {
          
            $usl[]=$joint_details->upper_specification_limit;
            $lsu[]=$joint_details->lower_specification_limit;
            $ucl[]=$joint_details->upper_control_limit;
            $lcl[]=$joint_details->lower_control_limit;
            $mean[]=$joint_details->mean_toque;
            
            
           
           
            $qcos_ref=$data->qcos_ref;
            foreach($qcosvalues as $row){
                
                if($row->qcos_ref ==  $qcos_ref){
                    $production_days[$qcos_ref] =  date('d/m',strtotime($row->reading_date)); 
                    

                }
            
                if($row->result_type == 'Production' &&  $row->qcos_ref ==  $qcos_ref){

                    $production[]=$row->reading;
                    $production_plot[$qcos_ref]=$row->reading;
                    $production_vin[$qcos_ref]=$row->vin_no;
                    
                }
                if($row->result_type == 'Quality' &&  $row->qcos_ref ==  $qcos_ref){

                    $quality[]=$row->reading;
                    $quality_plot[$qcos_ref]=$row->reading;
                    $quality_vin[$qcos_ref]=$row->vin_no;
                    $production_days_plot[] =  date('d/m',strtotime($row->reading_date)); 
                }
           
                

            }
         }

      //dd($shop_id);
 
         $shop = Shop::where('id',$shop_id)->value('report_name');
       $model=Unit_model::where('id', $model_id)->value('model_name');
       $team_leader=Employee::where('team_leader', 'yes')->where('shop_id', $shop_id)->value('staff_name');
       $image= asset('upload/qcos/'.$joint_details->image_one);
       //dd( $image);
    
         $data=[
            'date_from'=>$datefrom,
            'date_to'=>$dateto,
            'shop'=>$shop,
            'model'=>$model,
            'team_leader'=>$team_leader,
            'joint_details'=>$joint_details,
            'production_days'=> $production_days,
            'production_days_plot'=> $production_days_plot,
            'image'=> $image,
            'usl'=> $usl,
            'lsu'=> $lsu,
            'ucl'=> $ucl,
            'lcl'=> $lcl,
            'mean'=> $mean,
            'quality'=>$quality,
            'production'=>$production,
            'production_plot'=> $production_plot,
            'quality_plot'=> $quality_plot,
            'production_vin'=>$production_vin,
            'quality_vin'=>$quality_vin,
            'records'=>$records,
         ];
         if($type=='print'){
            return view('qcossheet.print-settings',compact('shop_id','daterange','model_id','joint_id'))->with($data);

         }
 
        return view('qcossheet.create',compact('shop_id','daterange','model_id','joint_id'))->with($data);
       

    }

    
}
