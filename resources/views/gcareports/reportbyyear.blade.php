@section('title','Report By Year')
@extends('layouts.app')

@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">REPORT BY YEAR </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">REPORT YEAR  </li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

@php
        $dateselected=null;
        $vehicle_type=null;
    if(isset($date)){
        $dateselected =dateFormat($date);
        $vehicle_type=$vtpype;
       

    }
@endphp
    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-cyan mb-2">
                    {{ Form::open(['route' => 'reportbyyear', 'class' => '', 'role' => 'form', 'method' => 'get', 'id' => 'create-report', 'files' => false]) }}


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class='input-group'>
                                            {!! Form::select('vehicle_type', ['cv'=>'cv','lcv'=>'lcv'], $vehicle_type, [
                                                'placeholder' => 'Select Vehicle Type',
                                                'class' => 'form-control custom-select select2',
                                            ]) !!}


                                         
                                        </div>
                                    </div>
                           
                                    <div class="col-md-4">
                                        <div class='input-group'>
                                            <input type='text' value="{{ $dateselected }}" name="date" class="form-control customedate" />

                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <span class="ti-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                            <button class="nav-link btn-danger rounded-pill d-flex align-items-center px-3 mr-5" style="background-color:#da251c; ">
                                          <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Load Report</span></button>
                                    </div>
                                </div>
                       
                           {{ Form::close() }}
                    </div>



              
                  
                  
                  
                
                </div>
            </div>
        </div>
        @if (isset($date))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        Report By Year : <span class="text-success">{{ $date }}</span>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-orange">
                                <thead>
                                    <tr class="table-light">
                                        <th >Points</th>
                                        @foreach ( $months as $month )
                                        <th>{{ $month }}</th>
                                        @endforeach
                                        <th>YTD</th>
                                    </tr>
                              
                                </thead>
                                <tbody>
                                    @foreach ( $dweights as $dweight )
                                    <tr>
                                        <td>{{ $dweight->factor }} Points</td>
                                        @foreach ( $months as $month )
                                        <td>{{ $master[$month][$dweight->factor]['dpv']}}</td>
                                        @endforeach
                                        <td>{{ $master[$dweight->factor]['totaldpv']}} </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td>Total No. Of Defects</td>
                                        @foreach ( $months as $month )
                                        <td>{{ $sumdefects[$month]}}</td>
                                        @endforeach
                                        <td>{{ $totaldefects }}</td>
                                        

                                    </tr>
                                    <tr>
                                        <td>Total No. Paint  Defects</td>
                                        @foreach ( $months as $month )
                                        <td>{{ $sumpdefects[$month]}}</td>
                                        @endforeach
                                        <td>{{ $totalpdefects}}</td>

                                    </tr>
                                    <tr>
                                        <td>Total No. Vehicle Audited</td>
                                        @foreach ( $months as $month )
                                        <td>{{  (!empty($sumpvehivle[$month]) >0 ) ? count(array_unique($sumpvehivle[$month])) : 0}}</td>
                                        @endforeach

                                    </tr>
                                    <tr>
                                        <td>Plant DPV</td>
                                        @foreach ( $months as $month )
                                        @php
                                            $vehicle_audited = (!empty($sumpvehivle[$month]) >0 ) ? count(array_unique($sumpvehivle[$month])) : 0;
                                            $defects=$sumpdefects[$month];
                                            $dpv=0;
                                            if($defects>0){
                                                $dpv=$defects/$vehicle_audited;

                                            }
                                        @endphp

                                        <td>{{ round($dpv)}}</td>
                                        @endforeach

                                    </tr>

                                    <tr>
                                        <td>Plant Paint</td>
                                        @foreach ( $months as $month )
                                        <td>{{ $sumpdefects[$month]}}</td>
                                        @endforeach

                                    </tr>
                                    @foreach ( $dweights as $dweight )
                                    <tr>
                                        <td>{{ $dweight->factor }} Points</td>
                                        @foreach ( $months as $month )
                                        <td>{{ $master[$month][$dweight->factor]['paint']}}</td>
                                        @endforeach

                                    </tr>
                                    @endforeach

                                    
                                </tbody>
                            
                            </table>
                        </div>
                          
                           
                     
                     
    
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

@endsection
@section('after-styles')
{{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
   {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
{{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
 {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
 {{ Html::style('assets/libs/select2/dist/css/select2-bootstrap.css') }}
 {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}

@endsection

@section('after-scripts')
{{ Html::script('assets/libs/datepicker/datepicker.min.js') }}
{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
{{ Html::script('dist/js/pages/contact/contact.js') }}
{{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
    {!! Toastr::message() !!}
    <style>
    
    
        .datepicker{z-index:9999 !important}
    </style>

<script type="text/javascript">
     $(".select2").select2({
                   theme: "bootstrap",
                   width: '100%',
                   dropdownAutoWidth: true,
                   allowClear: true,
               });

//$(".select2").select2();

//MARK ATTENDANCE PAGE
$(function(){
    'use strict'
  

    var today = new Date();
$(".customedate").datepicker({
    showDropdowns: true,
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years",
    maxDate: today,
    }).on('changeDate', function(e){
$(this).datepicker('hide');
});


});
</script>
@endsection

