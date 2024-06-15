@section('title','Gca Pre-Week Report')
@extends('layouts.app')

@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">SAMPLE SIZE REPORT</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">SAMPLE SIZE REPORT</li>
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
                    {{ Form::open(['route' => 'gcasamplesize', 'class' => '', 'role' => 'form', 'method' => 'get', 'id' => 'create-report', 'files' => false]) }}


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
                        GCA Sample Size Date <span class="text-success">{{ $date }}</span>
                   
                    <div class="card-body">
                        
                       
                        <div class="row">
                            <table class="table table-orange">
                                <thead>
                                    <tr class="table-light">
                                        <th >Week</th>
                                        <th>Date</th>
                                        <th colspan="3">Production Volume</th>
                                        <th>Gca Req.</th>
                                        <th colspan="4">Sample Vehicle</th>
                                    </tr>
                                    <tr class="table-light">
                                        <th ></th>
                                        <th></th>
                                        <th>TOTAL</th>
                                        @foreach ( $vehicletypes as $vehicletype )
                                        <th>{{ $vehicletype->vehicle_name }}</th>
                                        @endforeach
                                        <th>GCA REQ.</th>
                                        <th>TOTAL</th>
                                        @foreach ( $vehicletypes as $vehicletype )
                                        <th>{{ $vehicletype->vehicle_name }}</th>
                                        @endforeach
                                        <th>STATUS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                   
                                    $ptotal=0;
                                  
                                   @endphp
                                    @for ($i = 1; $i < 5; $i++) 
                                    <tr>
                                        <td rowspan="8">Week {{ $i }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    
                                      
                                      
                                    </tr>
                                 
                                   
                                    @for ($m = 0; $m <= 6; $m++) 
                                    @php
                                    $ptotal+=$master[$i]['productionday'][$m];
                                    $date= $master[$i]['datesarray'][$m];
                                   @endphp
                                    <tr>
                                        <td>{{   $date }}</td>
                                        <td>{{  $sumitemrray[$date]}}</td>
                                        @foreach ( $vehicletypes as $vehicletype )
                                        <td>{{ $master[$i][$vehicletype->id]['typetotal'][$m] }}</td>
                                        @endforeach
                                        <td>{{ $master[$i]['productionday'][$m] }}</td>
                                        <td>{{ $master[$i]['totalunitssampled'][$m] }}</td>
                                        @foreach ( $vehicletypes as $vehicletype )
                                        <td>{{ $master[$i][$vehicletype->id]['unitssampled'][$m] }}</td>
                                        @endforeach
                                        <td>{{ $master[$i]['totalunitssampled'][$m] <  $master[$i]['productionday'][$m] ? "NOK" : "OK" }}</td>
                                      
                                    </tr>
                                    @endfor
                                    @endfor
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="2">Total</th>
                                        <th>{{ $gtotal }}</th>
                                        @foreach ($vehicletypes as $vehicletype )
                                        <th>{{ $sumatyperray[$vehicletype->id] }}</th>
                                        @endforeach
                                        <th>{{ $ptotal }}</th>
                                        <th>{{ $stotal }}</th>
                                        @foreach ($vehicletypes as $vehicletype )
                                        <th>{{  $sumtsampledrray[$vehicletype->id] }}</th>
                                        @endforeach
                                        <th>{{ $stotal <  $ptotal ? "NOK" : "OK" }}</th>
                                    </tr>
                                </tfoot>
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
{{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
 {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
 {{ Html::style('assets/libs/select2/dist/css/select2-bootstrap.css') }}

@endsection

@section('after-scripts')
{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
{{ Html::script('dist/js/pages/contact/contact.js') }}
    {!! Toastr::message() !!}


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
    $('.customedate').daterangepicker({
    singleDatePicker: true,
    showDropdowns: true,
    dateFormat: 'dd/mm/yy',
    //maxDate: today,
   
    });
});
</script>
@endsection

