<?php

namespace App\Http\Controllers\productiontarget;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Validator;

use App\Models\unitroute\Unitroutes;
use App\Models\productiontarget\Production_target;
use App\Models\scheduleissue\Schedule_issue;
use App\Models\shop\Shop;
use App\Models\vehicle_units\vehicle_units;
use App\Models\unitmovement\Unitmovement;
use App\Models\unit_model\Unit_model;
use App\Models\attendance\Attendance;
use App\Models\bufferstatus\BufferStatus;
use App\Models\unitsbroughtforward\UnitsBroughtForward;

use App\Models\drr\Drr;
use App\Models\queryanswer\Queryanswer;
use App\Models\querydefect\Querydefect;

use App\Exports\ActualprodnView;
use App\Exports\ExportDelayedUnits;
use Excel;

class ProductiontargetController extends Controller
{
    public function productionschedule(Request $request){
        //return Production_target::groupby('date')->orderBy('date', 'ASC')->get(['date','route_id']);
        if($request->input()){
            $first = Carbon::createFromFormat('F Y', $request->input('mdate'))->startOfMonth()->format('Y-m-d');
            $last = Carbon::createFromFormat('F Y', $request->input('mdate'))->endOfMonth()->format('Y-m-d');
        }else{
            $first = Carbon::now()->startOfMonth()->format('Y-m-d');
            $last = Carbon::now()->endOfMonth()->format('Y-m-d');
        }

        $issueno = Schedule_issue::where([['level','=','offline'],['month','=',$first],['schedule_part','=','entire']])->max('issue_no');//->value('issue_no');
        $issueno = ($issueno == "") ? 1 : $issueno;
        $comment = Schedule_issue::where([['level','=','offline'],['month','=',$first],['issue_no','=',$issueno],['schedule_part','=','entire']])->value('comment');

        $upissueno = Schedule_issue::where([['level','=','offline'],['month','=',$first],['schedule_part','=','up']])->max('issue_no');//->value('issue_no');
        $upissueno = ($upissueno == "") ? 1 : $upissueno;
        $upcomment = Schedule_issue::where([['level','=','offline'],['month','=',$first],['issue_no','=',$upissueno],['schedule_part','=','up']])->value('comment');

        $downissueno = Schedule_issue::where([['level','=','offline'],['month','=',$first],['schedule_part','=','down']])->max('issue_no');//->value('issue_no');
        $downissueno = ($downissueno == "") ? 1 : $downissueno;
        $downcomment = Schedule_issue::where([['level','=','offline'],['month','=',$first],['issue_no','=',$downissueno],['schedule_part','=','down']])->value('comment');

        $today = Carbon::today()->format('Y-m-d');

       $routes = Unitroutes::where('id','=',1)->orWhere('id','=',3)->orWhere('id','=',5)->orWhere('id','=',7)->orWhere('id','=',9)
                            ->get(['id','name','route_number','description']);

        $weekMap = [0 => 'Sunday',1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday'];

        $first1 = $first; $cumm = 0; $upcumm = 0; $downcumm = 0;
        while ($first1 <= $last) {
            $dates[] = Carbon::createFromFormat('Y-m-d', $first1)->format('jS');
            $dateid[] = $first1;
            $dayOfTheWeek = Carbon::parse($first1)->dayOfWeek;
            $wkdys[] = $weekMap[$dayOfTheWeek];

            $totalunits = 0; $uptotalunits = 0; $downtotalunits = 0;
            foreach($routes as $route){
                //full
                $units = Production_target::where([['date','=',$first1],['route_id','=',$route->id],['level','=','offline'],['schedule_part','=','entire']])->value('noofunits');
                $noofunits[$first1][$route->id] = (empty($units)) ? '--' : $units;
                $totalunits += $units;
                //up
                $upunits = Production_target::where([['date','=',$first1],['route_id','=',$route->id],['level','=','offline'],['schedule_part','=','up']])->value('noofunits');
                $upnoofunits[$first1][$route->id] = (empty($upunits)) ? '--' : $upunits;
                $uptotalunits += $upunits;
                //down
                $downunits = Production_target::where([['date','=',$first1],['route_id','=',$route->id],['level','=','offline'],['schedule_part','=','down']])->value('noofunits');
                $downnoofunits[$first1][$route->id] = (empty($downunits)) ? '--' : $downunits;
                $downtotalunits += $downunits;
            }
            $sumunits[] = $totalunits;
            $cumm += $totalunits;
            $cumunits[] = $cumm;

            $upsumunits[] = $uptotalunits;
            $upcumm += $uptotalunits;
            $upcumunits[] = $upcumm;

            $downsumunits[] = $downtotalunits;
            $downcumm += $downtotalunits;
            $downcumunits[] = $downcumm;
            $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
        }

        $ttall = 0; $upttall = 0; $downttall = 0;
        foreach($routes as $route){
            $total = 0; $uptotal = 0; $downtotal = 0;
            $first1 = $first;
            while ($first1 <= $last) {
                //entire
                $units = Production_target::where([['date','=',$first1],['route_id','=',$route->id],['level','=','offline'],['schedule_part','=','entire']])->value('noofunits');
                $total += (empty($units)) ? 0 : $units;
                //up
                $upunits = Production_target::where([['date','=',$first1],['route_id','=',$route->id],['level','=','offline'],['schedule_part','=','up']])->value('noofunits');
                $uptotal += (empty($upunits)) ? 0 : $upunits;
                //down
                $downunits = Production_target::where([['date','=',$first1],['route_id','=',$route->id],['level','=','offline'],['schedule_part','=','down']])->value('noofunits');
                $downtotal += (empty($downunits)) ? 0 : $downunits;
                $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
            }
            $unitsperroute[$route->id] = $total;
            $ttall += $total;

            $upunitsperroute[$route->id] = $uptotal;
            $upttall += $uptotal;

            $downunitsperroute[$route->id] = $downtotal;
            $downttall += $downtotal;
        }

        //return $first;
        //return Production_target::where('schedule_part','entire')->groupby('date')->orderBy('date', 'ASC')->get(['date']);

        $data = array(
            'routes'=>$routes, 'dates'=>$dates, 'today'=>$today, 'wkdys'=>$wkdys, 'first'=>$first,
            'dateid'=>$dateid,

            'sumunits'=>$sumunits, 'cumunits'=>$cumunits, 'noofunits'=>$noofunits,
            'unitsperroute'=>$unitsperroute, 'ttall'=>$ttall,
            'comment'=>$comment, 'issueno'=>$issueno,

            'upsumunits'=>$upsumunits, 'upcumunits'=>$upcumunits, 'upnoofunits'=>$upnoofunits,
            'upunitsperroute'=>$upunitsperroute, 'upttall'=>$upttall,
            'upcomment'=>$upcomment,'upissueno'=>$upissueno,

            'downsumunits'=>$downsumunits, 'downcumunits'=>$downcumunits, 'downnoofunits'=>$downnoofunits,
            'downunitsperroute'=>$downunitsperroute, 'downttall'=>$downttall,
            'downcomment'=>$downcomment, 'downissueno'=>$downissueno,
        );
        return view('productionschedule.index')->with($data);
    }

    public function store(Request $request){
        $schlevel = $request->input('schedule');
        if($schlevel == 'entire'){
            $scheduledata = $request->unitdata;
            for($n = 0; $n <count($scheduledata); $n++){
                $dataarr = explode('_',$scheduledata[$n]);
                if($dataarr[2] != '--'){
                    $dates[] = $dataarr[0];
                    $routes[] = $dataarr[1];
                    $noofunits[] = $dataarr[2];
                }
            }
            $unitsedited = $noofunits;
            $dateid = $dates;
            $routeid = $routes;

        }else{
            $unitsedited = $request->unitsedited;
            $dateid = $request->dateid;
            $routeid = $request->routeid;
        }


        $issuearr = explode(' ',$request->issueinput);
        $issueno = $issuearr[1];
        $comment = $request->comment;
        $month = $request->month;


        function calc_inday($offdate,$shop,$schlevel){
            $allschdates = Production_target::where('schedule_part','entire')->groupby('date')->orderBy('date', 'ASC')->get(['date']);
            if($schlevel == "entire"){
                $shopoffdays = [1=>4,2=>3,3=>2,5=>1,6=>1,8=>0,10=>0,11=>0,12=>0,13=>0,16=>0];
            }elseif($schlevel == "up"){
                $shopoffdays = [1=>3,2=>2,3=>1,5=>0,6=>0,11=>0];
            }elseif($schlevel == "down"){
                $shopoffdays = [8=>0,10=>0,12=>0,13=>0,16=>0];
            }


            if(count($allschdates) != 0){
                foreach($allschdates as $schdt){  $prodndays[] = $schdt->date; }

            if(strtotime($offdate) > strtotime(end($prodndays))){
                if(count($prodndays) > $shopoffdays[$shop]){
                    $pos = array_search(end($prodndays), $prodndays);
                    if($pos < 4){ $startpos = 0;}else{ $startpos = $pos - $shopoffdays[$shop];}
                }else{
                    $startpos = 0;
                }
                $inshopdate = $prodndays[$startpos];

            }elseif(strtotime($offdate) < strtotime($prodndays[0])){
                $inshopdate = $offdate;
            }else{
                $pos = array_search($offdate, $prodndays);

                if(empty($pos)){
                    for($n=0; $n<count($prodndays); $n++){
                        if(strtotime($prodndays[$n]) < strtotime($offdate)){
                            $pos = array_search($prodndays[$n],$prodndays);
                            break;
                        }
                    }
                    if($pos < 4){ $startpos = 0;}else{ $startpos = $pos - $shopoffdays[$shop];}
                    $inshopdate = $prodndays[$startpos];
                }else{
                    if($pos < 4){ $startpos = 0;}else{ $startpos = $pos - $shopoffdays[$shop];}
                    $inshopdate = $prodndays[$startpos];
                }
            }
        }else{
            $inshopdate = $offdate;
        }
            return $inshopdate;
    }

        //return Production_target::groupby('date')->get(['date','route_id'])->sortDesc();
    try{
        DB::beginTransaction();
        for($n = 0; $n < count($routeid); $n++){
            $existid = Production_target::where([['level','=','offline'],['schedule_part','=',$schlevel], ['date', '=', $dateid[$n]], ['route_id', '=', $routeid[$n]]])->value('id');
            $newunits = (!empty($unitsedited[$n])) ? $unitsedited[$n] : 0;
            //return $existid;
            if($existid == ''){
                if($newunits > 0){
                    $insert = new Production_target;
                    $insert->level = "offline";
                    $insert->schedule_part = $schlevel;
                    $insert->date = $dateid[$n];
                    $insert->route_id = $routeid[$n];
                    $insert->noofunits = $newunits;
                    $insert->user_id = auth()->user()->id;
                    $insert->save();
                }
            }elseif($existid != ''){
                if($newunits > 0){
                    $update = Production_target::find($existid);
                    $update->noofunits = $newunits;
                    $update->save();
                }else{
                    $del = Production_target::find($existid);
                    $del->delete();
                }

            }
         }
         DB::commit();

    }catch(\Exception $e){
        DB::rollBack();
    }

    try{
        DB::beginTransaction();
        for($n = 0; $n < count($routeid); $n++){
            $newunits = (!empty($unitsedited[$n])) ? $unitsedited[$n] : 0;

            if($newunits > 0){
                $existid = Production_target::where([['level','=','offline'],['schedule_part','=',$schlevel],['date', '=', $dateid[$n]], ['route_id', '=', $routeid[$n]]])->value('id');

             $update1 = Production_target::find($existid);
             $update1->noofunits = $newunits;

                if($routeid[$n] == '1'){
                    if($schlevel == "entire"){
                        $update1->shop1 = calc_inday($dateid[$n],1,$schlevel);
                        $update1->shop2 = calc_inday($dateid[$n],2,$schlevel); $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop5 = calc_inday($dateid[$n],5,$schlevel); $update1->shop6 = calc_inday($dateid[$n],6,$schlevel);
                        $update1->shop8 = calc_inday($dateid[$n],8,$schlevel);  $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }elseif($schlevel == "up"){
                        $update1->shop1 = calc_inday($dateid[$n],1,$schlevel);
                        $update1->shop2 = calc_inday($dateid[$n],2,$schlevel); $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop5 = calc_inday($dateid[$n],5,$schlevel); $update1->shop6 = calc_inday($dateid[$n],6,$schlevel);
                    }elseif($schlevel == "down"){
                        $update1->shop8 = calc_inday($dateid[$n],8,$schlevel);  $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }

                }elseif($routeid[$n] == '3'){
                    if($schlevel == "entire"){
                        $update1->shop1 = calc_inday($dateid[$n],1,$schlevel);
                        $update1->shop2 = calc_inday($dateid[$n],2,$schlevel); $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop5 = calc_inday($dateid[$n],5,$schlevel); $update1->shop6 = calc_inday($dateid[$n],6,$schlevel);
                        $update1->shop10 = calc_inday($dateid[$n],10,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }elseif($schlevel == "up"){
                        $update1->shop1 = calc_inday($dateid[$n],1,$schlevel);
                        $update1->shop2 = calc_inday($dateid[$n],2,$schlevel); $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop5 = calc_inday($dateid[$n],5,$schlevel); $update1->shop6 = calc_inday($dateid[$n],6,$schlevel);
                    }elseif($schlevel == "down"){
                        $update1->shop10 = calc_inday($dateid[$n],10,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }

                }elseif($routeid[$n] == '5'){
                    if($schlevel == "entire"){
                        $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop5 = calc_inday($dateid[$n],5,$schlevel); $update1->shop6 = calc_inday($dateid[$n],6,$schlevel);
                        $update1->shop10 = calc_inday($dateid[$n],10,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }elseif($schlevel == "up"){
                        $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop5 = calc_inday($dateid[$n],5,$schlevel); $update1->shop6 = calc_inday($dateid[$n],6,$schlevel);
                    }elseif($schlevel == "down"){
                        $update1->shop10 = calc_inday($dateid[$n],10,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }


                }elseif($routeid[$n] == '7'){
                    if($schlevel == "entire"){
                        $update1->shop11 = calc_inday($dateid[$n],11,$schlevel); $update1->shop12 = calc_inday($dateid[$n],12,$schlevel);
                        $update1->shop13 = calc_inday($dateid[$n],13,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }elseif($schlevel == "up"){
                        $update1->shop11 = calc_inday($dateid[$n],11,$schlevel);
                    }elseif($schlevel == "down"){
                        $update1->shop12 = calc_inday($dateid[$n],12,$schlevel);
                        $update1->shop13 = calc_inday($dateid[$n],13,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }


                }elseif($routeid[$n] == '9'){
                    if($schlevel == "entire"){
                        $update1->shop1 = calc_inday($dateid[$n],1,$schlevel); $update1->shop2 = calc_inday($dateid[$n],2,$schlevel); $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop6 = calc_inday($dateid[$n],6,$schlevel); $update1->shop11 = calc_inday($dateid[$n],11,$schlevel); $update1->shop12 = calc_inday($dateid[$n],12,$schlevel);
                        $update1->shop13 = calc_inday($dateid[$n],13,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }elseif($schlevel == "up"){
                        $update1->shop1 = calc_inday($dateid[$n],1,$schlevel); $update1->shop2 = calc_inday($dateid[$n],2,$schlevel); $update1->shop3 = calc_inday($dateid[$n],3,$schlevel);
                        $update1->shop6 = calc_inday($dateid[$n],6,$schlevel); $update1->shop11 = calc_inday($dateid[$n],11,$schlevel);
                    }elseif($schlevel == "down"){
                        $update1->shop12 = calc_inday($dateid[$n],12,$schlevel);
                        $update1->shop13 = calc_inday($dateid[$n],13,$schlevel); $update1->shop16 = calc_inday($dateid[$n],16,$schlevel);
                    }

                }
                $update1->save();
            }

         }

         $issueid = Schedule_issue::where([['level','=','offline'],['schedule_part','=',$schlevel],['month','=',$month],['issue_no','=',$issueno]])->value('id');
         if(empty($issueid)){
            $iss = new Schedule_issue;
            $iss->level = "offline";
            $iss->schedule_part = $schlevel;
            $iss->month = $month;
            $iss->issue_no = $issueno;
            $iss->comment = $comment;
            $iss->user_id = auth()->user()->id;
            $iss->save();
         }else{
            $iss = Schedule_issue::find($issueid);
            $iss->comment = $comment;
            $iss->save();
         }

         DB::commit();
         Toastr::success('Production schedule saved successfully','Saved');
         return back();

    } catch(\Exception $e){
        DB::rollBack();
        \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        Toastr::error($e->getMessage());
        return back();
    }


}

//PLANT PERFORMANCE TRACKING

    public function trackperformance(Request $request){
        //return broughtfoward(1,"2021-12-29");
        if($request->input()){
            $mdate = $request->input('mdate');
            $today = Carbon::createFromFormat('F Y', $mdate)->format('Y-m-d');
        }else{
            $today = Carbon::today()->format('Y-m-d');
        }

             $shops = Shop::where('check_shop','=',1)->get(['id','report_name','off_days']);
              unset($shops[8]); unset($shops[10]);
             $first = Carbon::parse($today)->startOfMonth()->format('Y-m-d');
            $endmonth = Carbon::parse($today)->endOfMonth()->format('Y-m-d');

            $weekMap = [0 => 'S',1 => 'M',2 => 'T',3 => 'W',4 => 'T',5 => 'F',6 => 'S'];

            $allschdates = Production_target::where('schedule_part','entire')->groupby('date')->orderBy('date', 'asc')->get(['date']);
            foreach($allschdates as $schdt){ $allprodndays[] = $schdt->date; }

			$first1 = $first;
            $start = 0;
            while($first1 <= $endmonth){
                if(in_array($first1, $allprodndays)){
                    $start = $first1;
                    break;
                }
                $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
            }

             $pos = array_search($start, $allprodndays);

            if($pos < 4){
                $startpos = 0;
            }else{
                $startpos = $pos - 4;
            }

            $mtdschdates = Production_target::whereBetween('date', [$first, $endmonth])
                        ->where('schedule_part','entire')->groupby('date')->orderBy('date', 'asc')->get(['date']);

            if(count($mtdschdates) == 0){
                Toastr::error('Sorry! No schedule set for the current month.');
                return back();
            }

            foreach($mtdschdates as $schdt){  $mtprodndays[] = $schdt->date; }
            if(count($allprodndays) - count($mtprodndays) <= 4){
                $maks = count($allprodndays) - count($mtprodndays);
            }else{
                $maks = 4;
            }
			//return $mtprodndays;

             $size = $startpos + count($mtprodndays) + $maks;
            for($startpos; $startpos < $size; $startpos++){
                $showprodndays[] = $allprodndays[$startpos];
            }
			//return $showprodndays;

            for($i = 0; $i < count($showprodndays); $i++){
                $dates[] = Carbon::parse($showprodndays[$i])->format('j-M');
                $dayname[] = $weekMap[Carbon::parse($showprodndays[$i])->dayOfWeek];
            }

//return $fcst = Production_target::where('shop1','=','2022-07-28')->sum('noofunits');
            //FORECAST
            $numdays = count($mtprodndays);
            $inshopname = [1=>'shop1',2=>'shop2',3=>'shop3',5=>'shop5',6=>'shop6',8=>'shop8',10=>'shop10',11=>'shop11',12=>'shop12',13=>'shop13',16=>'shop16'];

            foreach($shops as $sp){
                $xx = 0; $days = $numdays;
                //$first1 = Carbon::parse($today)->startOfMonth()->format('Y-m-d');
                $MTDfcst = 0; $MTDactual = 0;  $MTDvarience = 0;
                for($n = 0; $n < count($showprodndays); $n++){

                        if($n >= abs(4 - $sp->off_days)){
                            if($xx < $days){

                                $fcst = Production_target::where(''.$inshopname[$sp->id].'','=',$showprodndays[$n])
                                                ->sum('noofunits');

                                $countsched[$sp->id][] = $fcst; $MTDfcst += $fcst;
                                $allMTDfcst[$sp->id][] = $MTDfcst;
                                $act = UnitMovement::where([['datetime_out','=',$showprodndays[$n]],['shop_id','=',$sp->id]])->count();
                                $actual[$sp->id][] = $act; $MTDactual += $act;
                                $allMTDactual[$sp->id][] = $MTDactual;// + broughtfoward($sp->id,$showprodndays[$xx]);

                                $varience[$sp->id][] = $fcst - $act;
                                $allVarie[$sp->id][] = $MTDactual - $MTDfcst;//broughtfoward($sp->id,$showprodndays[$xx]);//;// -
                                $balance[$sp->id][] = broughtfoward($sp->id,$showprodndays[$n]);


                                $xx++;
                            }else{
                                $countsched[$sp->id][] = '';    $allMTDfcst[$sp->id][] = '';
                                $actual[$sp->id][] = '';        $allMTDactual[$sp->id][] = '';
                                $varience[$sp->id][] = '';      $allVarie[$sp->id][] = '';
                                $balance[$sp->id][] = broughtfoward($sp->id,$showprodndays[$n]);

                            }

                        }else{
                            $countsched[$sp->id][] = '';    $allMTDfcst[$sp->id][] = '';
                            $actual[$sp->id][] = '';        $allMTDactual[$sp->id][] = '';
                            $varience[$sp->id][] = '';      $allVarie[$sp->id][] = '';
                            $balance[$sp->id][] = broughtfoward($sp->id,$showprodndays[$n]);
                        }

                        //$first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
                }

            }


            //FCW SECTION
                $xx = 0; $days = $numdays;
                //$first1 = Carbon::parse($today)->startOfMonth()->format('Y-m-d');
                $MTDmpafcst = 0; $MTDmpaactual = 0;  $MTDmpavarience = 0; $MTDcvfcst = 0;
                $MTDcvactual = 0; $MTDlcvfcst = 0; $MTDlcvactual = 0; $MTDmpcfcst = 0; $MTDmpcfcst = 0; $MTDmpcactual = 0;
                for($n = 0; $n < count($showprodndays); $n++){

                        if($n >= abs(4 - 0)){
                            if($xx < $days){
                                //MPA - PLANT OFFLINE
                                $mpafcst = Production_target::where('shop16','=',$showprodndays[$n])
                                                ->sum('noofunits'); //MPA -same with shop16 according to schedule
                                $countmpasched[] = $mpafcst; $MTDmpafcst += $mpafcst;
                                $shMTDmpafcst[] = $MTDmpafcst;

                                $mpaact = UnitMovement::where([['datetime_out','=',$showprodndays[$n]],['shop_id','=',8]])->count() + UnitMovement::where([['datetime_out','=',$showprodndays[$n]],['shop_id','=',10]])->count() + UnitMovement::where([['datetime_out','=',$showprodndays[$n]],['shop_id','=',13]])->count();
                                $mpaactual[] = $mpaact; $MTDmpaactual += $mpaact;
                                $shMTDmpaactual[] = $MTDmpaactual;

                                $mpavarience[] = $mpafcst - $mpaact;
                                $MTDmpaVarie[] = $MTDmpafcst - $MTDmpaactual;

                                //FCW DELIVERY CV MPC
                                $cvfcst = Production_target::where('cv','=',$showprodndays[$n])
                                                ->sum('noofunits'); //MPC -same with shop16 according to schedule
                                $countcvsched[] = $cvfcst; $MTDcvfcst += $cvfcst;
                                $shMTDcvfcst[] = $MTDcvfcst;

                                $cvact1 = UnitMovement::where('datetime_out','=',$showprodndays[$n])
									->where([['route_id',2],['shop_id','=',16]])->count();
                                $cvact2 = UnitMovement::where('datetime_out','=',$showprodndays[$n])
									->where([['route_id',4],['shop_id','=',16]])->count();
                                $cvact3 = UnitMovement::where('datetime_out','=',$showprodndays[$n])
									->where([['route_id',6],['shop_id','=',16]])->count();

                                $cvact = $cvact1 + $cvact2 + $cvact3;
                                $cvactual[] = $cvact; $MTDcvactual += $cvact;
                                $shMTDcvactual[] = $MTDcvactual;

                                $cvvarience[] = $cvfcst - $cvact;
                                $MTDcvVarie[] = $MTDcvfcst - $MTDcvactual;

                                //FCW DELIVERY LCV MPC
                                $lcvfcst = Production_target::where('lcv','=',$showprodndays[$n])
                                        ->sum('noofunits'); //MPC -same with shop16 according to schedule
                                $countlcvsched[] = $lcvfcst; $MTDlcvfcst += $lcvfcst;
                                $shMTDlcvfcst[] = $MTDlcvfcst;

                                $lcvact1 = UnitMovement::where('datetime_out','=',$showprodndays[$n])
									->where([['route_id','=',8] ,['shop_id','=',16]])->count();
                                $lcvact2 = UnitMovement::where('datetime_out','=',$showprodndays[$n])
									->where([['route_id','=',10] ,['shop_id','=',16]])->count();
                                $lcvact = $lcvact1 + $lcvact2;
                                $lcvactual[] = $lcvact; $MTDlcvactual += $lcvact;
                                $shMTDlcvactual[] = $MTDlcvactual;

                                $lcvvarience[] = $lcvfcst - $lcvact;
                                $MTDlcvVarie[] = $MTDlcvfcst - $MTDlcvactual;

                                //MPC - PLANT FCW DELIVERY
                                $mpcfcst = $cvfcst + $lcvfcst;  //MPC -same with shop16 according to schedule
                                $countmpcsched[] = $mpcfcst; $MTDmpcfcst += $mpcfcst;
                                $shMTDmpcfcst[] = $MTDmpcfcst;

                                $mpcact = UnitMovement::where('datetime_out','=',$showprodndays[$n])
									->where('shop_id','=',16)->count();
									//$cvact + $lcvact;
                                $mpcactual[] = $mpcact;
                                $MTDmpcactual += $mpcact;
                                $shMTDmpcactual[] = $MTDmpcactual;

                                $mpcvarience[] = $mpcfcst - $mpcact;
                                $MTDmpcVarie[] = $MTDmpcfcst - $MTDmpcactual;

                                $xx++;
                            }else{
                                //MPA
                                $countmpasched[] = '';  $shMTDmpafcst[] = "";
                                $mpaactual[] = '';     $shMTDmpaactual[] = '';
                                $mpavarience[] = '';  $MTDmpaVarie[] = "";

                                //MPC CV
                                $countcvsched[] = '';  $shMTDcvfcst[] = "";
                                $cvactual[] = '';     $shMTDcvactual[] = '';
                                $cvvarience[] = '';  $MTDcvVarie[] = "";

                                //MPC LCV
                                $countlcvsched[] = '';  $shMTDlcvfcst[] = "";
                                $lcvactual[] = '';     $shMTDlcvactual[] = '';
                                $lcvvarience[] = '';  $MTDlcvVarie[] = "";

                                //MPC FCW
                                $countmpcsched[] = '';  $shMTDmpcfcst[] = "";
                                $mpcactual[] = '';     $shMTDmpcactual[] = '';
                                $mpcvarience[] = '';  $MTDmpcVarie[] = "";
                            }

                        }else{
                            //MPA
                            $countmpasched[] = '';  $shMTDmpafcst[] = "";
                            $mpaactual[] = '';     $shMTDmpaactual[] = '';
                            $mpavarience[] = '';  $MTDmpaVarie[] = "";

                            //MPC CV
                            $countcvsched[] = '';  $shMTDcvfcst[] = "";
                            $cvactual[] = '';     $shMTDcvactual[] = '';
                            $cvvarience[] = '';  $MTDcvVarie[] = "";

                            //MPC LCV
                            $countlcvsched[] = '';  $shMTDlcvfcst[] = "";
                            $lcvactual[] = '';     $shMTDlcvactual[] = '';
                            $lcvvarience[] = '';  $MTDlcvVarie[] = "";

                            //MPC FCW
                            $countmpcsched[] = '';  $shMTDmpcfcst[] = "";
                            $mpcactual[] = '';     $shMTDmpcactual[] = '';
                            $mpcvarience[] = '';  $MTDmpcVarie[] = "";
                        }

                        //$first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
                }



            //return $countsched;
            $data = array(
                'balance'=>$balance,
                'dates'=>$dates, 'dayname'=>$dayname, 'shopnames'=>$shops, 'today'=>$today,
                'countsched'=>$countsched, 'actual'=>$actual, 'varience'=>$varience,
                'allMTDfcst'=>$allMTDfcst, 'allMTDactual'=>$allMTDactual, 'allVarie'=>$allVarie,
                //MPA OFFLINE
                'countmpasched'=>$countmpasched,  'shMTDmpafcst'=>$shMTDmpafcst,
                'mpaactual'=>$mpaactual,     'shMTDmpaactual'=>$shMTDmpaactual,
                'mpavarience'=>$mpavarience,  'MTDmpaVarie'=>$MTDmpaVarie,

                //MPC CV
                'countcvsched'=>$countcvsched,  'shMTDcvfcst'=>$shMTDcvfcst,
                'cvactual'=>$cvactual,     'shMTDcvactual'=>$shMTDcvactual,
                'cvvarience'=>$cvvarience,  'MTDcvVarie'=>$MTDcvVarie,

                //MPC LCV
                'countlcvsched'=>$countlcvsched,  'shMTDlcvfcst'=>$shMTDlcvfcst,
                'lcvactual'=>$lcvactual,     'shMTDlcvactual'=>$shMTDlcvactual,
                'lcvvarience'=>$lcvvarience,  'MTDlcvVarie'=>$MTDlcvVarie,

                //MPC FCW
                'countmpcsched'=>$countmpcsched,  'shMTDmpcfcst'=>$shMTDmpcfcst,
                'mpcactual'=>$mpcactual,     'shMTDmpcactual'=>$shMTDmpcactual,
                'mpcvarience'=>$mpcvarience,  'MTDmpcVarie'=>$MTDmpcVarie,
            );


        return view('productionschedule.trackperformance')->with($data);
    }

    public function comments(){
        $issues = Schedule_issue::all()->sortDesc();
        $offmaxissue = Schedule_issue::where('level','=','offline')->max('issue_no');
        $fcwmaxissue = Schedule_issue::where('level','=','fcw')->max('issue_no');
        $data = array(
            'issues'=>$issues, 'offmaxissue'=>$offmaxissue, 'fcwmaxissue'=>$fcwmaxissue,
        );
        return view('productionschedule.comment')->with($data);
    }

    public function editchedule($id)
    {
        $issue = Schedule_issue::find($id);
        $issueno = 'Issue '.$issue->issue_no;
        $month = Carbon::createFromFormat('Y-m-d', $issue->month)->format('F');
        $data = array(
            'issue'=>$issue, 'issueno'=>$issueno, 'month'=>$month,
        );
        return view('productionschedule.edit')->with($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GcaScore  $gcaScore
     * @return \Illuminate\Http\Response
     */
    public function updateschedule(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment' => 'required',
        ]);

        if ($validator->fails()) {
            Toastr::error('Sorry! The comments field is empty. Fill all fields');
            return back();
        }
        $date = Carbon::createFromFormat('F', $request->input('month'))->format('Y-m-d');
        $id = $request->input('issueid');

        try{
            DB::beginTransaction();

            $issue = Schedule_issue::find($id);
            $issue->comment = $request->input('comment');

            $issue->save();
            DB::commit();

            Toastr::success('Schedule Comments updated successfully!','Saved');
            return back();

        }
        catch(\Exception $e){
            DB::Rollback();

            Toastr::error('Oops! An error occured, Schedule comments not updated.');
            return back();
        }

    }


    public function destroyschedule($id)
    {

    }

    public function actualproduction(Request $request){
        if($request->input('daterange')){
            $daterange = $request->input('daterange');
            $datearr = explode('-',$daterange);
            $first = Carbon::parse($datearr[0])->format('Y-m-d');
            $end = Carbon::parse($datearr[1])->format('Y-m-d');
        }else{

            // $today = Carbon::today()->format('Y-m-d');

            // $first = Carbon::create($today)->startOfMonth()->format('Y-m-d');
            // $end = Carbon::create($today)->endOfMonth()->format('Y-m-d');

            $currentDate = Carbon::now();
            $first = $currentDate->subMonth()->startOfMonth()->format('Y-m-d');
            $end = $currentDate->endOfMonth()->format('Y-m-d');
           



        }

        $range = Carbon::createFromFormat('Y-m-d', $first)->format('d M Y').' - '.Carbon::createFromFormat('Y-m-d', $end)->format('d M Y');


        $vehicles  = Unitmovement::whereBetween('datetime_out',[$first,$end])->where('current_shop',0)->where('shop_id', 8)
        ->orWhere(function ($query) use ($first,$end) {
            $query->where('shop_id', 10)
                ->whereBetween('datetime_out',[$first,$end])
            ->where('current_shop',0);
            })->orWhere(function ($query) use ($first,$end) {
            $query->where('shop_id', 13)
                ->whereBetween('datetime_out',[$first,$end]);
            })->get(['datetime_in','vehicle_id','shop_id','datetime_out','current_shop']);

        //$vehicles = Unitmovement::whereBetween('datetime_in',[$first,$end])->where('shop_id','=',27)
                                //->get(['datetime_in','vehicle_id','shop_id']);



        if(count($vehicles) == 0){
            Toastr::error('Sorry! No vehicle produced this month.');
            return back();
        }
        foreach($vehicles as $veh){

            $offd = Unitmovement::where([['vehicle_id','=',$veh->vehicle_id],['shop_id','=',16]])->value('datetime_out');
            if($offd != ""){
                $offdate[$veh->vehicle_id] = $offd;
            }else{
                $offdate[$veh->vehicle_id] = "--";
            }


            $currshop = Unitmovement::where([['current_shop','>',0],['vehicle_id',$veh->vehicle_id]])->value('current_shop');
			if($currshop == ''){
				$position[$veh->vehicle_id] = 'FCW';
			}else{
				$position[$veh->vehicle_id] = Shop::where('id',$currshop)->value('shop_name');
			}


        }
        //return $offdate;

        $data = array(
            'vehicles'=>$vehicles,
            'offdate'=>$offdate,
            'range'=>$range,
			'position'=>$position,
        );
        return view('productionschedule.actualproduction')->with($data);
    }

    public function exportActualprodn(Request $request){
            $daterange = $request->input('range');
            $datearr = explode('-',$daterange);
            $first = Carbon::parse($datearr[0])->format('Y-m-d');
            $end = Carbon::parse($datearr[1])->format('Y-m-d');


        $range = Carbon::createFromFormat('Y-m-d', $first)->format('d M Y').' - '.Carbon::createFromFormat('Y-m-d', $end)->format('d M Y');


        $vehicles  = Unitmovement::whereBetween('datetime_out',[$first,$end])->where('current_shop',0)->where('shop_id', 8)
        ->orWhere(function ($query) use ($first,$end) {
            $query->where('shop_id', 10)
                ->whereBetween('datetime_out',[$first,$end])
            ->where('current_shop',0);
            })->orWhere(function ($query) use ($first,$end) {
            $query->where('shop_id', 13)
                ->whereBetween('datetime_out',[$first,$end]);
            })->get(['datetime_in','vehicle_id','shop_id','datetime_out']);

        //$vehicles = Unitmovement::whereBetween('datetime_in',[$first,$end])->where('shop_id','=',27)
                                //->get(['datetime_in','vehicle_id','shop_id']);

        if(count($vehicles) == 0){
            Toastr::error('Sorry! No vehicle produced this month.');
            return back();
        }
        foreach($vehicles as $veh){

            $offd = Unitmovement::where([['vehicle_id','=',$veh->vehicle_id],['shop_id','=',16]])->value('datetime_out');
            if($offd != ""){
                $offdate[$veh->vehicle_id] = $offd;
            }else{
                $offdate[$veh->vehicle_id] = "--";
            }

			$currshop = Unitmovement::where([['current_shop','>',0],['vehicle_id',$veh->vehicle_id]])->value('current_shop');
			if($currshop == ''){
				$position[$veh->vehicle_id] = 'FCW';
			}else{
				$position[$veh->vehicle_id] = Shop::where('id',$currshop)->value('shop_name');
			}

        }
        //return $offdate;

        $data = array(
            'vehicles'=>$vehicles,
            'offdate'=>$offdate,
            'range'=>$range,
			'position'=>$position,
        );        return Excel::download(new ActualprodnView($data), 'actual.xlsx');
    }



public function fcwschedule(Request $request){
    if($request->input()){
        $first = Carbon::createFromFormat('F Y', $request->input('mdate'))->startOfMonth()->format('Y-m-d');
        $last = Carbon::createFromFormat('F Y', $request->input('mdate'))->endOfMonth()->format('Y-m-d');
    }else{
        $first = Carbon::now()->startOfMonth()->format('Y-m-d');
        $last = Carbon::now()->endOfMonth()->format('Y-m-d');
    }

    $issueno = Schedule_issue::where([['level','=','fcw'],['month','=',$first]])->max('issue_no');//->value('issue_no');
    $issueno = ($issueno == "") ? 1 : $issueno;
    $comment = Schedule_issue::where([['level','=','fcw'],['month','=',$first],['issue_no','=',$issueno]])->value('comment');

    $today = Carbon::today()->format('Y-m-d');

    $routes = ['LCV Line','CV Line'];//Unitroutes::groupby('route_number')->get(['id','name','description']);

    $weekMap = [0 => 'Sunday',1 => 'Monday',2 => 'Tuesday',3 => 'Wednesday',4 => 'Thursday',5 => 'Friday',6 => 'Saturday'];

    $first1 = $first; $cumm = 0;
    while ($first1 <= $last) {
        $dates[] = Carbon::createFromFormat('Y-m-d', $first1)->format('jS');
        $dateid[] = $first1;
        $dayOfTheWeek = Carbon::parse($first1)->dayOfWeek;
        $wkdys[] = $weekMap[$dayOfTheWeek];

        $totalunits = 0;
        for($n = 0; $n < count($routes); $n++){
            $units = Production_target::where([['date','=',$first1],['route_id','=',$n],['level','=','fcw']])->value('noofunits');
            $noofunits[$first1][$n] = (empty($units)) ? '--' : $units;
            $totalunits += $units;
        }
        $sumunits[] = $totalunits;
        $cumm += $totalunits;
        $cumunits[] = $cumm;
        $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
    }
    //return $first;

        $ttall = 0;
        for($n = 0; $n < count($routes); $n++){
            $total = 0;
            $first1 = $first;
            while ($first1 <= $last) {
                $units = Production_target::where([['date','=',$first1],['route_id','=',$n],['level','=','fcw']])->value('noofunits');
                $total += (empty($units)) ? 0 : $units;
                $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
            }
            $unitsperroute[$n] = $total;
            $ttall += $total;
        }

    $data = array(
        'routes'=>$routes, 'dates'=>$dates, 'today'=>$today, 'wkdys'=>$wkdys, 'first'=>$first,
        'dateid'=>$dateid, 'noofunits'=>$noofunits, 'issueno'=>$issueno, 'x'=>1,
        'first'=>$first, 'sumunits'=>$sumunits, 'cumunits'=>$cumunits,'comment'=>$comment,
        'unitsperroute'=>$unitsperroute, 'ttall'=>$ttall,
    );
    return view('productionschedule.fcwschedule')->with($data);
}


public function storefcwschedule(Request $request){
    $unitsedited = $request->unitsedited;
    $dateid = $request->dateid;
    $routeid = $request->routeid;
    $issuearr = explode(' ',$request->issueinput);
    $issueno = $issuearr[1];
    $comment = $request->comment;
    $month = $request->month;

    try{
        DB::beginTransaction();
        for($n = 0; $n < count($routeid); $n++){
            $existid = Production_target::where([['level','=','fcw'],['date', '=', $dateid[$n]], ['route_id', '=', $routeid[$n]]])->value('id');
            $newunits = (!empty($unitsedited[$n])) ? $unitsedited[$n] : 0;

            if($existid == ''){
                if($newunits > 0){
                    $insert = new Production_target;
                    $insert->level = "fcw";
                    $insert->date = $dateid[$n];
                    $insert->route_id = $routeid[$n];
                    $insert->noofunits = $newunits;
                    $insert->user_id = auth()->user()->id;
                    $insert->save();
                }
            }elseif($existid != ''){
                if($newunits > 0){
                    $update = Production_target::find($existid);
                    $update->noofunits = $newunits;
                    $update->save();
                }else{
                    $del = Production_target::find($existid);
                    $del->delete();
                }

            }
         }
         DB::commit();

    }catch(\Exception $e){
        DB::rollBack();
    }

    try{
        DB::beginTransaction();
        for($n = 0; $n < count($routeid); $n++){
            $newunits = (!empty($unitsedited[$n])) ? $unitsedited[$n] : 0;

            if($newunits > 0){
                $existid = Production_target::where([['level','=','fcw'],['date', '=', $dateid[$n]],['route_id', '=', $routeid[$n]]])->value('id');

             $update1 = Production_target::find($existid);
             if($routeid[$n] == 0){
                $update1->lcv = $dateid[$n];
             }else{
                $update1->cv = $dateid[$n];
             }
             $update1->noofunits = $newunits;

             $update1->save();
            }

         }

         $issueid = Schedule_issue::where([['level','=','fcw'],['month','=',$month],['issue_no','=',$issueno]])->value('id');
         if(empty($issueid)){
            $iss = new Schedule_issue;
            $iss->level = "fcw";
            $iss->month = $month;
            $iss->issue_no = $issueno;
            $iss->comment = $comment;
            $iss->user_id = auth()->user()->id;
            $iss->save();
         }else{
            $iss = Schedule_issue::find($issueid);
            $iss->comment = $comment;
            $iss->save();
         }

         DB::commit();
         Toastr::success('Production schedule saved successfully','Saved');
         return back();

    } catch(\Exception $e){
        DB::rollBack();
        \Log::emergency("File:" . $e->getFile(). "Line:" . $e->getLine(). "Message:" . $e->getMessage());
        Toastr::error($e->getMessage());
        return back();
    }
}


public function bufferstatus(Request $request){
    if($request->input()){
        $first = Carbon::createFromFormat('F Y', $request->input('mdate'))->startOfMonth()->format('Y-m-d');
        $last = Carbon::createFromFormat('F Y', $request->input('mdate'))->endOfMonth()->format('Y-m-d');
    }else{
        $first = Carbon::now()->startOfMonth()->format('Y-m-d');
        $last = Carbon::now()->endOfMonth()->format('Y-m-d');
    }


    $sectionnseries = Shop::where('id','=',8)->value('no_of_sections');
    $sectionfseries = Shop::where('id','=',10)->value('no_of_sections');

    $sectioncvtrim = Shop::where('id','=',5)->value('no_of_sections');
    $sectionlcvtrim = Shop::where('id','=',11)->value('no_of_sections');
    $sectionlcvinchess = Shop::where('id','=',12)->value('no_of_sections');

    $sectionriv = Shop::where('id','=',6)->value('no_of_sections');


    $weekMap = [0 => 'S',1 => 'M',2 => 'T',3 => 'W',4 => 'T',5 => 'F',6 => 'S'];

        $first1 = $first;  $dayname = [];
        while ($first1 <= $last) {

            $buffer = BufferStatus::where('date','=',$first1)->get(['timline','paintshop','riveting']);
            if(count($buffer) > 0){
                $trimbuff = BufferStatus::where('date','=',$first1)->value('timline');
                $paintbuff = BufferStatus::where('date','=',$first1)->value('paintshop');
                $rivbuff = BufferStatus::where('date','=',$first1)->value('riveting');

                $trimbuffers[] = $trimbuff; $paintbuffers[] = $paintbuff; $rivbuffers[] = $rivbuff;

                $trimvarience[] = 8 - $trimbuff;
                $rivvarience[] = 4 - $rivbuff;
                $paintvarience[] = 9 - $paintbuff;

                $dates[] = Carbon::createFromFormat('Y-m-d', $first1)->format('jS');
                $dayOfTheWeek = Carbon::parse($first1)->dayOfWeek;
                $dayname[] = $weekMap[$dayOfTheWeek];
            }

            $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
        }
        if(count($dayname) == 0){
            Toastr::error('Oops! Sorry, No data for selected month.');
            return back();
        }

    $data = array(
        'first'=>$first,
        'trimbuffers'=>$trimbuffers, 'paintbuffers'=>$paintbuffers, 'rivbuffers'=>$rivbuffers,
        'trimvarience'=>$trimvarience, 'paintvarience'=>$paintvarience, 'rivvarience'=>$rivvarience,
        'dates'=>$dates,
        'dayname'=>$dayname,
    );
    return view('productionschedule.bufferstatus')->with($data);
}



public function delayedunits(){
    $today = carbon::today()->format("Y-m-d");
    $delays = Unitmovement::where([['datetime_in','!=',$today],['current_shop','>',0]])->get();
    /*return $delays = Unitmovement::where([['shop_id','=',14],['datetime_in','!=',$today],['current_shop','>',0],['datetime_in','<=',"2021-12-28"]])->get(['vehicle_id']);
    $vids = [860,861,863,864];
    for($i = 0; $i < count($vids); $i++){
        Querydefect::where('vehicle_id',$vids[$i])->delete();
        Drr::where('vehicle_id',$vids[$i])->delete();
        Queryanswer::where('vehicle_id',$vids[$i])->delete();
        Unitmovement::where('vehicle_id',$vids[$i])->delete();
        vehicle_units::where('id',$vids[$i])->delete();
    }
    return "yesass";*/

    $data = array(
        'delays'=>$delays,
        'today'=>$today,
    );
    return view('productionschedule.delayedunits')->with($data);
}

	public function delayedunitsExport(){
		$today = carbon::today()->format("Y-m-d");
		$delays = Unitmovement::where([['datetime_in','!=',$today],['current_shop','>',0]])->get();
		$data = array(
			'delays'=>$delays,
			'today'=>$today,
		);
		return Excel::download(new ExportDelayedUnits($data), 'delayed_units.xlsx');
		//return view('productionschedule.delayedunits')->with($data);
	}

}
