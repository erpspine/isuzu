<?php

namespace App\Http\Controllers\attendance;

use App\Models\attendance\Attendance;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\employee\Employee;
use App\Models\unitmovement\Unitmovement;
use App\Models\unit_model\Unit_model;
use App\Models\vehicle_units\vehicle_units;
use App\Models\std_working_hr\Std_working_hr;
//use App\Models\attendancepreview\AttendancePreview;
use App\Models\defaultattendance\DefaultAttendanceHRS;
use App\Models\attendancestatus\Attendance_status;
use App\Models\reviewconversation\Review_conversation;
use App\Models\productiontarget\Production_target;
use App\Models\workschedule\WorkSchedule;
use App\Models\shop\Shop;
use App\Models\targets\Target;
use App\Models\indivtarget\IndivTarget;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;
use App\Exports\AttndRegisterView;
use Carbon\CarbonPeriod;
use Excel;
use PDF;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
        //Permission::create(['name' => 'attendance-mark']);
        //Permission::create(['name' => 'Effny-dashboard']);
        //Permission::create(['name' => 'people-report']);
        //Permission::create(['name' => 'people-summary']);
        //Permission::create(['name' => 'set-default']);
        //Permission::create(['name' => 'manage-target']);
        //Permission::create(['name' => 'view-target']);
        //Permission::create(['name' => 'set-stdhrs']);
    function __construct()
    {
         $this->middleware('permission:attendance-mark', ['only' => ['markattencance','attendance_view','store']]);
         $this->middleware('permission:people-report', ['only' => ['headcount']]);
         $this->middleware('permission:people-summary', ['only' => ['prodnoutput']]);
         $this->middleware('permission:manage-target', ['only' => ['createtargets','savetargets']]);
         $this->middleware('permission:view-target', ['only' => ['settargets']]);

         $this->middleware('permission:direct-manpower', ['only' => ['headcount']]);
         $this->middleware('permission:stdhrs-generated', ['only' => ['prodnoutput']]);
         $this->middleware('permission:stdActual-hours', ['only' => ['weeklystdhrs']]);
         $this->middleware('permission:plant-register', ['only' => ['plantattendancereg']]);
         $this->middleware('permission:target-report', ['only' => ['peopleAttreport']]);

    }

    //Marking attendance
    public function markattencance(Request $request){


            $mdate =$request->input('mdate');
            $shopid = $request->input('shop');

            $empexist = Employee::where([['shop_id','=',$shopid],['outsource','=','no']])->exists();
            if(!$empexist){
                Toastr::error('Sorry, There is no employee in that shop/section.','Whooops!');
                return back();
            }

        $date = Carbon::createFromFormat('m/d/Y', $mdate)->format('Y-m-d');
        $prodday = Production_target::where('date','=',$date)->first();
        $holi = WorkSchedule::where('date','=',$date)->value('holidayname');
        if(!empty($holi)){
            $dayname = $holi;
        }else{
            $dayOfTheWeek = Carbon::parse($mdate)->dayOfWeek;
            $weekMap = [0 => 'Sun',1 => 'Mon',2 => 'Tue',3 => 'Wed',4 => 'Thu',5 => 'Fri',6 => 'Sat'];
            $dayname = $weekMap[$dayOfTheWeek];
        }


      
        /*if($checkconfirmed != null){
            Toastr::error('Attendance already confirmed.','Access denied!');
            return back();
        }*/

        $shopname = Shop::where([['id', $shopid],['overtime','=','1']])->value('report_name');
        $allshops = Shop::where('overtime','=','1')->get(['id','report_name']);
        $shopno = 0;
        foreach($allshops as $one){
            if($one->report_name == $shopname){
                break;
            }
            $shopno++;
        }

              unset($allshops[$shopno]);

           // $st = Attendance_status::where([['date', '=', $date], ['shop_id', '=', $shopid]])->value('status_name');
            
            //$marked = ($st == "") ? "Not marked" : $st;
            $indirectshop = Shop::where('id','=',$shopid)->value('check_shop');
           

            //SUBMISSION STATUS
            $attstatus = Attendance_status::where([['shop_id','=',$shopid],['date','=',$date]])->first();
            //CONVERSATION
            $conversation=[];
            $marked="Not marked";
            $st="";
            if($attstatus){
                $statusid =$attstatus->id;
                $conversation = Review_conversation::where('statusid','=',$statusid)
                ->get(['user_id','statusid','sender','message','created_at']);
                $marked =$attstatus->status_name;
                $st=$attstatus->status_name;

            }
           
            $shop_type = Shop::where('id','=',$shopid)->value('has_outsourced');
            if($st != ""){
                    $staffs = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->get();
                    $id = DefaultAttendanceHRS::orderBy('id', 'desc')->take(1)->value('id');
                    $check_deafult=DefaultAttendanceHRS::where('id','=',$id)->first();
                    $direct="";
                    $indirect="";
                    $hrslimit="";
                    $overtime="";
                    if($check_deafult){
                        $indirect = $check_deafult->indirect;
                        $direct = $check_deafult->direct;
                        $hrslimit = $check_deafult->hrslimit;
                        $overtime = $check_deafult->overtime;
                    }





                    $checkshop = Shop::where('id','=',$shopid)->value('check_shop');
                  
               

                    $data = array(
                        'num' => 1, 'direct'=> $direct, 'indirect'=> $indirect, 'hrslimit'=>$hrslimit,
                         'i'=>0,
                        'staffs'=>$staffs, 'overtime'=>$overtime, 'outsourcestaffs'=>[],
                        'directname' => ($checkshop == 1) ? 'Direct' : 'Indirect',
                        'shop_type' => $shop_type,
                        'shop' => $shopname,'conversation'=>$conversation,
                        'shopid' => $shopid,
                        'shops' => $allshops,
                        'date' => $date, 'dayname'=>$dayname,
                        'marked' => $marked, 'prodday'=>$prodday,
                        'attstatus'=>$attstatus,'indirectshop'=>$indirectshop,
                    );
                    return view('attendances.index')->with($data);

            }else{
              
                $id = DefaultAttendanceHRS::orderBy('id', 'desc')->take(1)->value('id');
               
              
                $check_deafult=DefaultAttendanceHRS::where('id','=',$id)->first();
              

                $direct="";
                $indirect="";
                $hrslimit="";
                $overtime="";
                if($check_deafult){
                    $indirect = $check_deafult->indirect;
                    $direct = $check_deafult->direct;
                    $hrslimit = $check_deafult->hrslimit;
                    $overtime = $check_deafult->overtime;
                }

                $checkshop = Shop::where('id','=',$shopid)->value('check_shop');
                $directname = ($checkshop == 1) ? 'Direct' : 'Indirect';

                $data = array(
                    'num' => 1, 'direct'=> $direct, 'indirect'=> $indirect, 'hrslimit'=>$hrslimit,
                    'staffs' => Employee::where([['shop_id', $shopid],['status','=','Active'],['outsource','=','no']])
								->orderBy('staff_no','ASC')
                                ->get(['id','staff_no','staff_name','team_leader','outsource','outsource_date']),
                    'outsourcestaffs' => Employee::where([['shop_id', $shopid],['status','=','Active'],['outsource_date','=',$date],['outsource','=','yes']])
                                ->get(['id','staff_no','staff_name','team_leader','outsource','outsource_date']),
                    'shops' => $allshops, 'overtime'=>$overtime, 'directname'=>$directname,
                    'shop_type' => $shop_type,
                    'set' => DefaultAttendanceHRS::All(),
                    'shop' => $shopname, 'indirectshop'=>$indirectshop,
                    'shopid' => $shopid, 'dayname'=>$dayname,
                    'date' => $date, 'prodday'=>$prodday,'conversation'=>$conversation,
                    'marked' => $marked, 'attstatus'=>$attstatus,
                );
                return view('attendances.index')->with($data);

            }

    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function attendance_view()
    {

        //$check_attendance = Attendance::where([['shop_id','=',3]])->groupBy('staff_id')->get('staff_id')->pluck('staff_id');

       //$employees = Employee::where('shop_id',3)->get(['id'])->pluck('id');

        
      

        //dd($employees);
        $section=Auth()->User()->section;
        $selectshops = Shop::where('overtime','=','1')->pluck('report_name','id');
        $proddayys = Production_target::groupBy('date')->whereBetween('date',['2021-11-16',Carbon::today()->format('Y-m-d')])->get('date')->pluck('date')->toArray();
        $logged= Attendance_status::where([['shop_id','=',$section]])->get('date')->pluck('date')->toArray();
        $unlogged = array_diff($proddayys, $logged);  
     
     
        $startdate = "2021-11-16";
        $tody = Carbon::today()->format('Y-m-d');
        $periods = CarbonPeriod::create('2021-11-16', $tody);
        $saveds=[];
        $reviews=[];
        $check_status = Attendance_status::where([['shop_id','=',$section]])->get('status_name');
        foreach($periods as $period){
            $date= $period->format('Y-m-d');

            foreach( $check_status as $status){
                if(($status->status_name)=='saved' && ($date==$status->date)){
                    $saveds[] =dateFormat($date);
                }

                if(($status->status_name)=='review' && ($date==$status->date)){
                    $reviews[] =dateFormat($date);
                }

            }
 
         }
       
    

        //return $count_presenttoday;
        $data = array(
            'unlogged'=>$unlogged,'saveds'=>$saveds,'reviews'=>$reviews,
            'shops' => $selectshops,
       

        );
        return view('attendances.attendance_view')->with($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->input('button') == "reveiwsubmitted"){
            $validator = Validator::make($request->all(), [
                'message' => 'required',
            ]);
            if ($validator->fails()) {
                Toastr::error('Sorry! Provide some response text.');
                return back();
            }
        }

        $validator = Validator::make($request->all(), [
            'direct_hrs' => 'required',
            'indirect_hrs' => 'required',
            'othours' => 'required',
            'auth_othrs' => 'required',
            'indirect_othours'=>'required',
            'workdescription'=>'required',
            'workdescriptionall'=>'required',
        ]);

        if ($validator->fails()) {
            Toastr::error('Sorry! All fields are required.');
            return back();
        }

        $date = $request->input('date');
        $shop_id = $request->shop_id;
        $data_items = $request->only([
            'marked_id', 'staff_id', 'direct_hrs', 'indirect_hrs', 'shop_loaned_to', 'loaned_hrs', 
            'othours','auth_othrs', 'otshop_loaned_to', 'otloaned_hrs', 'indirect_othours','workdescription'
        ]);

      
        $data_items = modify_array($data_items);

        $marked = Attendance::where([['date', '=', $date], ['shop_id', '=', $shop_id]])->first();
        if($marked == null){

            try{
                DB::beginTransaction();
                $data_items = array_map(function ($v) use($shop_id,$date) {
                    unset($v['marked_id']);
                    return array_replace($v, [
                        'loaned_hrs'=>numberChange($v['loaned_hrs']),
                        'indirect_hrs'=>numberChange($v['indirect_hrs']),
                        'otloaned_hrs'=>numberChange($v['otloaned_hrs']),
                        'otshop_loaned_to'=>numberChange($v['otshop_loaned_to']),
                        'loaned_hrs'=>numberChange($v['loaned_hrs']),
                        'shop_id'=>$shop_id, 
                        'date'=>$date, 
                        'user_id' => auth()->user()->id,
                        'efficiencyhrs' => (($v['direct_hrs']) * 0.97875) + $v['auth_othrs'],
                    ]);
                }, $data_items);
                  Attendance::insert($data_items);
                    $status = new Attendance_status;
                    $status->date = $date;
                    $status->shop_id = $shop_id;
                    $status->status_name = $request->input('button');
                    $status->workdescription = $request->input('workdescriptionall');
                    $status->user_id = auth()->user()->id;
                    $status->save();

                DB::commit();
                Toastr::success('Attendance saved successfully','Saved');
                return redirect('/attendance_view');
            }
            catch(\Exception $e){
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                Toastr::error('Sorry! An error occured attendance not saved.','Error');
                return $e->getMessage();
            }



        }else{
            
            //Awaiting some code
            $markedid = Attendance::where([['date', '=', $date], ['shop_id', '=', $shop_id]])->get('id');//->first();
            try{
                DB::beginTransaction();

                  // remove omitted items
                 $item_ids = array_map(function ($v) { return $v['marked_id']; }, $data_items);
        
                //delete attendance which are removed from the list
                  Attendance::where([['date', '=', $date], ['shop_id', '=', $shop_id]])->whereNotIn('id', $item_ids)->delete();
                foreach($data_items as $item) {

                    foreach ($item as $key => $val) {
                        if (in_array($key, ['otloaned_hrs','otshop_loaned_to']))
                        if($item[$key]==null){
                            $item[$key]=0;

                        }else{
                            $item[$key]= $val;
                        }  
                           
                    }       
                 
              $attendance_item = Attendance::firstOrNew(['id' => $item['marked_id']]);
               $attendance_item->fill(array_replace($item, ['indirect_hrs'=>numberChange($item['indirect_hrs']),'shop_id'=>$shop_id, 'date'=>$date, 'user_id' => auth()->user()->id, 'efficiencyhrs' => (($item['direct_hrs']) * 0.97875) + $item['auth_othrs']]));
                 if (!$attendance_item->id) unset($attendance_item->id);
               $attendance_item->save();
                }
     

             //ATTENDANCE STATUS
             $statusid = Attendance_status::where([['shop_id','=',$shop_id],['date','=',$date]])->value('id');

                 $status = Attendance_status::find($statusid);
                 if($request->input("button") == "reveiwsubmitted"){
                    $status->status_name = "submitted";
                 }else{
                    $status->status_name = $request->input('button');
                }
                 $status->workdescription = $request->input('workdescriptionall');
                 $status->save();

                if($request->input("button") == "reveiwsubmitted"){
                    $review = new Review_conversation;
                    $review->user_id = auth()->user()->id;
                    $review->statusid = $request->input('statusid');
                    $review->sender = $request->input('sender');
                    $review->message = $request->input('message');
                    $review->save();
                }

            DB::commit();
                Toastr::success('Attendance updated successfully','Saved');
                return back();
            }
            catch(\Exception $e){
                DB::rollBack();
                \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
                Toastr::error('Sorry! An error occured attendance not Updated.','Error');
                return $e->getMessage();
            }

        }


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function attendancereport(Request $request)
    {
        if($request->input()){
            $date = $request->input('mdate');
           $date1 = Carbon::createFromFormat('F Y', $date)->format('Y-m-d');
           $date = Carbon::createFromFormat('Y-m-d', $date1);
           $firstthismonth = $date->startOfMonth()->toDateString();
           $endthismonth = $date->endOfMonth()->toDateString();
           $today = $endthismonth;
           $shopid = $request->input('shop');
       }else{
           $today = Carbon::today()->format('Y-m-d');
           $firstthismonth = Carbon::now()->startOfMonth()->format('Y-m-d');
           $shopid = 1;
       }

       //PRODUCTION DAYS
       $allschdates = Production_target::whereBetween('date', [$firstthismonth, $today])
                    ->groupby('date')->get(['date']);
            if(count($allschdates) == 0){
                Toastr::error('Sorry, There is no schedules for the month.','Whoops!');
                return back();
                }
            foreach($allschdates as $schdt){  $prodndays[] = $schdt->date; }

       $shopname = Shop::where('id','=',$shopid)->value('report_name');

       $employees = Employee::where('shop_id','=',$shopid)->get(['id','staff_no','staff_name']);
       foreach($employees as $emp){

            $tthrs = 0;
            for($n = 0; $n < count($prodndays); $n++){
                $dates[] = Carbon::createFromFormat('Y-m-d', $prodndays[$n])->format('jS');

                $hours = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
                $emphrs[$emp->id][] = $hours; $tthrs += $hours;
            }
            $ttemphrs[$emp->id] = $tthrs;
       }

       //Per date
       $tthrs = 0; $ttsum = 0;
            for($n = 0; $n < count($prodndays); $n++){
                $tthh = Attendance::where([['date','=',$prodndays[$n]],['shop_id','=',$shopid]])
                    ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
                $ttsum += $tthh;  $hrsperdate[] = $tthh;

            }

       //return $emphrs;
        $data = array(
            'employees' => $employees,
            'today'=>$today,
            'dates'=>$dates,
            'count'=>count($prodndays),
            'emphrs'=>$emphrs, 'ttemphrs'=>$ttemphrs, 'hrsperdate'=>$hrsperdate, 'ttsum'=>$ttsum,
            'shopname'=>$shopname,
            'selectshops'=>Shop::where('overtime','=',1)->get(['report_name','id']),

        );

        return view('attendances.attendancerpt')->with($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function searchsummaryreport(Request $request)
    {
        $shopid = $request->shop;
        $shopname = Shop::where('id', $shopid)->value('shop_name');
       $shops = Shop::pluck('shop_name', 'id');

        $shops1 = Shop::All();
        foreach($shops1 as $sp){
            $names[] = $sp->shop_name;
            $mkd = Attendance::where([['date', '=', Carbon::today()->format('Y-m-d')], ['shop_id', '=', $sp->id]])->first('id');
            if($mkd != null){ $colord[] = "success";}
                    else{ $colord[] = "danger";}
        }

        $today = Carbon::now();
        $marked = [];
        for ($i=1; $i<=30; $i++) {
            $today->subDays(1);
            if($today->format('l') != "Sunday"){
                $dates[] = $today->format('jS F Y');
                $days[] = $today->format('l');
                $date = $today->format('Y-m-d');
                $mk = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->first();
                $directSum[] = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->sum('direct_hrs');
                $indirectSum[] = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->sum('indirect_hrs');
                $loanedSum[] = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->sum('loaned_hrs');
                //$shop_id[] = Attendance::where('date', '=', $date)->sum('loaned_hrs');
                if($mk != null){$marked[] = "Marked"; $color[] = "success";}
                else{$marked[] = "Not Marked"; $color[] = "danger";}
            }
        }

        $data = array(
            'dates' => $dates,
            'days' => $days,
            'marked' => $marked, 'color' => $color,
            'directSum' => $directSum,
            'indirectSum'=>$indirectSum,
            'loanedSum'=> $loanedSum,
            'shops' => $shops,
            'shop' => $shopname,
            'names' => $names, 'colord' =>$colord,
        );

        return view('attendances.attendancesummary')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attendance $attendance)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Attendance  $attendance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Attendance $attendance)
    {
        //
    }

    public function attendacesummary(){
        $shops = Shop::All();
        $selectshops = Shop::pluck('shop_name','id');
        foreach($shops as $sp){
            $names[] = $sp->shop_name;
            $mkd = Attendance::where([['date', '=', Carbon::today()->format('Y-m-d')], ['shop_id', '=', $sp->id]])->first('id');
            if($mkd != null){ $colord[] = "success";}
                    else{ $colord[] = "danger";}
        }

        //return $colord;


        $today = Carbon::now();
        $marked = [];
        for ($i=1; $i<=30; $i++) {
            $today->subDays(1);

            foreach($shops as $shop){
                if($today->format('l') != "Sunday"){
                    $dates[] = $today->format('jS F Y');
                    $days[] = $today->format('l');
                    $date = $today->format('Y-m-d');
                    $mk = Attendance::where([['date', '=', $date], ['shop_id', '=', $shop->id]])->first();
                    $directSum[] = Attendance::where([['date', '=', $date], ['shop_id', '=', $shop->id]])->sum('direct_hrs');
                    $indirectSum[] = Attendance::where([['date', '=', $date], ['shop_id', '=', $shop->id]])->sum('indirect_hrs');
                    $loanedSum[] = Attendance::where([['date', '=', $date], ['shop_id', '=', $shop->id]])->sum('loaned_hrs');
                    $shopname[] = $shop->shop_name;
                    if($mk != null){$marked[] = "Marked"; $color[] = "success";}
                    else{$marked[] = "Not Marked"; $color[] = "danger";}
                }
            }
        }

        $data = array(
            'dates' => $dates,
            'days' => $days,
            'marked' => $marked, 'color' => $color,
            'directSum' => $directSum,
            'indirectSum'=>$indirectSum,
            'loanedSum'=> $loanedSum,
            'shops' => $selectshops,
            'shopnames' => $shopname,
            'names' =>$names,
            'colord'=>$colord,
        );

        return view('attendances.attendancesummary')->with($data);
    }
public function headcount(Request $request){
        if($request->input()){ //return  $request->input('mdate');
            $daterange = $request->input('daterange');
            $datearr = explode('-',$daterange);
            $datefrom = Carbon::parse($datearr[0])->format('Y-m-d');
            $dateto = Carbon::parse($datearr[1])->format('Y-m-d');
        }else{
            $dateto = Carbon::now()->format('Y-m-d');
            $datefrom = Carbon::create($dateto)->startOfMonth()->format('Y-m-d');
        }


        $shops = Shop::where('overtime','=','1')->get(['report_name','id','check_shop']);
        $TTprdnhrs = 0; $AllTThrs = 0; $tthc = 0; $ttdirect = 0; $ttindirect = 0; $tttl = 0; $ttpresent = 0;
        $mtddrhrs = 0; $mtdlnhrs = 0; $mtdotlnhrs = 0;
        foreach($shops as $sp){
            $headcount = Employee::where([['shop_id', '=', $sp->id],['status','=','Active']])
                            ->whereBetween('created_at', ['2021-08-01', $dateto])->count('id');
                $ttheadcount[$sp->id] = $headcount;
                $tthc += $headcount;

            $teaml = Employee::where([['shop_id', '=', $sp->id],['status','=','Active'],['team_leader','=','yes']])
                            ->whereBetween('created_at', ['2021-08-01', $dateto])->count('id');
                $countTL[$sp->id] = $teaml;
                $tttl += $teaml;

            //MTD
            $Mtdhrs = Attendance::whereBetween('date', [$datefrom, $dateto])
                            ->Where('shop_id','=',$sp->id)
                            ->sum(DB::raw('direct_hrs + indirect_hrs + othours'));
                $spmtdlnhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$sp->id)->sum('loaned_hrs');
                $spmtdotlnhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$sp->id)->sum('otloaned_hrs');
                $ttshopshrs = $Mtdhrs + $spmtdlnhrs + $spmtdotlnhrs;
                $MTDtthrs[$sp->id] = $ttshopshrs;
                $AllTThrs += $ttshopshrs ;

            //Production shops
            if($sp->check_shop == 1){
                $spmtddrhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_id',$sp->id)->sum('efficiencyhrs');
                $spmtdlnhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$sp->id)->sum('loaned_hrs');
                $spmtdotlnhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$sp->id)->sum('otloaned_hrs');
                $shopPrdnhrs = $spmtddrhrs + $spmtdlnhrs + $spmtdotlnhrs;
                $MTDPrdnhrs[$sp->id] = $shopPrdnhrs;
                $TTprdnhrs += $shopPrdnhrs;

                //EFFPLANT MTD
                $mtddrhrs += Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_id',$sp->id)->sum(DB::raw('efficiencyhrs'));
                $mtdlnhrs += Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$sp->id)->sum(DB::raw('loaned_hrs'));
                $mtdotlnhrs += Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$sp->id)->sum(DB::raw('otloaned_hrs'));

                $spMTDinput = $shopPrdnhrs;//$mtddrhrs + $mtdlnhrs + $mtdotlnhrs;
                $spMTDoutput = Unitmovement::whereBetween('datetime_out', [$datefrom, $dateto])->where('shop_id',$sp->id)->sum('std_hrs');
                $spMTDplant_eff[$sp->id] = getshopEfficiency($datefrom, $dateto,$sp->id);//($spMTDinput > 0) ? round(($spMTDoutput/$spMTDinput)*100,2) : 0;
            }else{
                $MTDPrdnhrs[$sp->id] = "--";
                $spMTDplant_eff[$sp->id] = "--";
            }

        }

            $MTDinput = $mtddrhrs + $mtdlnhrs + $mtdotlnhrs;
            $MTDoutput = Unitmovement::whereBetween('datetime_out', [$datefrom, $dateto])->sum('std_hrs');
            $lcvfinal = Unitmovement::whereBetween('datetime_out', [$datefrom, $dateto])->where('shop_id',13)->sum('std_hrs');
            $MTDoutput -= $lcvfinal;
            $MTDplant_eff = getPlantEfficiency($datefrom, $dateto); //($MTDinput > 0) ? round(($MTDoutput/$MTDinput)*100,2) : 0;

        $range = Carbon::createFromFormat('Y-m-d', $datefrom)->format('jS M Y').' To '.Carbon::createFromFormat('Y-m-d', $dateto)->format('jS M Y');

        //return $spMTDplant_eff;
        $data = array(
            'shops'=>$shops,
            'ttheadcount'=>$ttheadcount,
            'countTL'=>$countTL,
            'MTDtthrs'=>$MTDtthrs,
            'MTDPrdnhrs'=>$MTDPrdnhrs,
            'TTprdnhrs'=>$TTprdnhrs,    'tttl'=>$tttl,
            'AllTThrs'=>$AllTThrs,      'tthc'=>$tthc,
            'MTDplant_eff'=>$MTDplant_eff,  'spMTDplant_eff'=>$spMTDplant_eff,


            'range'=>$range
        );
        return view('attendances.headcount')->with($data);
    }

    //PRODUCTION OUTPUT
    public function prodnoutput(Request $request){
        if($request->input()){ //return  $request->input('mdate');
            $daterange = $request->input('daterange');
            $datearr = explode('-',$daterange);
            $datefrom = Carbon::parse($datearr[0])->format('Y-m-d');
            $dateto = Carbon::parse($datearr[1])->format('Y-m-d');
        }else{
            $dateto = Carbon::now()->format('Y-m-d');
            $datefrom = Carbon::create($dateto)->startOfMonth()->format('Y-m-d');
        }

        $shops = Shop::where('check_shop','=','1')->get(['id','report_name']);

        $models = Unit_model::get(['id','model_name']);


        //$DAYmodelcount = 0; $WTDmodelcount = 0; $MTDmodelcount = 0; $modelstdhrs = 0;
        $ttstdhours = 0;
        foreach($shops as $sp){
            //Models MTD
            $model[$sp->id] = DB::table('unit_movements')
                ->join('vehicle_units', 'vehicle_units.id', '=', 'unit_movements.vehicle_id')
                ->join('unit_models', 'unit_models.id', '=', 'vehicle_units.model_id')
                ->whereBetween('datetime_out', [$datefrom, $dateto])
                ->where('shop_id','=',$sp->id)
                ->groupBy('unit_models.id')
                ->get(['unit_models.id']);
            $rowspan[$sp->id] = (count($model[$sp->id]) == 0) ? 1 : count($model[$sp->id]);

            //return count($model[$sp->id]);

            if(count($model[$sp->id]) > 0){
                $tthrspmd = 0;
            foreach($model[$sp->id] as $md){
                //No of units per model MTD
                $mtd = DB::table('unit_movements')
                    ->join('vehicle_units', 'vehicle_units.id', '=', 'unit_movements.vehicle_id')
                    ->join('unit_models', 'unit_models.id', '=', 'vehicle_units.model_id')
                    ->whereBetween('datetime_out', [$datefrom, $dateto])->where('shop_id','=',$sp->id)
                    ->where('unit_models.id','=',$md->id)->count();
                $MTDmodelcount[$sp->id][$md->id] = ($mtd) ? $mtd : 0;


                //STD hours per model
                $hrspmd = DB::table('unit_movements')
                    ->join('vehicle_units', 'vehicle_units.id', '=', 'unit_movements.vehicle_id')
                    ->join('unit_models', 'unit_models.id', '=', 'vehicle_units.model_id')
                    ->whereBetween('datetime_out', [$datefrom, $dateto])
                    ->where('shop_id','=',$sp->id)
                    ->where('unit_models.id','=',$md->id)
                    ->value('unit_movements.std_hrs');
                $modelstdhrs[$sp->id][$md->id] = $hrspmd;
                $tthrspmd += $hrspmd*$mtd;
                $ttstdhours += $hrspmd*$mtd;
            }
        }else{
            $tthrspmd = 0;
            $MTDmodelcount[$sp->id][1] = 0; $modelstdhrs[$sp->id][1] = 0;

        }

        $shopmodelhrs[$sp->id] = round($tthrspmd,2);

            //MONTH TO DATE EFFICIENCY
            $mtddrhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_id','=',$sp->id)->sum(DB::raw('efficiencyhrs'));
                $mtdlnhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to','=',$sp->id)->sum(DB::raw('loaned_hrs'));
                $mtdotlnhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('otshop_loaned_to','=',$sp->id)->sum(DB::raw('otloaned_hrs'));
            $MTDinput = $mtddrhrs + $mtdlnhrs + $mtdotlnhrs;

            $MTDoutput = Unitmovement::whereBetween('datetime_out', [$datefrom, $dateto])
                                ->where('shop_id','=',$sp->id)->sum('std_hrs');
            $MTDshop_eff[$sp->id] = getshopEfficiency($datefrom, $dateto,$sp->id);//($MTDinput > 0) ? round(($MTDoutput/$MTDinput)*100,2) : 0;

        }

        //EFFPLANT MTD
        /*$ppmtddrhrs = 0; $ppmtdlnhrs = 0; $ppmtdotlnhrs = 0;
        foreach($shops as $shop){
            $ppmtddrhrs += Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_id',$shop->id)->sum(DB::raw('efficiencyhrs'));
            $ppmtdlnhrs += Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$shop->id)->sum(DB::raw('loaned_hrs'));
            $ppmtdotlnhrs += Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_loaned_to',$shop->id)->sum(DB::raw('otloaned_hrs'));
        }
        $ppMTDinput = $ppmtddrhrs + $ppmtdlnhrs + $ppmtdotlnhrs;
        $ppMTDoutput = Unitmovement::whereBetween('datetime_out', [$datefrom, $dateto])->sum('std_hrs');
        $pplcvfinal = Unitmovement::whereBetween('datetime_out', [$datefrom, $dateto])->where('shop_id',13)->sum('std_hrs');
        $ppMTDoutput -= $pplcvfinal;*/


        $ppMTDplant_eff = getPlantEfficiency($datefrom, $dateto);//($ppMTDinput > 0) ? round(($ppMTDoutput/$ppMTDinput)*100,2) : 0;

        $range = Carbon::createFromFormat('Y-m-d', $datefrom)->format('jS M Y').' To '.Carbon::createFromFormat('Y-m-d', $dateto)->format('jS M Y');
        //return $shopmodelhrs;
        $data = array(
            'shops'=>$shops,
            'model'=>$model,
            'MTDmodelcount'=>$MTDmodelcount,

            'modelstdhrs'=>$modelstdhrs,
            'shopmodelhrs'=>$shopmodelhrs,

            'MTDshop_eff'=>$MTDshop_eff,
            'ttstdhours'=>$ttstdhours,
            'ppMTDplant_eff'=>$ppMTDplant_eff,

            'rowspan'=> $rowspan,

            'fromdate'=>$datefrom,
            'todate'=>$dateto,
            'range'=>$range,

        );
        return view('attendances.prodnoutput')->with($data);
    }



    public function weeklystdhrs(Request $request){
        //return $request->input('mdate');
        if($request->input()){
            $date = $request->input('mdate');
            $todate = Carbon::createFromFormat('m/d/Y',$date)->format('Y-m-d');
        }else{
            $todate = Carbon::today()->format('Y-m-d');
        }


        $shops = Shop::where('check_shop','=','1')->get(['id','report_name']);
        unset($shops[9]);
        //STANDARD HOURS GENERATED AND ACTUAL HOURS
        foreach($shops as $sp){
            $weekStartDate = Carbon::parse($todate)->startOfWeek()->format('Y-m-d');
            $weekEndDate = Carbon::parse($todate)->endOfWeek()->format('Y-m-d');

            while($weekStartDate <= $weekEndDate){
                $dates[] = Carbon::createFromFormat('Y-m-d', $weekStartDate)->format('jS');
                $date = $weekStartDate;

               $act = Attendance::where('date','=', $weekStartDate)->where('shop_id','=',$sp->id)
                                ->sum(DB::raw('efficiencyhrs'));
                    $lnhrs = Attendance::where([['date','=', $weekStartDate],['shop_loaned_to','=',$sp->id]])->sum(DB::raw('loaned_hrs'));
                    $otlnhrs = Attendance::where([['date','=', $weekStartDate],['otshop_loaned_to','=',$sp->id]])->sum(DB::raw('otloaned_hrs'));
                $actual = $act + $lnhrs + $otlnhrs;

                $actualhrs[$sp->id][] = ($actual > 0) ? round($actual,2) : '--';
                $std = Unitmovement::where('datetime_out','=', $weekStartDate)
                                    ->where('shop_id','=',$sp->id)->sum('std_hrs');
                $stdhrs[$sp->id][] = ($std > 0) ? round($std,2) : '--';

                $weekStartDate = Carbon::parse($date)->addDays()->format('Y-m-d');
            }

            $wkStartDate = Carbon::parse($todate)->startOfWeek()->format('Y-m-d');
            $wkEndDate = Carbon::parse($todate)->endOfWeek()->format('Y-m-d');
                $wkact = Attendance::whereBetween('date', [$wkStartDate, $wkEndDate])->where('shop_id','=',$sp->id)
                                ->sum(DB::raw('efficiencyhrs'));
                    $wklnhrs = Attendance::whereBetween('date', [$wkStartDate, $wkEndDate])->where('shop_loaned_to','=',$sp->id)->sum(DB::raw('loaned_hrs'));
                    $wkotlnhrs = Attendance::whereBetween('date', [$wkStartDate, $wkEndDate])->where('otshop_loaned_to','=',$sp->id)->sum(DB::raw('otloaned_hrs'));
                $wkactual = $wkact + $wklnhrs + $wkotlnhrs;

                $weekactualhrs[$sp->id] = ($wkactual > 0) ? round($wkactual,2) : '--';
                $wkstd = Unitmovement::whereBetween('datetime_out', [$wkStartDate, $wkEndDate])
                                    ->where('shop_id','=',$sp->id)->sum('std_hrs');
                $weekstdhrs[$sp->id] = ($wkstd > 0) ? round($wkstd,2) : '--';

        }

        //return $actualhrs;

        $data = array(
            'todate'=>$todate,
            'shops'=>$shops,
            'dates'=>$dates,
            'actualhrs'=>$actualhrs,
            'stdhrs'=>$stdhrs,
            'weekactualhrs'=>$weekactualhrs,
            'weekstdhrs'=>$weekstdhrs,
        );
        return view('attendances.weeklystdhrs')->with($data);
    }


    public function weeklyactualhrs(){
        $todate = Carbon::today()->format('Y-m-d');
        $filday = array('DAY','WTD','MTD');
        $shops = Shop::where('check_shop','=','1')->get(['id','report_name']);
        $data = array(
            'todate'=>$todate,
            'shops'=>$shops,
            'filday'=>$filday,
        );
        return view('attendances.weeklyactualhrs')->with($data);
    }

     public function peopleAttreport(Request $request){
        if($request->input()){
            $activetag = $request->input('rangeid');
            $date = $request->input('mdate');
        }else{
            $start = carbon::now()->startOfMonth()->format('Y-m-d');
            $end = carbon::now()->endOfMonth()->format('Y-m-d');
            $activetag = IndivTarget::whereBetween('month',[$start,$end])->first();
        }

        $shops = Shop::where('check_shop','=',1)->get(['id','report_name']);

        $today = Carbon::today()->format('Y-m-d');

        $today = ($request->input()) ? Carbon::createFromFormat('m/d/Y', $request->input('mdate'))->format('Y-m-d') : $today;

        //DAILY EFFICIENCY
        $TTinput = 0; $TToutput = 0;

        foreach($shops as $shop){
            $inpp = Attendance::where([['date','=',$today],['shop_id','=',$shop->id]])->sum(DB::raw('efficiencyhrs'));
                $lnhrs = Attendance::where([['date','=',$today],['shop_loaned_to','=',$shop->id]])->sum(DB::raw('loaned_hrs'));
                $otlnhrs = Attendance::where([['date','=',$today],['otshop_loaned_to','=',$shop->id]])->sum(DB::raw('otloaned_hrs'));
            $input = $inpp + $lnhrs + $otlnhrs;
            $TTinput += $input;

            $output = Unitmovement::where('datetime_out','=',$today)
                    ->where('shop_id','=',$shop->id)->sum('std_hrs');
            $TToutput += $output;
            $shop_eff[$shop->id] = ($input > 0) ? round(($output/$input)*100,2).'%' : '--';


        //ABSENTIEESM
        $empcount = Attendance::where([['date', '=', $today], ['shop_id', '=', $shop->id]])->count();
        if($empcount != null){
            $expectedhrs = $empcount * 8;
            $hrsworked = Attendance::Where([['date', '=', $today],['shop_id', '=', $shop->id]])
                            ->sum(DB::raw('direct_hrs + indirect_hrs'));
            $absent = $expectedhrs - $hrsworked;
            ($absent > 0) ? $absentiesm[$shop->id] = round(((($absent)/$expectedhrs)*100),2).'%' : $absentiesm[$shop->id] = 0;
        }else{
            $absentiesm[$shop->id] = '--';
        }


        //TEAMLEADER AVAILABILITY
        $direct = 0; $indirect = 0; $tthrs = 0;
        $teamleaders = Employee::where([['team_leader','=','yes'],['shop_id', '=', $shop->id],['status','=','Active']])->get('id');
        foreach($teamleaders as $tl){
            $direct += Attendance::where([['staff_id','=',$tl->id],['date', '=', $today]])
                        ->sum(DB::raw('direct_hrs + othours'));
            $indirect += Attendance::where([['staff_id','=',$tl->id],['date', '=', $today]])
                        ->sum(DB::raw('indirect_hrs + indirect_othours'));
        }
        $tthrs = $indirect+$direct;

        $shopTLavail[$shop->id] = ($tthrs > 0) ? round(($indirect/$tthrs)*100,2).'%' : '--';

        // TL TARGETS
        $shopsTLtarget[$shop->id] = round(getshopTLAtarget($shop->id),2);

    }

        $data = array(
            'abT'=>(getTarget($today) == '0') ? 0: getTarget($today)->absentieesm,
            'effT'=>(getTarget($today) == '0') ? 0: getTarget($today)->efficiency,
            'shopsTLtarget'=>$shopsTLtarget, 'shops'=>$shops,
            'shop_eff'=>$shop_eff,
            'absentiesm'=>$absentiesm,
            'shopTLavail'=>$shopTLavail,
            'today'=>$today,
        );
        return view('attendances.peopleAttreport')->with($data);
    }


    public function settargets(request $request){

        $targets =  IndivTarget::All();

        $data = array(
            'targets'=>$targets,

        );
        return view('attendances.settargets')->with($data);
    }

    public function createtargets(){
        $shops = Shop::where('check_shop','=','1')->get(['id','report_name']);
        $startofyr = Carbon::now()->startOfYear()->format('Y-m-d');
        $endofyr = Carbon::now()->endOfYear()->format('Y-m-d');

        $selectedmonth = Carbon::parse()->format('F Y');
        $thisyeartargets =  IndivTarget::whereBetween('month',[$startofyr,$endofyr])->get();

        $data = array(
            'shops'=>$shops,
            'selectedmonth'=>$selectedmonth,

            'thisyeartargets'=>$thisyeartargets,
        );
        return view('attendances.createtargets')->with($data);
    }

    public function savetargets(Request $request){

        $validator = Validator::make($request->all(), [
            'month' => 'required',
            'pefficiency' => 'required',
            'pabsentieesm' => 'required',
            'ptlavailability' => 'required',

        ]);

        if ($validator->fails()) {
            Toastr::error('Sorry! All fields are required.');
            return back();
        }

        $month = Carbon::createFromFormat('F Y',$request->input('month'))->format('Y-m-d');
        $efficiency = $request->input('efficiency');
        $absentieesm = $request->input('absentieesm');
        $tlavailability = 0;//$request->input('tlavailability');


        try{
            DB::beginTransaction();

            $tgt = IndivTarget::where('month',$month)->first();
            if(!isset($tgt)){
                $tgt = new IndivTarget;
            }

            $tgt->month = $month;
            $tgt->efficiency = $request->input('pefficiency');
            $tgt->absentieesm = $request->input('pabsentieesm');
            $tgt->tlavailability = $request->input('ptlavailability');

            $tgt->user_id = auth()->user()->id;
            $tgt->save();


            DB::commit();
            Toastr::success('Targets saved successfully','Saved');
            return back();
    }
    catch(\Exception $e){
        \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        DB::rollback();
        Toastr::error('An error occured, Targets not saved.','Whoops!');
            return back();
    }
}



