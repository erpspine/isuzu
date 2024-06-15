
    <div class="card-body">
        <div class="d-flex">
            <h4 class="card-title  ml-3">RESPONSIVENESS</h4>
        </div>

      <div class="col-lg-12">
        <div class="card-header bg-info mb-3">
            <h4 class="mb-0 text-white">MTD OFFLINE</h4>
            </div>
            <div class="table-responsive1">
                <table class="tablesaw table-bordered text-center">
                    <thead>
                        <th><h5>Actual</h5></th>
                        <th><h5>Target</h5></th>
                        <th><h5>Variance</h5></th>
                    </thead>
                    <tbody>
                            <tr>
                                <th><h4 class="fs-26 font-w600 text-center"><b>{{$master['offline']}}</b></h4></th>
                                <th><h4 class="fs-26 font-w600 text-center"><b>{{$master['offtarget']}}</b></h4></th>
                                <th><h4 class="fs-26 font-w600 text-center"><b>
                                    @if ($master['offvar'] >= 0)
                                        <span style="color:rgb(6, 236, 6);"><i class="mdi mdi-arrow-up"></i>
                                            {{abs($master['offvar'])}}</span>
                                    @else
                                        <span class="text-danger"><i class="mdi mdi-arrow-down"></i>
                                            {{abs($master['offvar'])}}</span>
                                    @endif
                                </b></h4></th>
                            </tr>
                    </tbody>
                </table>
            </div>
    </div>
    <hr>

<div class="col-lg-12">
<div class="card-header bg-info mb-3">
<h4 class="mb-0 text-white">MTD FCW</h4>
</div>
<div class="table-responsive1">
    <table class="tablesaw table-bordered text-center">
        <thead>
            <th><h5>Actual</h5></th>
            <th><h5>Target</h5></th>
            <th><h5>Variance</h5></th>
        </thead>
        <tbody>
                <tr>
                    <th><h4 class="fs-26 font-w600 text-center"><b>{{$master['actual']}}</b></h4></th>
                    <th><h4 class="fs-26 font-w600 text-center"><b>
                        {{$master['fcwtarget']}}
                    </b></h4 >
                    </th>
                    <th><h4 class="fs-26 font-w600 text-center"><b>
                            @if ($master['fcwvarience'] >= 0)
                                <span style="color:rgb(6, 236, 6);"><i class="mdi mdi-arrow-up"></i>
                                    {{abs($master['fcwvarience'])}}</span>
                            @else
                                <span class="text-danger"><i class="mdi mdi-arrow-down"></i>
                                    {{abs($master['fcwvarience'])}}</span>
                            @endif

                    </b></h4>
                    </th>
                </tr>
        </tbody>
    </table>
</div>
</div>
<hr>


<div class="col-lg-12">
<div class="card-header bg-info mb-3">
<h4 class="mb-0 text-white">MTD EFFICIENCY</h4>
</div>
<div class="table-responsive1">
    <table class="tablesaw table-bordered text-center">
        <thead>
            <th><h5>Actual</h5></th>
            <th><h5>Target</h5></th>
            <th><h5>Status</h5></th>
        </thead>
        <tbody>
            <tr>
                <th><h4><b>{{$master['plant_eff']}}%</b></h4></th>
                <th><h4><b>
                    {{$master['efftag']}}%
                </b></h4></th>
                <th class="text-center"><h4>
                    @if ($master['plant_eff'] >= $master['efftag'])
                    <span style="font-family: Arial Unicode MS, Lucida Grande; color:rgb(6, 236, 6);">
                        &#10004;
                    </span>
                    @else
                    <span style="font-family: Arial Unicode MS, Lucida Grande; color:red;">
                        &#x2717;
                    </span>
                    @endif

                    </h4></th>
            </tr>
        </tbody>
    </table>
</div>
</div>
</div>
