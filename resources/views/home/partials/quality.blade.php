
    <div class="card-body">
        <div class="d-flex">
            <h4 class="card-title  ml-3"><a href="{{route('quality_control_dashboard')}} ">QUALITY</a></h4>
        </div>
         <div class="col-lg-12">
            <div class="card-header bg-orange">
                <h4 class="mb-0 text-white">MTD SCORE</h4>
            </div>
            <div class="row text-center mt-2">
                <div class="col-sm-4">
                </div>
                <div class="col-sm-4">
                    <h5>Target</h5>
                </div>
                <div class="col-sm-4">
                    <h5>Actual</h5>
                </div>
            </div>


            <div class="row mb-2">
                <div class="col-sm-4">
                        <h5>DRL</h5>
                </div>
                <div class="col-sm-4">
                    <div class="border text-center pt-2">
                        <h2 class="fs-30 font-w600 counter">{{month_to_date_drl()['drl_target_value']}}</h2>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="border text-center pt-2">
                        <h2 class="fs-30 font-w600 counter">
                            @if (month_to_date_drl()['drl'] <= month_to_date_drl()['drl_target_value'])
                                <span style="color:green;">{{month_to_date_drl()['drl']}}</span>
                            @else
                                <span style="color:red;">{{month_to_date_drl()['drl']}}</span>
                            @endif
                        </h2>
                    </div>
                </div>
            </div>
                <div class="row mb-2">
                    <div class="col-sm-4 ">
                            <h5>DRR</h5>
                    </div>
                    <div class="col-sm-4">
                        <div class="border text-center pt-2">
                            <h2 class="fs-30 font-w600 counter">{{month_to_date_drr()['drr_target_value']}}</h2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="border text-center pt-2">
                            <h2 class="fs-30 font-w600 counter">
                                @if (month_to_date_drr()['plant_drr'] >= month_to_date_drr()['drr_target_value'])
                                    <span style="color:green;">{{month_to_date_drr()['plant_drr']}}</span>
                                @else
                                    <span style="color:red;">{{month_to_date_drr()['plant_drr']}}</span>
                                @endif
                            </h2>

                        </div>
                    </div>

                </div>

                <div class="row mb-2">
                    <div class="col-sm-4">
                            <h5>CARE</h5>
                    </div>
                    <div class="col-sm-4">
                        <div class="border text-center pt-2">
                            <h2 class="fs-30 font-w600 counter">{{month_to_date_drr()['care_target_value']}}</h2>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="border text-center pt-2">
                            <h2 class="fs-30 font-w600 counter">
                                @if (month_to_date_drr()['care'] >= month_to_date_drr()['care_target_value'])
                                    <span style="color:rgb(6, 236, 6);">{{month_to_date_drr()['care']}}</span>
                                @else
                                    <span style="color:red;">{{month_to_date_drr()['care']}}</span>
                                @endif
                            </h2>
                        </div>
                    </div>
            </div>
    </div>
<hr>

<div class="col-lg-12">
    <div class="card-header bg-orange">
        <h4 class="mb-0 text-white">MTD GCA SCORE</h4>
    </div>

    <table width="100%" class="text-center mt-3">
        <tr>
            <th></th>
            <th colspan="2">DPV</th>
            <th colspan="2" class="ml-1">WDPV</th>
        </tr>
        <tr>
            <td></td>
            <td class="pt-2"><i>Target</i></td>
            <td class="pt-2"><i>Actual</i></td>
            <td class="ml-1 pt-2"><i>Target</i></td>
            <td  class="pt-2"><i>Actual</i></td>
        </tr>
        <tr>
            <td>
                <h4>CV</h4>
            </td>
            <td>
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600"><span>{{$master['cvdpvtarget']}}</span> </h4>
                </div>
            </td>
            <td class="pr-1">
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600">
                        @if ($master['cvdpv'] >= $master['cvdpvtarget'])
                            <span style="color:rgb(6, 236, 6);">{{$master['cvdpv']}}</span>
                        @else
                            <span class="text-danger">{{$master['cvdpv']}}</span>
                        @endif
                    </h4>
                </div>
            </td>
            <td class="pl-1">
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600"><span>{{$master['cvwdpvtarget']}}</span> </h4>
                </div>
            </td>
            <td>
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600">
                        @if ($master['cvwdpv'] >= $master['cvwdpvtarget'])
                            <span style="color:rgb(6, 236, 6);">{{$master['cvwdpv']}}</span>
                        @else
                            <span class="text-danger">{{$master['cvwdpv']}}</span>
                        @endif
                    </h4>
                </div>
            </td>
        </tr>
        <tr>
            <td>
                <h4>LCV</h4>
            </td>
            <td>
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600"><span>{{$master['lcvdpvtarget']}}</span> </h4>
                </div>
            </td>
            <td class="pr-1">
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600">
                        @if ($master['lcvdpv'] >= $master['lcvdpvtarget'])
                            <span style="color:rgb(6, 236, 6);">{{$master['lcvdpv']}}</span>
                        @else
                            <span class="text-danger">{{$master['lcvdpv']}}</span>
                        @endif
                    </h4>
                </div>
            </td>
            <td class="pl-1">
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600"><span>{{$master['lcvwdpvtarget']}}</span> </h4>
                </div>
            </td>
            <td>
                <div class="border text-center pt-2">
                    <h4 class="fs-26 font-w600">
                        @if ($master['lcvwdpv'] >= $master['lcvwdpvtarget'])
                            <span style="color:rgb(6, 236, 6);">{{$master['lcvwdpv']}}</span>
                        @else
                            <span class="text-danger">{{$master['lcvwdpv']}}</span>
                        @endif
                    </h4>
                </div>
            </td>
        </tr>
    </table>
</div>
<hr>
</div>
