@extends('layouts.app')
@section('title', 'D Report')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">GCA REPORT </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">DPV & WDPV</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
                DPV & WDPV Report
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        {{ Form::open(['route' => 'gcadpvwdpv', 'role' => 'form', 'method' => 'get']) }}
        <div class="row">
            @php
                $checked = 'today';
                $checkedsection = null;
                $dated = null;
                $datem = null;
                $datey = null;
                if (isset($sample_size)) {
                    if ($period == 'daily') {
                        $checked = 'today';
                    } elseif ($period == 'month_to_date') {
                        $checked = 'month_to_date';
                    } elseif ($period == 'year_to_date') {
                        $checked = 'year_to_date';
                    }
                    if ($section == 'cv') {
                        $checkedsection = 'cv';
                    } elseif ($section == 'lcv') {
                        $checkedsection = 'lcv';
                    }
                    $dated = $dailyselecteddate;
                    $datem = $monthlyselecteddate;
                    $datey = $yealyselecteddate;
                }
            @endphp
            <div class="col-lg-3 mb-2">
                <div class="row">
                    <div class="col-md-4">
                        <input name="period" value="daily" class="material-inputs date_type " type="radio"
                            id="date_1" {{ $checked == 'today' ? 'checked' : '' }} />
                        <label for="date_1">Daily</label>
                    </div>
                    <div class="col-md-4">
                        <input name="period" value="month_to_date" class="material-inputs date_type" type="radio"
                            id="date_2" {{ $checked == 'month_to_date' ? 'checked' : '' }} />
                        <label for="date_2">MTD</label>
                    </div>
                    <div class="col-md-4">
                        <input name="period" value="year_to_date" class="material-inputs date_type" type="radio"
                            id="date_3" {{ $checked == 'year_to_date' ? 'checked' : '' }} />
                        <label for="date_3">YTD</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input name="section" value="cv" class="material-inputs" type="radio" id="radio_2"
                            {{ $checkedsection == 'cv' ? 'checked' : '' }} />
                        <label for="radio_2">CV</label>
                    </div>
                    <div class="col-md-4">
                        <input name="section" value="lcv" type="radio" class="with-gap material-inputs" id="radio_3"
                            {{ $checkedsection == 'lcv' ? 'checked' : '' }} />
                        <label for="radio_3">LCV</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-6  mb-6">
                <div class="row ">
                    <div class="col-12" id="today_date">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <input class="form-control from_custom_date" type="text" id="today"
                                        name="date" value="{{ $dated }}" data-toggle="datepicker"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-success ">Filter By Date</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="month_date">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <input class="form-control from_custom_date" type="text" id="datepicker"
                                        name="month_date" value="{{ $datem }}" data-toggle="datepicker"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-success">Filter By Month</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" id="year_date">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <input class="form-control from_custom_date" type="text" id="year_datepicker"
                                        name="year_date" value="{{ $datey }}" data-toggle="datepicker"
                                        autocomplete="off">
                                </div>
                            </div>
                            <div class="col-4">
                                <button type="submit" class="btn btn-success">Filter By Year</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{ Form::close() }}
        <!-- Individual column searching (select inputs) -->
        @if (session()->has('message'))
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-danger">
                                {{ session()->get('message') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Individual column searching (select inputs) -->
        @if (isset($sample_size))
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header bg-primary  text-white">{{ $title }}
                            <a class="float-right text-white"
                                href="{{ route('printgca', ['' . encrypt_data($period) . '', '' . encrypt_data($section) . '', '' . encrypt_data($dateselected) . '','' . encrypt_data($dpv_target) . '','' . encrypt_data($wdpv_target) . '']) }}"
                                target="_blank"><i class=" fas fa-print"></i> Print</a>
                        </div>
                        <div class="card-body">
                            <div id="dpvChart" style="width: 100%; height: 360px;"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary  text-white">GRAPHICAL REPORT BY CATEGORY</div>
                        <div class="card-body">
                            <div id="basic-bar" style="height:360px;"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary  text-white">GRAPHICAL REPORT BY SHOP</div>
                        <div class="card-body">
                            <div id="shopChart" style="height:360px;"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-primary  text-white">GCA REPORT BY PERIOD
                        </div>
                        <div class="card-body">
                            <div class="table-responsive sticky-table ">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th rowspan="2"> Sample Size</th>
                                            <th colspan="3">DPV</th>
                                            <th colspan="3">WDPV</th>
                                        </tr>
                                        <tr>
                                            <th>Target</th>
                                            <th>Actual</th>
                                            <th>Status</th>
                                            <th>Target</th>
                                            <th>Actual</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="table-success">
                                            <td>{{ $sample_size }}</td>
                                            <td>{{ $dpv_target }}</td>
                                            <td>{{ $dpv }}</td>
                                            <td>{{ $dpvtatus }}</td>
                                            <td>{{ $wdpv_target }}</td>
                                            <td>{{ $wdpv }}</td>
                                            <td>{{ $wdpvtatus }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-success  text-white">REPORT BY CATEGORY</div>
                        <div class="card-body">
                            <div class="table-responsive sticky-table ">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>DPV</th>
                                            <th>WDPV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totaldpv = 0;
                                            $totalwdpv = 0;
                                        @endphp
                                        @foreach ($categories as $category)
                                            @php
                                                $dpv = 0;
                                                $wdpv = 0;
                                                if ($category->answers_sum_defect_count > 0 && $sample_size > 0) {
                                                    $dpv = $category->answers_sum_defect_count / $sample_size;
                                                    $wdpv = @$category->answers->first()->total_price / $sample_size;
                                                }
                                                $totaldpv += $dpv;
                                                $totalwdpv += $wdpv;
                                            @endphp
                                            <tr>
                                                <td>{{ $category->name }}</td>
                                                <td>{{ $dpv }}</td>
                                                <td>{{ $wdpv }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ $totaldpv }}</td>
                                            <td>{{ $totalwdpv }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-success  text-white">REPORT BY SHOP </div>
                     
                        <div class="card-body">
                            <div class="table-responsive sticky-table ">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Shops</th>
                                            <th>DPV</th>
                                            <th>WDPV</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalsdpv = 0;
                                            $totalswdpv = 0;
                                        @endphp
                                        @foreach ($shopDataToday as $key=>$val)
                                        @php
                                        $dpv=round(($val->defect_count/$sample_size),2);
                                        $wdpv=round(($val->total_weight/$sample_size),2);
                                        $totalsdpv += $dpv;
                                        $totalswdpv += $wdpv;
                                       @endphp

                                       
                                          
                                            <tr>
                                                <td>{{ $val->shop_name }}</td>
                                                <td>{{  $dpv }}</td>
                                                <td>{{  $totalswdpv }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td>Total</td>
                                            <td>{{ $totalsdpv }}</td>
                                            <td>{{ $totalswdpv }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @foreach ($defects as $details )
                            
                      

                        <div class="col-sm-6 col-md-4">
                            <div class="card border-white">
                                <div class="card-header">Defects</div>
                                @if ($details->defect_image !=null)
                                <img src="{{ $details->DefectImageUri }}" class="card-img-top" >
                                @endif

                                    <div class="card-body">
                                        <ul class="list-group">
                                            <li class="list-group-item active">Defect  Details</li>
                                            <li class="list-group-item">Date: <b>{{ dateFormat($details->vehicle->gca_completion_date) }}</b></li>
                                            <li class="list-group-item">Vehicle Type: <b>{{$details->vehicle_type }}</b></li>
                                            <li class="list-group-item">Vehicle: <b>{{$details->vehicle->vin_no }}</b></li>
                                            <li class="list-group-item">Lot & Job: <b>{{$details->vehicle->lot_no . ', ' . $details->vehicle->job_no }}</b></li>
                                            <li class="list-group-item">Shop: <b>{{$details->shop->report_name }}</b></li>
                                            <li class="list-group-item">Category: <b>{{$details->auditCategory->name }}</b></li>
                                            <li class="list-group-item">Defect: <b>{{$details->defect }}</b></li>
                                            <li class="list-group-item">UPC/FCA/Sheet No: <b>{{$details->gca_manual_reference }}</b></li>
                                            <li class="list-group-item">Teamleader: <b>{{ $details->responsible_team_leader }}</b></li>
                                            <li class="list-group-item">Defect Count: <b>{{ $details->defect_count}}</b></li>
                                            <li class="list-group-item">Defect Weight: <b>{{ $details->weight }}</b></li>
                                            <li class="list-group-item">Status: <b>{{ ($details->is_corrected == 'No') ? 'Open' : 'Closed'}}</b></li>
                                      
                                       
                                          </ul>
                                    </div>
                                </div>
                            <!--</div>-->
                        </div>
                        @endforeach
                
                    
                     
                
                </div>


                </div>
            </div>
        @endif
    @endsection
    @section('after-styles')
        {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
        {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
        {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
        {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
        {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
        {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
        {{ Html::style('assets/libs/sticky/jquery.stickytable.css') }}
        <style>
            .bg-ok {
                background-color: #61f213 !important;
            }

            .bg-nok {
                background-color: #da251c !important;
            }

            .datepicker {
                z-index: 9999 !important
            }
        </style>
    @endsection
    @section('after-scripts')
        {{ Html::script('assets/libs/datepicker/datepicker.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
        {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
        {{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
        {{ Html::script('assets/libs/sticky/jquery.stickytable.js') }}
        {{ Html::script('assets/libs/echarts/dist/echarts-en.min.js') }}
        <script type="text/javascript">
            $('#daily-modal').on('shown.bs.modal', function() {
                $('[data-toggle="datepicker"]').datepicker({
                    autoHide: true,
                    format: 'dd-mm-yyyy',
                });
                $('.from_date').datepicker('setDate', 'today');
            });
            $('#custom').on('shown.bs.modal', function() {
                $('[data-toggle="datepicker"]').datepicker({
                    autoHide: true,
                    format: 'dd-mm-yyyy',
                });
                $('.from_custom_date').datepicker('setDate', 'today');
                $('.to_custom__date').datepicker('setDate', 'today');
            });
            $(function() {
                var today = new Date();
                $("#datepicker").datepicker({
                    showDropdowns: true,
                    format: "MM yyyy",
                    viewMode: "years",
                    minViewMode: "months",
                    maxDate: today,
                }).on('changeDate', function(e) {
                    $(this).datepicker('hide');
                });
                $("#today").datepicker({
                    showDropdowns: true,
                    format: "dd-mm-yyyy",
                    viewMode: "days",
                    minViewMode: "days",
                    maxDate: today,
                }).on('changeDate', function(e) {
                    $(this).datepicker('hide');
                })
                $("#year_datepicker").datepicker({
                    showDropdowns: true,
                    format: "yyyy",
                    viewMode: "years",
                    minViewMode: "years",
                    maxDate: today,
                }).on('changeDate', function(e) {
                    $(this).datepicker('hide');
                })
            });
            if ($('#date_1').is(":checked")) {
                $('#today_date').show();
                $('#month_date').hide();
                $('#year_date').hide();
            }
            if ($('#date_2').is(":checked")) {
                $('#today_date').hide();
                $('#month_date').show();
                $('#year_date').hide();
            }
            if ($('#date_3').is(":checked")) {
                $('#year_date').show();
                $('#today_date').hide();
                $('#month_date').hide();
            }
            $('.date_type').on("change", function() {
                var record = $('input[name="period"]:checked').val();
                if (record == 'daily') {
                    $('#today_date').show();
                    $('#month_date').hide();
                    $('#year_date').hide();
                } else if (record == 'month_to_date') {
                    $('#today_date').hide();
                    $('#month_date').show();
                    $('#year_date').hide();
                } else if (record == 'year_to_date') {
                    $('#year_date').show();
                    $('#today_date').hide();
                    $('#month_date').hide();
                }
            });
        </script>
        <script type="text/javascript">
            @if (isset($sample_size))
                $(function() {
                    "use strict";
                    var myChart = echarts.init(document.getElementById('basic-bar'));
                    var months = {!! $catjson !!};
                    var dpv = {{ $dpvjson }};
                    var wdpv = {{ $wdpvjson }};
                    var dpvTarget = {{ $dpv_target }}; // Adjust this value as needed
                    var wdpvTarget = {{ $wdpv_target }}; // Adjust this value as needed
                    // specify chart configuration item and data
                    var option = {
                        // Setup grid
                        grid: {
                            left: '1%',
                            right: '2%',
                            bottom: '3%',
                            containLabel: true
                        },
                        title: {
                            text: 'REPORT BY CATEGORY',
                        },
                        // Add markLine for WDPV target
                        // Add markLine for WDPV target
                        // Add Tooltip
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data: ['DPV', 'WDPV']
                        },
                        /* toolbox: {
                             show : true,
                             feature : {
                                 magicType : {show: true, type: ['line', 'bar']},
                                 restore : {show: true},
                                 saveAsImage : {show: true}
                             }
                         },*/
                        color: ["#A6E0F7", "#1176F7"],
                        calculable: true,
                        xAxis: [{
                            type: 'category',
                            data: months,
                            axisLabel: {
                                interval: 0,
                                rotate: 45,
                                textStyle: {
                                    color: '#333'
                                }
                            }
                        }],
                        yAxis: [{
                            type: 'value'
                        }],
                        series: [{
                                name: 'DPV',
                                type: 'bar',
                                data: dpv, //[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                                markLine: {
                                    symbol: 'none',
                                    data: [{
                                        yAxis: dpvTarget,
                                        name: 'DPV Target'
                                    }],
                                    lineStyle: {
                                        normal: {
                                            color: '#A6E0F7', // Color for the DPV target line
                                            type: 'solid',
                                            width: 2
                                        }
                                    }
                                },
                            },
                            {
                                name: 'WDPV',
                                type: 'bar',
                                data: wdpv, //[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                                markLine: {
                                    symbol: 'none',
                                    data: [{
                                        yAxis: wdpvTarget,
                                        name: 'WDPV Target'
                                    }],
                                    lineStyle: {
                                        normal: {
                                            color: '#1176F7', // Color for the WDPV target line
                                            type: 'solid',
                                            width: 2
                                        }
                                    }
                                },
                            }
                        ]
                    };
                    // use configuration item and data specified to show chart
                    myChart.setOption(option);
                    myChart.on('rendered', function() {
                        var chartDataURL = myChart.getDataURL({
                            type: 'png',
                            pixelRatio: 2, // Adjust pixel ratio as needed
                            backgroundColor: '#fff',
                        });
                        // Handle the imageURL as needed
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST', // or 'GET' depending on your server-side handling
                            url: '{{ route('savegraphimage') }}', // Replace with the server-side route where you handle saving
                            data: {
                                graph_type: 'category',
                                chartDataURL: chartDataURL,
                            },
                            success: function(response) {
                                console.log('Chart image saved successfully');
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    });
                    // Initialize ECharts instance
                    var dpvChart = echarts.init(document.getElementById('dpvChart'));
                    // ECharts configuration options
                    var options = {
                        grid: {
                            left: '1%',
                            right: '2%',
                            bottom: '3%',
                            containLabel: true
                        },
                        title: {
                            text: 'REPORT BY PERIOD',
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data: ['DPV', 'WDPV']
                        },
                        color: ["#A6E0F7", "#1176F7"],
                        calculable: true,
                        xAxis: [{
                            type: 'category',
                            data: @json(@$dvpWdpvChartData['dates']),
                            axisLabel: {
                                interval: 0,
                                rotate: 45,
                                textStyle: {
                                    color: '#333'
                                }
                            }
                        }],
                        yAxis: [{
                            type: 'value'
                        }],
                        series: [{
                                name: 'DPV',
                                type: 'bar',
                                data: @json(@$dvpWdpvChartData['defect_count']), //[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                                markLine: {
                                    symbol: 'none',
                                    data: [{
                                        yAxis: @json(@$dpv_target),
                                        name: 'DPV Target'
                                    }],
                                    lineStyle: {
                                        normal: {
                                            color: '#A6E0F7', // Color for the DPV target line
                                            type: 'solid',
                                            width: 2
                                        }
                                    }
                                },
                            },
                            {
                                name: 'WDPV',
                                type: 'bar',
                                data: @json(@$dvpWdpvChartData['total_weight']), //[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                                markLine: {
                                    symbol: 'none',
                                    data: [{
                                        yAxis: @json($wdpv_target),
                                        name: 'WDPV Target'
                                    }],
                                    lineStyle: {
                                        normal: {
                                            color: '#1176F7', // Color for the WDPV target line
                                            type: 'solid',
                                            width: 2
                                        }
                                    }
                                },
                            }
                        ],
                    };
                    // Set options and render the chart
                    dpvChart.setOption(options);
                    dpvChart.on('rendered', function() {
                        var dpvWpdvDataURL = dpvChart.getDataURL({
                            type: 'png',
                            pixelRatio: 2, // Adjust pixel ratio as needed
                            backgroundColor: '#fff',
                        });
                        // Handle the imageURL as needed
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST', // or 'GET' depending on your server-side handling
                            url: '{{ route('savegraphimage') }}', // Replace with the server-side route where you handle saving
                            data: {
                                graph_type: 'bydate',
                                chartDataURL: dpvWpdvDataURL,
                            },
                            success: function(response) {
                                console.log('Wdpv  image saved successfully');
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    });
                    // Initialize ECharts instance
                    var shopChart = echarts.init(document.getElementById('shopChart'));
                    // ECharts configuration options
                    var options = {
                        grid: {
                            left: '1%',
                            right: '2%',
                            bottom: '3%',
                            containLabel: true
                        },
                        title: {
                            text: 'REPORT BY SHOP',
                        },
                        tooltip: {
                            trigger: 'axis'
                        },
                        legend: {
                            data: ['DPV', 'WDPV']
                        },
                        color: ["#A6E0F7", "#1176F7"],
                        calculable: true,
                        xAxis: [{
                            type: 'category',
                            data: @json(@$shopChartData['shops']),
                            axisLabel: {
                                interval: 0,
                                rotate: 45,
                                textStyle: {
                                    color: '#333'
                                }
                            }
                        }],
                        yAxis: [{
                            type: 'value'
                        }],
                        series: [{
                                name: 'DPV',
                                type: 'bar',
                                data: @json(@$shopChartData['defect_count']), //[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                                markLine: {
                                    symbol: 'none',
                                    data: [{
                                        yAxis: @json(@$dpv_target),
                                        name: 'DPV Target'
                                    }],
                                    lineStyle: {
                                        normal: {
                                            color: '#A6E0F7', // Color for the DPV target line
                                            type: 'solid',
                                            width: 2
                                        }
                                    }
                                },
                            },
                            {
                                name: 'WDPV',
                                type: 'bar',
                                data: @json(@$shopChartData['total_weight']), //[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                                markLine: {
                                    symbol: 'none',
                                    data: [{
                                        yAxis: @json($wdpv_target),
                                        name: 'WDPV Target'
                                    }],
                                    lineStyle: {
                                        normal: {
                                            color: '#1176F7', // Color for the WDPV target line
                                            type: 'solid',
                                            width: 2
                                        }
                                    }
                                },
                            }
                        ],
                    };
                    // Set options and render the chart
                    shopChart.setOption(options);
                    shopChart.on('rendered', function() {
                        var shopDataURL = shopChart.getDataURL({
                            type: 'png',
                            pixelRatio: 2, // Adjust pixel ratio as needed
                            backgroundColor: '#fff',
                        });
                        // Handle the imageURL as needed
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $.ajax({
                            type: 'POST', // or 'GET' depending on your server-side handling
                            url: '{{ route('savegraphimage') }}', // Replace with the server-side route where you handle saving
                            data: {
                                graph_type: 'shop',
                                chartDataURL: shopDataURL,
                            },
                            success: function(response) {
                                console.log('Shop  image saved successfully');
                            },
                            error: function(error) {
                                console.error(error);
                            }
                        });
                    });
                    $(function() {
                        // Resize chart on menu width change and window resize
                        $(window).on('resize', resize);
                        $(".sidebartoggler").on('click', resize);
                        // Resize function
                        function resize() {
                            setTimeout(function() {
                                // Resize chart
                                myChart.resize();
                                dpvChart.resize();
                                shopChart.resize();
                                // stackedChart.resize();
                                //stackedbarcolumnChart.resize();
                                //barbasicChart.resize();
                            }, 200);
                        }
                    });
                });
        </script>
        @endif
    @endsection
