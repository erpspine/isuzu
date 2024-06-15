<?php

namespace App\Http\Controllers\summary;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\unitmovement\Unitmovement;
use App\Models\shop\Shop;
use App\Models\employee\Employee;
use App\Models\attendance\Attendance;
use App\Models\productiontarget\Production_target;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class SummaryController extends Controller
{
    public function yrresponsesummary(Request $request){

        if($request->input()){
           $selectedyr = $request->input('years');
        }else{
            $selectedyr = Carbon::parse()->format('Y');
        }
        $currentyear = Carbon::parse()->format('Y');
        for($i = 2022; $i <= $currentyear; $i++){ $years[] = $i; }

        //LOOPING ALL THE MONTHS AND CALCULATING
        for ($i=1; $i <= 12; $i++) {
            $month = Carbon::createFromFormat('Y-m', ''.$selectedyr.'-'.$i.'')->format('Y-m-d');
            $first = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
            $endmonth = Carbon::parse($month)->endOfMonth()->format('Y-m-d');

            //Plant FCW MTD
            $Monthsfcw[] = Unitmovement::whereBetween('datetime_out', [$first, $endmonth])->where('shop_id','=',16)->count();
            //Offline
            $Monthsoffline[] = Unitmovement::whereBetween('datetime_out', [$first, $endmonth])->where('shop_id','=',8)->count() + Unitmovement::whereBetween('datetime_out', [$first, $endmonth])->where('shop_id','=',10)->count() + Unitmovement::whereBetween('datetime_out', [$first, $endmonth])->where('shop_id','=',13)->count();
        }

        $data = array(
            'years'=>$years,
            'selectedyr'=>$selectedyr,
        );
        return view('summary.yrresponsesummary')
        ->with('Monthsfcw',json_encode($Monthsfcw,JSON_NUMERIC_CHECK))
        ->with('Monthsoffline',json_encode($Monthsoffline,JSON_NUMERIC_CHECK))
        ->with($data);
    }

    public function mnthresponsesummary(Request $request){
        if($request->input()){
            $selectedmonth = $request->input('month');
         }else{
            $selectedmonth = Carbon::today()->format('F Y');
         }

         $month = Carbon::createFromFormat('F Y',$selectedmonth)->format('Y-m-d');
         $first = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
         $endmonth = Carbon::parse($month)->endOfMonth()->format('Y-m-d');

         $first1 = $first;
         while($first1 <= $endmonth){
            //Plant FCW MTD
            $daysfcw[] = Unitmovement::where([['datetime_out',$first1],['shop_id',16]])->count();
            //Offline
            $daysoffline[] = Unitmovement::where([['datetime_out',$first1],['shop_id','=',8]])->count() + Unitmovement::where([['datetime_out',$first1],['shop_id','=',10]])->count() + Unitmovement::where([['datetime_out',$first1],['shop_id',13]])->count();

            $dates[] = Carbon::createFromFormat('Y-m-d', $first1)->format('jS');
            $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
         }
        $data = array(
            'selectedmonth'=>$selectedmonth,
        );
        return view('summary.mnthresponsesummary')
        ->with('daysfcw',json_encode($daysfcw,JSON_NUMERIC_CHECK))
        ->with('daysoffline',json_encode($daysoffline,JSON_NUMERIC_CHECK))
        ->with('dates',json_encode($dates,JSON_NUMERIC_CHECK))
        ->with($data);
    }


    public function yrpeoplesummary(Request $request){
        if($request->input()){
            $selectedshop = $request->input('shopid');
            $selectedyr = $request->input('years');
         }else{
            $selectedshop = 'plant';
             $selectedyr = Carbon::parse()->format('Y');
         }
         $currentyear = Carbon::parse()->format('Y');
         for($i = 2022; $i <= $currentyear; $i++){ $years[] = $i; }

         //LOOPING ALL THE MONTHS AND CALCULATING
         for ($i=1; $i <= 12; $i++) {
             $month = Carbon::createFromFormat('Y-m', ''.$selectedyr.'-'.$i.'')->format('Y-m-d');
             $first = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
             $endmonth = Carbon::parse($month)->endOfMonth()->format('Y-m-d');

             if($selectedshop == 'plant'){
                    $MonthTLavail[] = getTLavailability($first,$endmonth);

                    //ABSENTEEISM
                    $monthabsentiesm[] = getAbsenteeism($first,$endmonth);

                    //MTD EFFICIENCY
                    $monthplant_eff[] = getPlantEfficiency($first,$endmonth);//($MTDinput > 0) ? round(($MTDoutput/$MTDinput)*100,0) : 0;

             }else{
                 //PER SHOP
                 //Plant TEAMLEADER AVAILABILITY MTD
                    $MonthTLavail[] = getshopTLavailability($first,$endmonth,$selectedshop);

                    //ABSENTEEISM
                    $monthabsentiesm[] = getshopAbsenteeism($first,$endmonth,$selectedshop);

                    //MTD EFFICIENCY
                    $monthplant_eff[] = getshopEfficiency($first,$endmonth,$selectedshop);;//($MTDinput > 0) ? round(($MTDoutput/$MTDinput)*100,0) : 0;
             }

         }
         $selectedshop = ($selectedshop == 'plant') ? $selectedshop : Shop::where('id',$selectedshop)->value('shop_name');
         $data = array(
            'shops'=>Shop::where('check_shop',1)->get(['id','shop_name']),
             'years'=>$years,
             'selectedyr'=>$selectedyr,
             'selectedshop'=>$selectedshop,
         );
         return view('summary.yrpeoplesummary')
         ->with('MonthTLavail',json_encode($MonthTLavail,JSON_NUMERIC_CHECK))
         ->with('monthabsentiesm',json_encode($monthabsentiesm,JSON_NUMERIC_CHECK))
         ->with('monthplant_eff',json_encode($monthplant_eff,JSON_NUMERIC_CHECK))
         ->with($data);
    }

    public function mnthpeoplesummary(Request $request){
        //return $shop = ;
        if($request->input('shopid')){
            $selectedshop = $request->input('shopid');
            $selectedmonth = $request->input('month');
         }else{
            $selectedshop = 'plant';
             $selectedmonth = Carbon::parse()->format('F Y');
         }

         $month = Carbon::createFromFormat('F Y',$selectedmonth)->format('Y-m-d');
         $first = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
         $endmonth = Carbon::parse($month)->endOfMonth()->format('Y-m-d');

         if($selectedshop == 'plant'){
            $first1 = $first;
         while($first1 <= $endmonth){
             //Plant TEAMLEADER AVAILABILITY MTD
             $efshops = Shop::where('check_shop','=','1')->get(['report_name','id']);
             $plantTThrs =0; $plantindirect = 0;
                foreach($efshops as $shop){
                    $direct = 0; $indirect = 0;
                    $teamleaders = Employee::where([['team_leader','=','yes'],['shop_id', '=', $shop->id],['status','=','Active']])->get('id');
                    foreach($teamleaders as $tl){
                        $direct += Attendance::where([['staff_id',$tl->id],['date',$first1]])
                                    ->sum(DB::raw('direct_hrs + othours'));
                        $indirect += Attendance::where([['staff_id',$tl->id],['date',$first1]])
                                    ->sum(DB::raw('indirect_hrs + indirect_othours'));
                    }
                    $plantTThrs += $indirect+$direct;
                    $plantindirect += $indirect;
                }
                $DaysTLavail[] = ($plantTThrs > 0) ? round(($plantindirect/$plantTThrs)*100,0) : 0;

                //ABSENTEEISM
                $empcount = Attendance::where('date',$first1)->count();

                $expectedhrs = $empcount * 8;
                $hrsworked = Attendance::where('date',$first1)
                                ->sum(DB::raw('direct_hrs + indirect_hrs'));
                if($hrsworked == 0){
                    $Daysabsentiesm[] = 0;
                }else{
                    $absent = $expectedhrs - $hrsworked;
                    ($absent > 0) ? $Daysabsentiesm[] = round(((($absent)/$expectedhrs)*100),0) : $Daysabsentiesm[] = 0;
                }

                //EFFICIENCY
                $tddrhrs = Attendance::where('date',$first1)->sum(DB::raw('efficiencyhrs'));
                $tdlnhrs = Attendance::where('date',$first1)->sum(DB::raw('loaned_hrs'));
                $tdotlnhrs = Attendance::where('date',$first1)->sum(DB::raw('otloaned_hrs'));
                $TDinput = $tddrhrs + $tdlnhrs + $tdotlnhrs;

                $TDoutput = Unitmovement::where('datetime_out',$first1)->sum('std_hrs');
                $Daysplant_eff[] = ($TDinput > 0) ? round(($TDoutput/$TDinput)*100,0) : 0;

                $dates[] = Carbon::createFromFormat('Y-m-d', $first1)->format('jS');
                $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');

            }
         }else{
             //SPECIFIED SHOPS

            $first1 = $first;
         while($first1 <= $endmonth){
             //Plant TEAMLEADER AVAILABILITY MTD
                    $direct = 0; $indirect = 0;
                    $teamleaders = Employee::where([['team_leader','yes'],['shop_id',$selectedshop],['status','=','Active']])->get('id');
                    foreach($teamleaders as $tl){
                        $direct += Attendance::where([['staff_id',$tl->id],['date',$first1]])
                                    ->sum(DB::raw('direct_hrs + othours'));
                        $indirect += Attendance::where([['staff_id',$tl->id],['date',$first1]])
                                    ->sum(DB::raw('indirect_hrs + indirect_othours'));
                    }
                    $plantTThrs = $indirect+$direct;
                    $plantindirect = $indirect;

                $DaysTLavail[] = ($plantTThrs > 0) ? round(($plantindirect/$plantTThrs)*100,0) : 0;

                //ABSENTEEISM
                $empcount = Attendance::where([['date',$first1],['shop_id',$selectedshop]])->count();

                $expectedhrs = $empcount * 8;
                $hrsworked = Attendance::where([['date',$first1],['shop_id',$selectedshop]])
                                ->sum(DB::raw('direct_hrs + indirect_hrs'));
                if($hrsworked == 0){
                    $Daysabsentiesm[] = 0;
                }else{
                    $absent = $expectedhrs - $hrsworked;
                    ($absent > 0) ? $Daysabsentiesm[] = round(((($absent)/$expectedhrs)*100),0) : $Daysabsentiesm[] = 0;
                }

                //EFFICIENCY
                $tddrhrs = Attendance::where([['date',$first1],['shop_id',$selectedshop]])->sum(DB::raw('efficiencyhrs'));
                $tdlnhrs = Attendance::where([['date',$first1],['shop_id',$selectedshop]])->sum(DB::raw('loaned_hrs'));
                $tdotlnhrs = Attendance::where([['date',$first1],['shop_id',$selectedshop]])->sum(DB::raw('otloaned_hrs'));
                $TDinput = $tddrhrs + $tdlnhrs + $tdotlnhrs;

                $TDoutput = Unitmovement::where([['datetime_out',$first1],['shop_id',$selectedshop]])->sum('std_hrs');
                $Daysplant_eff[] = ($TDinput > 0) ? round(($TDoutput/$TDinput)*100,0) : 0;

                $dates[] = Carbon::createFromFormat('Y-m-d', $first1)->format('jS');
                $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');

            }
            $selectedshop = Shop::where('id',$selectedshop)->value('shop_name');
         }

            //return ;
        $data = array(
            'shops'=>Shop::where('check_shop',1)->get(['id','shop_name']),
            'selectedmonth'=>$selectedmonth,
            'selectedshop'=>$selectedshop,
        );
        return view('summary.mnthpeoplesummary')
        ->with('Daysabsentiesm',json_encode($Daysabsentiesm,JSON_NUMERIC_CHECK))
        ->with('DaysTLavail',json_encode($DaysTLavail,JSON_NUMERIC_CHECK))
        ->with('Daysplant_eff',json_encode($Daysplant_eff,JSON_NUMERIC_CHECK))
        ->with('dates',json_encode($dates,JSON_NUMERIC_CHECK))
        ->with($data);
    }

    public function shopresponsesummary(Request $request){
        if($request->input()){
            $selectedmonth = $request->input('month');
            $selectedshop = $request->input('shopid');
         }else{
             $selectedmonth = Carbon::parse()->format('F Y');
             $selectedshop = 1;
         }

         $currentyear = Carbon::parse()->format('Y');
        for($i = 2022; $i <= $currentyear; $i++){
            for($n = 1; $n <= 12; $n++){
                $months[] = Carbon::createFromFormat('Y-m', ''.$i.'-'.$n.'')->format('F Y');
            }
        }

        $shops = Shop::where('check_shop','1')->get();

         $month = Carbon::createFromFormat('F Y', ''.$selectedmonth.'')->format('Y-m-d');
         $first = Carbon::parse($month)->startOfMonth()->format('Y-m-d');
         $endmonth = Carbon::parse($month)->endOfMonth()->format('Y-m-d');

         $first1 = $first;
         $offline = 0; $target = 0;
         while($first1 <= $endmonth){
            //Offline units per shop
             $offline += Unitmovement::where([['datetime_out',$first1],['shop_id',$selectedshop]])->count();
             $daysoffline[] = $offline;
            $target += Production_target::where('shop'.$selectedshop.'',$first1)->sum('noofunits');
            $offtargets[] = $target;

            $dates[] = Carbon::createFromFormat('Y-m-d', $first1)->format('jS');
            $first1 = Carbon::parse($first1)->addDays(1)->format('Y-m-d');
         }

        $data = array(
            'shops'=>$shops,
            'months'=>$months,
            'selectedmonth'=>$selectedmonth,
            'shopname'=>Shop::where('id',$selectedshop)->value('shop_name'),
        );
        return view('summary.shopresponsesummary')
        ->with('daysoffline',json_encode($daysoffline,JSON_NUMERIC_CHECK))
        ->with('offtargets',json_encode($offtargets,JSON_NUMERIC_CHECK))
        ->with('dates',json_encode($dates,JSON_NUMERIC_CHECK))
        ->with($data);
    }

    public function yrqualitysummary(){
        return view('summary.yrqualitysummary');
    }

    public function mnthqualitysummary(){
        return view('summary.mnthqualitysummary');
    }
}
