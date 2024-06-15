<?php
namespace App\Http\Controllers\attendancepreview;
//use App\Models\attendancepreview\AttendancePreview;
use App\Models\attendancepreview\Attendance_remarks;
use App\Models\attendancestatus\Attendance_status;
use App\Models\reviewconversation\Review_conversation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\employee\Employee;
use App\Models\shop\Shop;
use App\Models\attendance\Attendance;
use App\Models\defaultattendance\DefaultAttendanceHRS;
use App\Models\productiontarget\Production_target;
use App\Models\workschedule\WorkSchedule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
class AttendancePreviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $today = Carbon::today()->format('Y-m-d');
        $yesterday = Carbon::yesterday()->format('Y-m-d');
        $shops = Shop::where('overtime','=','1')->get(['id','report_name']);
        $selectshops = Shop::pluck('report_name','id');
        foreach($shops as $sp){
            $names[] = $sp->report_name;
            $check1 = Attendance_status::where([['date', '=', $today], ['shop_id', '=', $sp->id]])->value('status_name');
            $checky1 = Attendance_status::where([['date', '=', $yesterday], ['shop_id', '=', $sp->id]])->value('status_name');
            $confirmedtoday[] = ($check1 == "approved") ? "check" : "";
            $confirmedyesterday[] = ($checky1 == "approved") ? "check" : "";
            $check = Attendance_status::where([['date', '=', $today], ['shop_id', '=', $sp->id]])->value('status_name');
            $checky = Attendance_status::where([['date', '=', $yesterday], ['shop_id', '=', $sp->id]])->value('status_name');
            $colord[] = ($check == "" || $check == 'saved' || $check == "reveiw") ? "success" : "warning";
            $colory[] = ($checky == "" || $checky == 'saved' || $checky == "reveiw") ? "success" : "warning";
            $count_TT[] = Employee::where([['shop_id', '=', $sp->id],['status','=','Active']])->count('id');
            $empids = Employee::where([['shop_id','=',$sp->id],['status','=','Active']])->get('id');
            $presenttoday = 0; $presentyesterday = 0;
            foreach($empids as $empid){
                $hrs = Attendance::Where([['date', '=', $today],['staff_id','=',$empid->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
                ($hrs > 0) ? $presenttoday = $presenttoday + 1 : $presenttoday = $presenttoday;
                $hrs1 = Attendance::Where([['date', '=', $yesterday],['staff_id','=',$empid->id]])
                        ->sum(DB::raw('direct_hrs + indirect_hrs + loaned_hrs'));
                ($hrs1 > 0) ? $presentyesterday = $presentyesterday + 1 : $presentyesterday = $presentyesterday;
            }
            $count_presenttoday[] = $presenttoday;
            $count_presentyesterday[] = $presentyesterday;
        }
        $usershopid = (Auth()->User()->section == 'ALL') ? 0 : Auth()->User()->section;
        $proddayys = Attendance::groupBy('date')->whereBetween('date',['2021-11-23',Carbon::today()->format('Y-m-d')])
                    ->where('shop_id','=',$usershopid)->get('date');
        $unlogged = []; $submitted = []; $reviews = [];
        foreach($proddayys as $dayy){
            $logged = Attendance_status::where([['date','=',$dayy->date],['shop_id','=',Auth()->User()->section]])->first();
            if($logged == ""){
                $unlogged[] = Carbon::createFromFormat('Y-m-d', $dayy->date)->format('d M Y');
            }
            $submit = Attendance_status::where([['date','=',$dayy->date],['shop_id','=',Auth()->User()->section]])->value('status_name');
            if($submit == "submitted"){
                $submitted[] = Carbon::createFromFormat('Y-m-d', $dayy->date)->format('d M Y');
            }
            $review = Attendance_status::where([['date','=',$dayy->date],['shop_id','=',Auth()->User()->section]])->value('status_name');
            if($review == "review"){
                $reviews[] = Carbon::createFromFormat('Y-m-d', $dayy->date)->format('d M Y');
            }
        }
        //return $submitted;
        $data = array(
            'shops' => Shop::where('overtime','=','1')->pluck('report_name','id'),
            'unlogged'=>$unlogged, 'submitted'=>$submitted, 'reviews'=>$reviews,
            'names' =>$names,
            'colord'=>$colord,
            'colory'=>$colory,
            'count_TT'=>$count_TT,
            'count_presenttoday'=>$count_presenttoday,
            'count_presentyesterday'=>$count_presentyesterday,
            'confirmedtoday'=>$confirmedtoday,
            'confirmedyesterday'=>$confirmedyesterday,
        );
       return view('attendancepreview.attendance_view')->with($data);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function checkattendance($id){
        if(isset($id)){
            $status = Attendance_status::where('id',$id)->first();
            $mdate =Carbon::createFromFormat('Y-m-d', $status->date)->format('m/d/Y');
            $shopid = $status->shop_id;
        }else{
            $mdate =$request->input('mdate');
            $shopid = $request->input('shop');
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
        //CHECK LOANEES
        $loanee = Attendance::where([['date', '=', $date], ['otshop_loaned_to', '=', $shopid]])->first();
        $check = Attendance::where([['loan_confirm', '=', 1],['date', '=', $date], ['otshop_loaned_to', '=', $shopid]])
                                ->first();
        //return $date;
       $marked = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->first();
        if($marked != null){
            //$shopname = Shop::where('id', $shopid)->value('shop_name');
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
            $indirectshop = Shop::where('id','=',$shopid)->value('check_shop');
            //SUBMISSION STATUS
            $attstatus = Attendance_status::where([['shop_id','=',$shopid],['date','=',$date]])->first();
                if($attstatus == "" || $attstatus->status_name == "saved"){
                    Toastr::error('Sorry! Attendance Not Yet Marked','Not Marked');
                    return back();
                }
            //CONVERSATION
            $statusid = Attendance_status::where([['shop_id','=',$shopid],['date','=',$date]])->value('id');
            if(!empty($statusid)){
                $conversation = Review_conversation::where('statusid','=',$statusid)
                                ->get(['user_id','statusid','sender','message','created_at']);
            }
            $date = Carbon::createFromFormat('m/d/Y', $mdate)->format('Y-m-d');
           // dd( $date);
            //$indrct = Attendance::where([['staff_id',296],['date','2022-02-15'], ['shop_id',2]])->value('indirect_hrs');
            //return $rr = ($indrct!="")? "ee": $indrct;
            //Loading all employees
            $employees = Employee::where([['status','Active']])->whereHas('empattendance', function ($query) use($date, $shopid) {
                $query->where([['date', '=', $date], ['shop_id', '=', $shopid]]);
            })->with(['empattendance' => function ($q) use($date, $shopid) {
                $q->where([['date', '=', $date], ['shop_id', '=', $shopid]]);
            }])->get();
           
            foreach($employees as $empl){
               

                foreach( $empl->empattendance as $row){
                    $attid[$empl->id] = $row->id;
                    $drct = $row->direct_hrs;
                    $direct[$empl->id] = ($drct!='') ? $drct : '';
                    $indrct =$row->indirect_hrs;
                    $indirect[$empl->id] = ($indrct!='') ? $indrct : '';
                    $lnhrs = $row->loaned_hrs;
                    $loanhrs[$empl->id] = ($lnhrs!='') ? $lnhrs : '';
                    $spLnto = $row->shop_loaned_to;
                    $shoploanto[$empl->id] = ($spLnto!='') ? $spLnto : '';
                    $authhrs = $row->auth_othrs;
                    $authhours[$empl->id] = ($authhrs!='') ? $authhrs : '';
                    $ot = $row->othours;
                    $othrs[$empl->id] = ($ot!='') ? $ot : '';
                    $inOThrs = $row->indirect_othours;
                    $indirOThrs[$empl->id] = ($inOThrs!='') ? $inOThrs : '';
                    $otlnhrs = $row->otloaned_hrs;
                    $otloanhrs[$empl->id] = ($otlnhrs!='') ? $otlnhrs : '';
                    $otlnshop = $row->otshop_loaned_to;
                    $otshopln[$empl->id] = ($otlnshop!='') ? $otlnshop : '';
                    $dsc = $row->workdescription;
                    $desc[$empl->id] = ($dsc!='') ? $dsc : '';
                    $sumHrs[$empl->id] = $drct + $indrct + $lnhrs + $ot + $inOThrs;
                }
               /* $drct = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('direct_hrs');
                $direct[$empl->id] = ($drct!='') ? $drct : '';
                $indrct = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('indirect_hrs');
                $indirect[$empl->id] = ($indrct!='') ? $indrct : '';
                $lnhrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('loaned_hrs');
                $loanhrs[$empl->id] = ($lnhrs!='') ? $lnhrs : '';
                $spLnto = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('shop_loaned_to');
                $shoploanto[$empl->id] = ($spLnto!='') ? $spLnto : '';
                $authhrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('auth_othrs');
                $authhours[$empl->id] = ($authhrs!='') ? $authhrs : '';
                $ot = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('othours');
                $othrs[$empl->id] = ($ot!='') ? $ot : '';
                $inOThrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('indirect_othours');
                $indirOThrs[$empl->id] = ($inOThrs!='') ? $inOThrs : '';
                $otlnhrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('otloaned_hrs');
                $otloanhrs[$empl->id] = ($otlnhrs!='') ? $otlnhrs : '';
                $otlnshop = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('otshop_loaned_to');
                $otshopln[$empl->id] = ($otlnshop!='') ? $otlnshop : '';
                $dsc = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('workdescription');
                $desc[$empl->id] = ($dsc!='') ? $dsc : '';
               $sumHrs[$empl->id] = $drct + $indrct + $lnhrs + $ot + $inOThrs;*/
            }

      
          
            //return $indirect;
                 //$staffs = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->get();
                    $confirm = Attendance_status::where([['date', '=', $date], ['shop_id', '=', $shopid]])->first();
                    $icon = $confirm ? 'check' : 'window-minimize';
                    $color = $confirm ? 'warning' : 'danger';
                    $disabled = $confirm ? 'disabled' : 'enabled';
                    $text = $confirm ? 'Attendance Confirmed' : 'Confirm Attendance';
                    $id = DefaultAttendanceHRS::orderBy('id', 'desc')->take(1)->value('id');
                    $check_deafult=DefaultAttendanceHRS::where('id','=',$id)->first();
                 //   $direct="";
                  //  $indirect="";
                    $hrslimit="";
                    $overtime="";
                    if($check_deafult){
                       // $indirect = $check_deafult->indirect;
                       // $direct = $check_deafult->direct;
                        $hrslimit = $check_deafult->hrslimit;
                        $overtime = $check_deafult->overtime;
                    }

                    
                    $data = array(
                        'attid'=>$attid,'loanhrs'=>$loanhrs, 'direct'=>$direct, 'indirect'=>$indirect, 'othrs'=>$othrs, 'authhours'=>$authhours, 'sumHrs'=>$sumHrs,
                        'desc'=>$desc, 'otshopln'=>$otshopln, 'otloanhrs'=>$otloanhrs, 'indirOThrs'=>$indirOThrs, 'shoploanto'=>$shoploanto,
                        'num' => 1, 'i'=>0, 'dayname'=>$dayname, 'attstatus'=>$attstatus,
                        'employees'=>$employees,'text'=>$text, 'prodday'=>$prodday,
                        'icon'=>$icon,'color'=>$color,'disabled'=>$disabled,
                        'shop' => $shopname,'conversation'=>$conversation,
                        'shopid' => $shopid,'loanee'=>$loanee,
                        'shops' => $allshops,'test'=>'testing',
                        'date' => $date, 'indirectshop'=>$indirectshop,
                        'btncolor' => 'warning', 'btntext' => 'Update',
                        'color1'=>($check) ? 'success' : 'danger',
                        'text1'=>($check) ? 'View Loaned' : 'Approve Loaned',
                        'icon1'=>($check) ? 'check' : 'window-minimize',
                        'hrslimit'=> $hrslimit,
                    );
                    return view('attendancepreview.index')->with($data);
        }else{
            Toastr::error('Sorry! Attendance Not Yet Marked','Not Marked');
            return back();
        }
    }
    public function checkattendance1(Request $request){
        if(isset($id)){
            $status = Attendance_status::where('id',$id)->first();
            $mdate =Carbon::createFromFormat('Y-m-d', $status->date)->format('m/d/Y');
            $shopid = $status->shop_id;
        }else{
            $mdate =$request->input('mdate');
            $shopid = $request->input('shop');
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
        //CHECK LOANEES
        $loanee = Attendance::where([['date', '=', $date], ['otshop_loaned_to', '=', $shopid]])->first();
        $check = Attendance::where([['loan_confirm', '=', 1],['date', '=', $date], ['otshop_loaned_to', '=', $shopid]])
                                ->first();
        //return $date;
       $marked = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->first();
        if($marked != null){
            //$shopname = Shop::where('id', $shopid)->value('shop_name');
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
            $indirectshop = Shop::where('id','=',$shopid)->value('check_shop');
            //SUBMISSION STATUS
            $attstatus = Attendance_status::where([['shop_id','=',$shopid],['date','=',$date]])->first();
                if($attstatus == "" || $attstatus->status_name == "saved"){
                    Toastr::error('Sorry! Attendance Not Yet Marked','Not Marked');
                    return back();
                }
            //CONVERSATION
            $statusid = Attendance_status::where([['shop_id','=',$shopid],['date','=',$date]])->value('id');
            if(!empty($statusid)){
                $conversation = Review_conversation::where('statusid','=',$statusid)
                                ->get(['user_id','statusid','sender','message','created_at']);
            }
            $date = Carbon::createFromFormat('m/d/Y', $mdate)->format('Y-m-d');
           // dd( $date);
            //$indrct = Attendance::where([['staff_id',296],['date','2022-02-15'], ['shop_id',2]])->value('indirect_hrs');
            //return $rr = ($indrct!="")? "ee": $indrct;
            //Loading all employees
            $employees = Employee::where([['status','Active']])->whereHas('empattendance', function ($query) use($date, $shopid) {
                $query->where([['date', '=', $date], ['shop_id', '=', $shopid]]);
            })->with(['empattendance' => function ($q) use($date, $shopid) {
                $q->where([['date', '=', $date], ['shop_id', '=', $shopid]]);
            }])->get();
           
            foreach($employees as $empl){
               

                foreach( $empl->empattendance as $row){
                    $attid[$empl->id] = $row->id;
                    $drct = $row->direct_hrs;
                    $direct[$empl->id] = ($drct!='') ? $drct : '';
                    $indrct =$row->indirect_hrs;
                    $indirect[$empl->id] = ($indrct!='') ? $indrct : '';
                    $lnhrs = $row->loaned_hrs;
                    $loanhrs[$empl->id] = ($lnhrs!='') ? $lnhrs : '';
                    $spLnto = $row->shop_loaned_to;
                    $shoploanto[$empl->id] = ($spLnto!='') ? $spLnto : '';
                    $authhrs = $row->auth_othrs;
                    $authhours[$empl->id] = ($authhrs!='') ? $authhrs : '';
                    $ot = $row->othours;
                    $othrs[$empl->id] = ($ot!='') ? $ot : '';
                    $inOThrs = $row->indirect_othours;
                    $indirOThrs[$empl->id] = ($inOThrs!='') ? $inOThrs : '';
                    $otlnhrs = $row->otloaned_hrs;
                    $otloanhrs[$empl->id] = ($otlnhrs!='') ? $otlnhrs : '';
                    $otlnshop = $row->otshop_loaned_to;
                    $otshopln[$empl->id] = ($otlnshop!='') ? $otlnshop : '';
                    $dsc = $row->workdescription;
                    $desc[$empl->id] = ($dsc!='') ? $dsc : '';
                    $sumHrs[$empl->id] = $drct + $indrct + $lnhrs + $ot + $inOThrs;
                }
               /* $drct = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('direct_hrs');
                $direct[$empl->id] = ($drct!='') ? $drct : '';
                $indrct = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('indirect_hrs');
                $indirect[$empl->id] = ($indrct!='') ? $indrct : '';
                $lnhrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('loaned_hrs');
                $loanhrs[$empl->id] = ($lnhrs!='') ? $lnhrs : '';
                $spLnto = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('shop_loaned_to');
                $shoploanto[$empl->id] = ($spLnto!='') ? $spLnto : '';
                $authhrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('auth_othrs');
                $authhours[$empl->id] = ($authhrs!='') ? $authhrs : '';
                $ot = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('othours');
                $othrs[$empl->id] = ($ot!='') ? $ot : '';
                $inOThrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('indirect_othours');
                $indirOThrs[$empl->id] = ($inOThrs!='') ? $inOThrs : '';
                $otlnhrs = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('otloaned_hrs');
                $otloanhrs[$empl->id] = ($otlnhrs!='') ? $otlnhrs : '';
                $otlnshop = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('otshop_loaned_to');
                $otshopln[$empl->id] = ($otlnshop!='') ? $otlnshop : '';
                $dsc = Attendance::where([['staff_id',$empl->id],['date', '=', $date], ['shop_id', '=', $shopid]])->value('workdescription');
                $desc[$empl->id] = ($dsc!='') ? $dsc : '';
               $sumHrs[$empl->id] = $drct + $indrct + $lnhrs + $ot + $inOThrs;*/
            }

      
          
            //return $indirect;
                 //$staffs = Attendance::where([['date', '=', $date], ['shop_id', '=', $shopid]])->get();
                    $confirm = Attendance_status::where([['date', '=', $date], ['shop_id', '=', $shopid]])->first();
                    $icon = $confirm ? 'check' : 'window-minimize';
                    $color = $confirm ? 'warning' : 'danger';
                    $disabled = $confirm ? 'disabled' : 'enabled';
                    $text = $confirm ? 'Attendance Confirmed' : 'Confirm Attendance';
                    $id = DefaultAttendanceHRS::orderBy('id', 'desc')->take(1)->value('id');
                    $check_deafult=DefaultAttendanceHRS::where('id','=',$id)->first();
                 //   $direct="";
                  //  $indirect="";
                    $hrslimit="";
                    $overtime="";
                    if($check_deafult){
                       // $indirect = $check_deafult->indirect;
                       // $direct = $check_deafult->direct;
                        $hrslimit = $check_deafult->hrslimit;
                        $overtime = $check_deafult->overtime;
                    }

                    
                    $data = array(
                        'attid'=>$attid,'loanhrs'=>$loanhrs, 'direct'=>$direct, 'indirect'=>$indirect, 'othrs'=>$othrs, 'authhours'=>$authhours, 'sumHrs'=>$sumHrs,
                        'desc'=>$desc, 'otshopln'=>$otshopln, 'otloanhrs'=>$otloanhrs, 'indirOThrs'=>$indirOThrs, 'shoploanto'=>$shoploanto,
                        'num' => 1, 'i'=>0, 'dayname'=>$dayname, 'attstatus'=>$attstatus,
                        'employees'=>$employees,'text'=>$text, 'prodday'=>$prodday,
                        'icon'=>$icon,'color'=>$color,'disabled'=>$disabled,
                        'shop' => $shopname,'conversation'=>$conversation,
                        'shopid' => $shopid,'loanee'=>$loanee,
                        'shops' => $allshops,'test'=>'testing',
                        'date' => $date, 'indirectshop'=>$indirectshop,
                        'btncolor' => 'warning', 'btntext' => 'Update',
                        'color1'=>($check) ? 'success' : 'danger',
                        'text1'=>($check) ? 'View Loaned' : 'Approve Loaned',
                        'icon1'=>($check) ? 'check' : 'window-minimize',
                        'hrslimit'=> $hrslimit,
                    );
                    return view('attendancepreview.index')->with($data);
        }else{
            Toastr::error('Sorry! Attendance Not Yet Marked','Not Marked');
            return back();
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function confirmattendance(Request $request)
    {
        $preview = new Attendance_status;
        $date =  $request->input('date');
        $shopid = $request->input('shopid');
        $confirmed = Attendance_status::where([['date', '=', $date], ['shop_id', '=', $shopid]])->first();
        if($confirmed == null){
            $preview->date = $date;
            $preview->shop_id = $shopid;
            $preview->user_id = auth()->user()->id;
            $preview->save();
        }
        Toastr::success('Attendance confirmed successfully','Confirmed');
        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AttendancePreview  $attendancePreview
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = $request->input('date');
        $shop_id = $request->shop_id;
    //ATTENDANCE STATUS
    if($request->input('button') == "approved"){
        try{
            DB::beginTransaction();
            $statusid = Attendance_status::where([['shop_id','=',$shop_id],['date','=',$date]])->value('id');
            $status = Attendance_status::find($statusid);
            $status->status_name = $request->input('button');
            $status->save();
        DB::commit();
            Toastr::success('Attendance Approved successfully','Approved');
            return back();
        }
        catch(\Exception $e){
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            Toastr::error('Error occured, approval failed!','Error');
            return  $e->getMessage();
        }
    }
    //update
    $date = $request->input('date');
    $shop_id = $request->shop_id;
    $data_items = $request->only([
        'marked_id', 'staff_id', 'direct_hrs', 'indirect_hrs', 'shop_loaned_to', 'loaned_hrs', 
        'othours','auth_othrs', 'otshop_loaned_to', 'otloaned_hrs', 'indirect_othours','workdescription'
    ]);
    $data_items = modify_array($data_items);

       /* $staffid = $request->staff_id;
        $direct = $request->direct;
        $indirect = $request->indirect;
        $overtime = $request->overtime;
        $indovertime = $request->indovertime;
        $authhrs = $request->auth_hrs;
        $workdescription = $request->workdescription;
        $overshoptoid = $request->overshoptoid;
        $loanov = $request->loanov;
        $shop_id = $request->shop_id;
        $dirshopto_id = $request->dirshopto;
        $loandir = $request->loandir;*/
   
            try{
            DB::beginTransaction();

           /* $data=[];
                for($i = 0; $i < count($staffid); $i++)
                {
                     $markedid = Attendance::where([['staff_id',$staffid[$i]],['date',$date], ['shop_id', '=', $shop_id]])->first();
                        if($markedid != ''){
                           $attend = Attendance::find($markedid->id);
                        }else{
                            $attend = new Attendance;
                            $attend->date = $date;
                            $attend->shop_id = $shop_id;
                            $attend->user_id = auth()->user()->id;
                        }
                     
                    
                       // $data[]=array('staff_id'=>$staffid[$i]);
                      $attend->staff_id = $staffid[$i];
                      $drct = ($direct[$i] != "")? $direct[$i] : 0;
                      $attend->direct_hrs = $drct ;
                      $indrct = ($indirect[$i] == "")? 0 : $indirect[$i];
                      $attend->indirect_hrs = $indrct;
                      $othours = ($overtime[$i] == "")? 0 : $overtime[$i];
                      $attend->othours = $othours;
                        $indirect_othours = ($indovertime[$i] == "")? 0 : $indovertime[$i];
                        $attend->indirect_othours = $indirect_othours;
                        $attend->auth_othrs = ($authhrs[$i] == "")? 0 : $authhrs[$i];
                        $attend->otshop_loaned_to = (@$overshoptoid[$i] == "")? 0 : @$overshoptoid[$i];
                        $attend->otloaned_hrs = (@$loanov[$i] == "")? 0 : @$loanov[$i];
                       $attend->shop_loaned_to = (@$dirshopto_id[$i] == "")? 0 : @$dirshopto_id[$i];
                        $attend->loaned_hrs = (@$loandir[$i] == "")? 0 : @$loandir[$i];
                       $attend->workdescription = $workdescription[$i];
                        $attend->efficiencyhrs = (($drct + $indrct) * 0.97875) + $othours + $indirect_othours;
                    $attend->save();
                    }*/

                        // remove omitted items
                 $item_ids = array_map(function ($v) { return $v['marked_id']; }, $data_items);
                 //delete attendance which are removed from the list
                  Attendance::where([['date', '=', $date], ['shop_id', '=', $shop_id]])->whereNotIn('id', $item_ids)->delete();


                    foreach($data_items as $item) {

                        foreach ($item as $key => $val) {
                            if (in_array($key, ['direct_hrs','indirect_hrs','otloaned_hrs','otshop_loaned_to','loandir']))
                            if($item[$key]==null){
                                $item[$key]=0;
    
                            }else{
                                $item[$key]= $val;
                            }
                               
                        }
                  $attendance_item = Attendance::firstOrNew(['id' => $item['marked_id']]);
                  $attendance_item->fill(array_replace($item, ['shop_id'=>$shop_id, 'date'=>$date, 'user_id' => auth()->user()->id, 'efficiencyhrs' => (($item['direct_hrs']) * 0.97875) + $item['auth_othrs']]));
                     if (!$attendance_item->id) unset($attendance_item->id);
                   $attendance_item->save();
                    }

             

            //ATTENDANCE STATUS
            $statusid = Attendance_status::where([['shop_id','=',$shop_id],['date','=',$date]])->value('id');
            $status = Attendance_status::find($statusid);
            $status->workdescription = $request->input('workdescriptionall');
            $status->save();
            DB::commit();
            Toastr::success('Attendance updated successfully','Updated');
            return back();
        }
        catch(\Exception $e){
            DB::rollBack();
            \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
            Toastr::error('Error occured, update failed!','Error');
            return  $e->getMessage();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AttendancePreview  $attendancePreview
     * @return \Illuminate\Http\Response
     */
    public function edit(AttendancePreview $attendancePreview)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AttendancePreview  $attendancePreview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AttendancePreview $attendancePreview)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AttendancePreview  $attendancePreview
     * @return \Illuminate\Http\Response
     */
    public function destroy(AttendancePreview $attendancePreview)
    {
        //
    }
}
