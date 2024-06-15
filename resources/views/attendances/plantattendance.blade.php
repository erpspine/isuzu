<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Standard Working Hours</title>

    @include('layouts.header.header')
    @yield('after-styles')

<link rel="stylesheet" type="text/css" href="{{asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">

</head>
<body>

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles" style="background-color:#da251c; ">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-white mb-0">PLANT ATTENDANCE REPORT</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active text-white">REPORTS</li>
            </ol>

        </div>
        <div class="col-md-7">
            <div class="row float-left w-100">
                <div class="col-lg-7">
                    <span  class="btn waves-effect waves-light btn-lg"
                    style="background-color: #DAF7A6; opacity: 0.9; font-familiy:Times New Roman;">

                    <h5 class="float-right mt-2">{{\Carbon\Carbon::today()->format('j M Y')}}</h5></span>
                </div>
                <div class="col-5">
                    <a href="/home" id="btn-add-contact" class="btn btn-primary float-right"
                ><i class="mdi mdi-arrow-left font-16"></i> Back to Home</a>
                </div>
            </div>

        </div>
    </div>

    <!-- End Row -->
    <!-- End Row -->

    <div class="container-fluid">

    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                    <div class="col-6">
                        <ol class="breadcrumb mb-2  bg-grey">
                            <li class="breadcrumb-item">
                                <h3 class="card-title"><u>HOURS WORKED
                                    <span style="text-transform: uppercase;"><br> BETWEEN
                                    ({{$range}})</span></u></h3>
                            </li>
                        </ol>

                    </div>
                    <div class="col-6">
                        {!! Form::open(['action'=>'App\Http\Controllers\attendance\AttendanceController@plantattendance',
                         'method'=>'post', 'enctype' => 'multipart/form-data']); !!}

                        <div class="row">
                            <div class="col-7">
                                <h4 class="card-title">Choose Date Range:</h4>
                                <div class='input-group'>
                                    <!--<input type='text' name="mdate" class="form-control singledate" />-->
                                    <input type='text' name="daterange" class="form-control shawCalRanges" />

                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <span class="ti-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        <div class="col-5">
                            <button type="submit" class="btn btn-success mt-4">Filter HC</button>
                        </div>

                        </div>
                        {{Form::hidden('_method', 'GET')}}
                        {!! Form::close() !!}

                    </div>
                </div>


                    <div class="table-responsive">
                        <table class="tablesaw table-bordered table-hover table no-wrap" data-tablesaw-mode="swipe"
                                    data-tablesaw-sortable data-tablesaw-sortable-switch data-tablesaw-minimap
                                    data-tablesaw-mode-switch>
                            <thead>
                                <th>SHOP</th>
                                <th>EXPECTED HOURS</th>
                                <th> WORKED HOURS</th>
                                <th>ABSENT HOURS</th>
                                <th>% ABSENTIEESM</th>
                                
                            </thead>
                            <tbody>
                                @foreach ($shops as $shop)
                                @php
                                $sub=$shopexpecetdhrs[$shop->id] - $shopworkedhours[$shop->id];
                                $attend=0;
                                    if($sub>0){
                                $attend=($shopexpecetdhrs[$shop->id] - $shopworkedhours[$shop->id])/($shopexpecetdhrs[$shop->id])*100;
                                    }
                                @endphp
                                <tr>
                                    <td>{{$shop->report_name}}</td>
                                    <td>{{$shopexpecetdhrs[$shop->id]}} Hrs</td>
                                    <td>{{$shopworkedhours[$shop->id]}} Hrs</td>
                                    <td>{{$shopexpecetdhrs[$shop->id] - $shopworkedhours[$shop->id]}} Hrs</td>
                                    <td>{{round( $attend,2)}}%</td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                 <th>PLANT</th>
                                <th>{{$planttexpectedhrs}} Hrs</th>
                                <th> {{$plantworkedhrs}} Hrs</th>
                                <th>{{$planttexpectedhrs - $plantworkedhrs}} Hrs</th>
                                <th>{{round($absentism, 4)}}%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer.script')
    @yield('after-scripts')
    @yield('extra-scripts')
    {{ Html::script('dist/js/pages/datatable/datatable-basic.init.js') }}

     {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}

    {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
	
    {{ Html::script('assets/libs/moment/moment.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
    {{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
    {{ Html::script('assets/libs/daterangepicker/daterangepicker.js') }}

    <script>
        $(function(){
        'use strict'
        $('.shawCalRanges').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
                alwaysShowCalendars: true,
            });
        });
    </script>