public function destroytag($id){
    if (request()->ajax()) {
        try {
            $can_be_deleted = true;
            $error_msg = '';

            //Check if any routing has been done
           //do logic here
           $tag = IndivTarget::where('id', $id)->first();

            if ($can_be_deleted) {
                if (!empty($tag)) {
                    DB::beginTransaction();
                    //Delete Query  details
                    IndivTarget::where('id', $id)->delete();
                    $tag->delete();
                    DB::commit();

                    $output = ['success' => true,
                            'msg' => "Target Deleted Successfully"
                        ];
                }else{
                    $output = ['success' => false,
                            'msg' => "Could not be deleted, Child record exist."
                        ];
                }
            } else {
                $output = ['success' => false,
                            'msg' => $error_msg
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

public function reportsummary(){
    $today = Carbon::today()->format('Y-m-d');
    $firstthismonth = Carbon::now()->startOfMonth()->format('Y-m-d');
    $firstthisyear = Carbon::create(Carbon::now()->year,1,1)->format('Y-m-d');

    //CUMMULATIVE HOURS WORKED
    $cumhrsyear = Attendance::whereBetween('date', [$firstthisyear, $today])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
    //CUMMULATIVE HOURS GENERATED
    $cumstdhrsyear = Unitmovement::whereBetween('datetime_out', [$firstthisyear, $today])
                                ->sum('std_hrs');
    //CUMMYLATIVE INDIRECT HOURS
    $cumindirecthrsyear = Attendance::whereBetween('date', [$firstthisyear, $today])
                        ->sum(DB::raw('indirect_hrs '));
    //MONTH TO DATE EFFICIENCY
    $YTDinput = Attendance::whereBetween('date', [$firstthisyear, $today])
                ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
    $YTDoutput = Unitmovement::whereBetween('datetime_out', [$firstthisyear, $today])
                ->sum('std_hrs');
    $YTDcumeff = ($YTDinput > 0) ? round(($YTDoutput/$YTDinput)*100,2) : 0;
    //return $YTDcumeff;

    $data = array(
        'cumhrsyear'=>$cumhrsyear,
        'cumstdhrsyear'=>$cumstdhrsyear,
        'cumindirecthrsyear'=>$cumindirecthrsyear,
        'YTDcumeff'=>$YTDcumeff,
    );
    return view('attendances.reportsummary')->with($data);
}



public function yestreportsummary(){
    $yesterday = Carbon::yesterday()->format('Y-m-d');
    $firstthismonth = Carbon::now()->startOfMonth()->format('Y-m-d');
    $firstthisyear = Carbon::create(Carbon::now()->year,1,1)->format('Y-m-d');

    //CUMMULATIVE HOURS WORKED
    $cumhrsyear = Attendance::whereBetween('date', [$firstthisyear, $yesterday])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
    //CUMMULATIVE HOURS GENERATED
    $cumstdhrsyear = Unitmovement::whereBetween('datetime_out', [$firstthisyear, $yesterday])
                                ->sum('std_hrs');
    //CUMMYLATIVE INDIRECT HOURS
    $cumindirecthrsyear = Attendance::whereBetween('date', [$firstthisyear, $yesterday])
                        ->sum(DB::raw('indirect_hrs '));

    $data = array(
        'cumhrsyear'=>$cumhrsyear,
        'cumstdhrsyear'=>$cumstdhrsyear,
        'cumindirecthrsyear'=>$cumindirecthrsyear,

    );
    return view('attendances.yestreportsummary')->with($data);
}

public function plantattendancereg(Request $request){

    $shops = Shop::where('overtime','=','1')->get(['id','report_name']);
	//unset($shops[9]);
    foreach($shops as $sp){

        if($request->input()){
            $date = $request->input('mdate');
           $date1 = Carbon::createFromFormat('F Y', $date)->format('Y-m-d');
           $date = Carbon::createFromFormat('Y-m-d', $date1);
           $firstthismonth = $date->startOfMonth()->toDateString();
           $endthismonth = $date->endOfMonth()->toDateString();
           $today = $endthismonth;
       }else{
           $today = Carbon::today()->format('Y-m-d');
           $firstthismonth = Carbon::now()->startOfMonth()->format('Y-m-d');
       }
       //return $firstthismonth;
       $allschdates = Production_target::whereBetween('date', [$firstthismonth, $today])
                        ->groupby('date')->get(['date']);
       //vehicle_units::whereBetween('offline_date', [$firstthismonth, $today])
                            //->groupby('offline_date')->get(['offline_date']);

        if(count($allschdates) == 0){
            Toastr::error('Sorry, There is no schedules for the month.','Whoops!');
            return back();
        }
       $schdates = [];
        foreach($allschdates as $schdt){
            $schdates[] = $schdt->date;
        }


        for($n = 0; $n < count($schdates); $n++){
        //while($firstthismonth <= $today){
            $dates[] = Carbon::createFromFormat('Y-m-d', $schdates[$n])->format('jS');
            $date = $firstthismonth;

                $mked = Attendance::where([['date', '=', $schdates[$n]], ['shop_id', '=',$sp->id]])->first();
                $marked[$sp->id][] = (!empty($mked)) ? 1 : 0;
                if(!empty($mked)){
                    $status = Attendance_status::where([['date', $schdates[$n]], ['shop_id',$sp->id]])->value('status_name');
                    $approval[$sp->id][] = ($status == 'approved') ? 1 : 0;
                }else{
                    $approval[$sp->id][] = 0;
                }
        }
    }

    //return $approval;
    $data = array(
        'today'=>$today,
        'dates'=>$dates,
        'count'=>count($schdates),
        'marked'=>$marked, 'approval'=>$approval,
        'shops'=>$shops,
    );
    return view('attendances.plantattendancereg')->with($data);
}

public function attendceregister(Request $request)
{
    if($request->input()){
        $date = $request->input('mdate');
       $date1 = Carbon::createFromFormat('F Y', $date)->format('Y-m-d');
       $date = Carbon::createFromFormat('Y-m-d', $date1);
       $firstthismonth = $date->startOfMonth()->toDateString();
       $endthismonth = $date->endOfMonth()->toDateString();
       $today = Carbon::today()->format('Y-m-d');//$endthismonth;
       $shopid = $request->input('shop');
   }else{
       $today = Carbon::today()->format('Y-m-d');
       $firstthismonth = Carbon::now()->startOfMonth()->format('Y-m-d');
       if(shop() == "noshop"){
            $shopid = 1;
        }else{
            $shopid = Auth()->User()->section;
        }
   }

   //PRODUCTION DAYS
   $allschdates = Production_target::whereBetween('date', [$firstthismonth, $today])
                        ->groupby('date')->get(['date']);

    $holidays = WorkSchedule::whereBetween('date', [$firstthismonth, $today])->pluck('date')->toArray();
   
        if(count($allschdates) == 0){
            Toastr::error('Sorry, There is no schedules for the month.','Whoops!');
            return back();
            }
        foreach($allschdates as $schdt){  
			if((Carbon::parse($schdt->date)->dayOfWeek == 0) || (Carbon::parse($schdt->date)->dayOfWeek == 6) || in_array($schdt->date,$holidays)){
			 }else{
				$prodndays[] = $schdt->date;
			 }
		 
		
		}
	
   $shopname = Shop::where('id','=',$shopid)->value('report_name');

   $employees = Employee::where([['shop_id','=',$shopid],['status','Active']])
		->orderBy('staff_no','ASC')
		->get(['id','staff_no','staff_name','team_leader']);
		
	//$nodays = count($prodndays);  $noemployees = count($employees);
	//$expectedhrs = $nodays * $noemployees * 8;
	
	$empdays = 0;
	
   foreach($employees as $emp){

        $tthrs = 0;
        for($n = 0; $n < count($prodndays); $n++){
            $dates[] = Carbon::createFromFormat('Y-m-d', $prodndays[$n])->format('jS');

            $hours = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
            ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $emphrs[$emp->id][] = $hours; $tthrs += $hours;
			
			$existatt = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])->first();
			if($existatt){ $empdays += 1; }
        }
        $ttemphrs[$emp->id] = $tthrs;
   }
   $expectedhrs = $empdays * 8;

   //Totals
    $totalhr = 0;
    for($n = 0; $n < count($prodndays); $n++){
        $allemp = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid]])->count();
        $count = 0; $availhr = 0;
        foreach($employees as $emp){
        $hrss = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $count = ($hrss > 0) ? $count += 1 : $count;

        //TEAMLEADER AVAILABILITY
        if($emp->team_leader == 'yes'){
            $indirect = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('indirect_hrs'));
            $totalhr = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
        }

        $availhr = ($totalhr > 0) ? round(($indirect/$totalhr)*100,2) : 0;
        }
         $ttpresent[] = $count;
         $ttemp[] = $allemp;
         $tlavail[] = $availhr;
    }

    //return $tlavail;

   //Per date
   $tthrs = 0; $ttsum = 0;
        for($n = 0; $n < count($prodndays); $n++){
            $tthh = Attendance::where([['date','=',$prodndays[$n]],['shop_id','=',$shopid]])
                ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $ttsum += $tthh;  $hrsperdate[] = $tthh;


        }

   //return $emphrs;
    $data = array(
        'shopid'=>$shopid,
        'employees' => $employees, 'ttpresent'=>$ttpresent,
        'today'=>$today, 'ttemp'=>$ttemp,'tlavail'=>$tlavail,
        'dates'=>$dates,
        'count'=>count($prodndays),
        'emphrs'=>$emphrs, 'ttemphrs'=>$ttemphrs, 'hrsperdate'=>$hrsperdate, 'ttsum'=>$ttsum,
        'shopname'=>$shopname,
        'selectshops'=>Shop::where('overtime','=',1)->get(['report_name','id']),
		'expectedhrs'=>$expectedhrs,
    );
    return view('attendances.attendceregister')->with($data);
}


public function exportattendRegister(Request $request){
    if($request->input()){
       $date = $request->input('mdate');
       $date1 = Carbon::createFromFormat('F Y', $date)->format('Y-m-d');
       $date = Carbon::createFromFormat('Y-m-d', $date1);
       $firstthismonth = $date->startOfMonth()->toDateString();
       $endthismonth = $date->endOfMonth()->toDateString();
       $today = $endthismonth;
       $shopid = $request->input('shop');
   }else{
       $today = Carbon::today()->format('Y-m-d');
       $firstthismonth = Carbon::now()->startOfMonth()->format('Y-m-d');
       $shopid = 1;
   }

   //PRODUCTION DAYS
   $allschdates = Production_target::whereBetween('date', [$firstthismonth, $today])
                        ->groupby('date')->get(['date']);

        if(count($allschdates) == 0){
            Toastr::error('Sorry, There is no schedules for the month.','Whoops!');
            return back();
            }
        foreach($allschdates as $schdt){  $prodndays[] = $schdt->date; }

   $shopname = Shop::where('id','=',$shopid)->value('report_name');

   $employees = Employee::where([['shop_id','=',$shopid],['status','Active']])
	->get(['id','staff_no','staff_name','team_leader'])
	->orderBy('staff_no', 'ASC');
   foreach($employees as $emp){

        $tthrs = 0;
        for($n = 0; $n < count($prodndays); $n++){
            $dates[] = Carbon::createFromFormat('Y-m-d', $prodndays[$n])->format('jS');

            $hours = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
            ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $emphrs[$emp->id][] = $hours; $tthrs += $hours;
        }
        $ttemphrs[$emp->id] = $tthrs;
   }

   //Totals
    $totalhr = 0;
    for($n = 0; $n < count($prodndays); $n++){
        $allemp = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid]])->count();
        $count = 0; $availhr = 0;
        foreach($employees as $emp){
        $hrss = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $count = ($hrss > 0) ? $count += 1 : $count;

        //TEAMLEADER AVAILABILITY
        if($emp->team_leader == 'yes'){
            $indirect = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('indirect_hrs'));
            $totalhr = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
        }

        $availhr = ($totalhr > 0) ? round(($indirect/$totalhr)*100,2) : 0;
        }
         $ttpresent[] = $count;
         $ttemp[] = $allemp;
         $tlavail[] = $availhr;
    }

    //return $tlavail;

   //Per date
   $tthrs = 0; $ttsum = 0;
        for($n = 0; $n < count($prodndays); $n++){
            $tthh = Attendance::where([['date','=',$prodndays[$n]],['shop_id','=',$shopid]])
                ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $ttsum += $tthh;  $hrsperdate[] = $tthh;


        }

   //return $emphrs;
    $data = array(
        'shopid'=>$shopid,
        'employees' => $employees, 'ttpresent'=>$ttpresent,
        'today'=>$today, 'ttemp'=>$ttemp,'tlavail'=>$tlavail,
        'dates'=>$dates,
        'count'=>count($prodndays),
        'emphrs'=>$emphrs, 'ttemphrs'=>$ttemphrs, 'hrsperdate'=>$hrsperdate, 'ttsum'=>$ttsum,
        'shopname'=>$shopname,
        'selectshops'=>Shop::where('overtime','=',1)->get(['report_name','id']),
    );
    return Excel::download(new AttndRegisterView($data), 'register.xlsx');
}


//PDF
public function attendRegisterpdf(Request $request){
    if($request->input()){
        $date = $request->input('mdate');
       $date1 = Carbon::createFromFormat('F Y', $date)->format('Y-m-d');
       $date = Carbon::createFromFormat('Y-m-d', $date1);
       $firstthismonth = $date->startOfMonth()->toDateString();
       $endthismonth = $date->endOfMonth()->toDateString();
       $today = $endthismonth;
       $shopid = $request->input('shop');
   }else{
       $today = Carbon::today()->format('Y-m-d');
       $firstthismonth = Carbon::now()->startOfMonth()->format('Y-m-d');
       $shopid = 1;
   }

   //PRODUCTION DAYS
   $allschdates = Production_target::whereBetween('date', [$firstthismonth, $today])
                        ->groupby('date')->get(['date']);

        if(count($allschdates) == 0){
            Toastr::error('Sorry, There is no schedules for the month.','Whoops!');
            return back();
            }
        foreach($allschdates as $schdt){  $prodndays[] = $schdt->date; }

   $shopname = Shop::where('id','=',$shopid)->value('report_name');

   $employees = Employee::where('shop_id','=',$shopid)->get(['id','staff_no','staff_name','team_leader']);
   foreach($employees as $emp){

        $tthrs = 0;
        for($n = 0; $n < count($prodndays); $n++){
            $dates[] = Carbon::createFromFormat('Y-m-d', $prodndays[$n])->format('jS');

            $hours = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
            ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $emphrs[$emp->id][] = $hours; $tthrs += $hours;
        }
        $ttemphrs[$emp->id] = $tthrs;
   }

   //Totals
    $totalhr = 0;
    for($n = 0; $n < count($prodndays); $n++){
        $allemp = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid]])->count();
        $count = 0; $availhr = 0;
        foreach($employees as $emp){
        $hrss = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $count = ($hrss > 0) ? $count += 1 : $count;

        //TEAMLEADER AVAILABILITY
        if($emp->team_leader == 'yes'){
            $indirect = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('indirect_hrs'));
            $totalhr = Attendance::where([['date','=', $prodndays[$n]],['shop_id','=',$shopid],['staff_id','=',$emp->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
        }

        $availhr = ($totalhr > 0) ? round(($indirect/$totalhr)*100,2) : 0;
        }
         $ttpresent[] = $count;
         $ttemp[] = $allemp;
         $tlavail[] = $availhr;
    }

    //return $tlavail;

   //Per date
   $tthrs = 0; $ttsum = 0;
        for($n = 0; $n < count($prodndays); $n++){
            $tthh = Attendance::where([['date','=',$prodndays[$n]],['shop_id','=',$shopid]])
                ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
            $ttsum += $tthh;  $hrsperdate[] = $tthh;


        }

   //return $emphrs;
    $data = array(
        'employees' => $employees, 'ttpresent'=>$ttpresent,
        'today'=>$today, 'ttemp'=>$ttemp,'tlavail'=>$tlavail,
        'dates'=>$dates,
        'count'=>count($prodndays),
        'emphrs'=>$emphrs, 'ttemphrs'=>$ttemphrs, 'hrsperdate'=>$hrsperdate, 'ttsum'=>$ttsum,
        'shopname'=>$shopname,
        'selectshops'=>Shop::where('overtime','=',1)->get(['report_name','id']),
    );
    $pdfdata = PDF::loadview('attendances.attendanceregister_table',$data, [], [
        'orientation' => 'L',
        'default_font_size' => '14',
      ]);
       return $pdfdata->download('attendanceregister.pdf');
}


	public function plantattendance(Request $request){ 
		
         if($request->input()){ //return  $request->input('mdate');
            $daterange = $request->input('daterange');
            $datearr = explode('-',$daterange);
            $datefrom = Carbon::parse($datearr[0])->format('Y-m-d');
            $dateto = Carbon::parse($datearr[1])->format('Y-m-d');
        }else{
            $dateto = Carbon::now()->format('Y-m-d');
            $datefrom = Carbon::create($dateto)->startOfMonth()->format('Y-m-d');
        }

		$abshops = [1,2,3,5,6,8,10,11,12,13,16,17,18,22,23,24,25]; //except   30,29,27,21,20,19
        $shops = Shop::whereIn('id',$abshops)->get(['id','report_name']); 
		$holidays = WorkSchedule::whereBetween('date', [$datefrom, $dateto])->pluck('date')->toArray();
		$planttexpectedhrs = 0; $plantworkedhrs = 0;
		
		foreach($shops as $shop){			
   
			$workingdays = 0;
			 $allattendance = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_id',$shop->id)->get(['date']);
			foreach($allattendance as $attend){
				if((Carbon::parse($attend->date)->dayOfWeek == 0) || (Carbon::parse($attend->date)->dayOfWeek == 6) || in_array($attend->date,$holidays)){
				 }else{
					$workingdays += 8;
				 }
			}
			$shopexpecetdhrs[$shop->id] = $workingdays;
			$planttexpectedhrs += $workingdays;

			$shopworkedhrs = Attendance::whereBetween('date', [$datefrom, $dateto])->where('shop_id',$shop->id)
					->sum(DB::raw('direct_hrs + indirect_hrs'));
					
			$shopworkedhours[$shop->id] = $shopworkedhrs;
			$plantworkedhrs += $shopworkedhrs;	
			}
			
			$absentism = (($planttexpectedhrs - $plantworkedhrs)/$planttexpectedhrs)*100;
          
		
    
		$range = Carbon::createFromFormat('Y-m-d', $datefrom)->format('jS M Y').' To '.Carbon::createFromFormat('Y-m-d', $dateto)->format('jS M Y');
        $data = array(
            'shops'=>$shops,            
            'range'=>$range,
			'shopexpecetdhrs'=>$shopexpecetdhrs,
			'shopworkedhours'=>$shopworkedhours,
			'planttexpectedhrs'=>$planttexpectedhrs,
			'plantworkedhrs'=>$plantworkedhrs,
			'absentism'=>$absentism,
			
        );
		return view('attendances.plantattendance')->with($data);
	}

    public function today_attendance_view(){ 

        $today = Carbon::today()->format('Y-m-d');
        $shops = Shop::where('overtime','=','1')->get(['report_name','id']);
         $attendances = Attendance_status::whereHas('shop',function ($query) {
             $query->where('overtime', '1');
        })->with(['shop'=>function ($query){
             $query->where('overtime', '1');
        }])->where('date', $today)->get();
 
       $emps= Employee::where('status','Active')->where('outsource','no')->get();
 
       $emp_attendances=Attendance::where('date',$today)->whereHas('employee',function ($query) {
         $query->where('status','Active')->where('outsource','no');
    })->with([ 'employee'=>function($q){
     $q->where('status','Active')->where('outsource','no');
    }])->get();
        $confirmedtoday=[];
        $colord=[];
        $count_presenttoday=[];
         foreach($shops as $sp){
             $names[$sp->id] = $sp->report_name;
             $status=null;
            
             foreach ($attendances as $tt) {
                 if ($sp->id == $tt->shop_id) {
                     $status = $tt->status_name;
                     if (empty($status)) {
                         continue;
                     }
                    
                 }  
             }
             $coun_emp=0;
             foreach($emps as $emp){
                 if ($sp->id == $emp->shop_id) {
                     $coun_emp++;
                 }
 
             }
          
            
             $confirmedtoday[$sp->id] = ($status == "approved") ? "check" : "";
             $cstatus ='danger';
             if($status == 'approved' || $status == "submitted"){
                $cstatus='success';

             }else if($status == 'saved'){
                $cstatus='warning';

             }
             $colord[$sp->id] =$cstatus;
             $count_TT[$sp->id] = $coun_emp;
 
             $presenttoday=0;
             foreach($emp_attendances as $atts){
               
               
                 if ($sp->id == $atts->employee->shop_id) {
                     $hrs=$atts->direct_hrs+$atts->indirect_hrs+$atts->loaned_hrs;
                     ($hrs > 0) ? $presenttoday = $presenttoday + 1 : $presenttoday = $presenttoday;
                     //break;
                 }
             
             }
             $count_presenttoday[$sp->id] = $presenttoday;
             
 
         }
    
 //dd($count_presenttoday);
       
         $data = array(
            'names' =>$names,
            'shops'=>$shops,
            'colord'=>$colord,
            'count_TT'=>$count_TT,
            'count_presenttoday'=>$count_presenttoday,
            'confirmedtoday'=>$confirmedtoday,
         

        );
        return view('attendances.partials.today')->with($data);



    }


    public function yesterday_attendance_view(){ 

        $today = Carbon::yesterday()->format('Y-m-d');
         $shops = Shop::where('overtime','=','1')->get(['report_name','id']);
         $attendances = Attendance_status::whereHas('shop',function ($query) {
             $query->where('overtime', '1');
        })->with(['shop'=>function ($query){
             $query->where('overtime', '1');
        }])->where('date', $today)->get();
 
       $emps= Employee::where('status','Active')->where('outsource','no')->get();
 
       $emp_attendances=Attendance::where('date',$today)->whereHas('employee',function ($query) {
         $query->where('status','Active')->where('outsource','no');
    })->with([ 'employee'=>function($q){
     $q->where('status','Active')->where('outsource','no');
    }])->get();
        $confirmedtoday=[];
        $colord=[];
        $count_presenttoday=[];
         foreach($shops as $sp){
             $names[$sp->id] = $sp->report_name;
             $status=null;
            
             foreach ($attendances as $tt) {
                 if ($sp->id == $tt->shop_id) {
                     $status = $tt->status_name;
                     if (empty($status)) {
                         continue;
                     }
                    
                 }  
             }
             $coun_emp=0;
             foreach($emps as $emp){
                 if ($sp->id == $emp->shop_id) {
                     $coun_emp++;
                 }
 
             }
            
             $confirmedtoday[$sp->id] = ($status == "approved") ? "check" : "";
             $cstatus ='danger';
             if($status == 'approved' || $status == "submitted"){
                $cstatus='success';

             }else if($status == 'saved'){
                $cstatus='warning';

             }
             $colord[$sp->id] =$cstatus;
             $count_TT[$sp->id] = $coun_emp;
 
             $presenttoday=0;
             foreach($emp_attendances as $atts){
                 if ($sp->id == $atts->shop_id) {
                     $hrs=$atts->direct_hrs+$atts->indirect_hrs+$atts->loaned_hrs;
                     ($hrs > 0) ? $presenttoday = $presenttoday + 1 : $presenttoday = $presenttoday;
                 }
             
             }
             $count_presenttoday[$sp->id] = $presenttoday;
             
 
         }
        
        
       
         $data = array(
            'names' =>$names,
            'shops'=>$shops,
            'colord'=>$colord,
            'count_TT'=>$count_TT,
            'count_presenttoday'=>$count_presenttoday,
            'confirmedtoday'=>$confirmedtoday,
         

        );
        return view('attendances.partials.today')->with($data);



    }

    
}
