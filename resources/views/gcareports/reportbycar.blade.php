@section('title','Report By car Number')
@extends('layouts.app')

@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">REPORT BY CAR NUMBER </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">REPORT BY CAR </li>
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
        $carnumber=null;
    if(isset($date)){
        $dateselected =$date;
        $vehicle_type=$vtpype;
        $carnumber=$cnumber;

    }
@endphp
    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-cyan mb-2">
                    {{ Form::open(['route' => 'reportbycar', 'class' => '', 'role' => 'form', 'method' => 'get', 'id' => 'create-report', 'files' => false]) }}


                                <div class="row">
                                    <div class="col-md-3">
                                        <div class='input-group'>
                                            {!! Form::select('vehicle_type', ['cv'=>'cv','lcv'=>'lcv'], $vehicle_type, [
                                                'placeholder' => 'Select Vehicle Type',
                                                'class' => 'form-control custom-select select2',
                                            ]) !!}


                                         
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class='input-group'>
                                            {!! Form::select('car_number', ['1'=>'1','2'=>'2'], $carnumber, [
                                                'placeholder' => 'Select Vehicle No',
                                                'class' => 'form-control custom-select select2',
                                            ]) !!}
                                         
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class='input-group'>
                                            <input type='text' value="{{ $dateselected }}" name="date" class="form-control customedate" />

                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <span class="ti-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
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
                        Report For Car Number: <span class="text-success">{{ $cnumber }}</span> Date: <span class="text-success">{{ $date }}</span>
                    <div class="card-body">
                        <div class="row">
                            <table class="table table-orange">
                                <thead>
                                    <tr class="table-light">
                                        <th >Description</th>
                                        <th>Category</th>
                                        <th >Plant </th>
                                        <th>MA</th>
                                        <th>Dev</th>
                                    </tr>
                              
                                </thead>
                                <tbody>
                               
                                 @foreach ( $datas as $data )
                                     
                                    <tr>
                                        <td>{{ $data->defect }} {{ $data->defect_tag}}</td>
                                        <td>{{ $data->category->short_form }}</td>
                                        <td>{{ $data->weight }}</td>
                                        <td>{{ $data->weight }}</td>
                                        <td>0.0</td>
                                    
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th rowspan="2">Total</th>
                                        <th>WDPV </th>
                                        <th>{{ $wdpv }}</th>
                                        <th>{{ $wdpv }}</th>
                                        <th>0.0</th>
                                    
                                    </tr>
                                    <tr>
                                        <th>DPV</th>
                                        <th>{{ $dpv }}</th>
                                        <th>{{ $dpv }}</th>
                                        <th>0.0</th>
                                        
                                    
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                            <div class="row">

                                <table class="table table-success">
                                    <thead>
                                        <tr class="table-light">
                                            <th >Category</th>
                                            <th >DPV</th>
                                            <th>WDPV</th>
                                            @foreach ($dweights as $dweight )
                                            <th >{{ $dweight->factor }} </th>
                                            @endforeach
                                          
                                          
                                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($auditcategories as $auditcategory )
                                        <tr>
                                            <td>{{ $auditcategory->name }}</td>
                                            <td>{{ $sumtdpv[$auditcategory->id] }}</td>
                                            <td>{{ $sumwdpv[$auditcategory->id] }}</td>
                                            @foreach ($dweights as $dweight )
                                            <td >{{  $master[$dweight->factor][$auditcategory->id]['wdpvdpv'] }} </td>
                                            @endforeach

                                        </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>Total</th>
                                            <th>{{ $sumgdpv }} </th>
                                            <th>{{ $sumgwpv }} </th>
                                            @foreach ($dweights as $dweight )
                                            <th >{{  $sumgwdpv[$dweight->factor] }} </th>
                                            @endforeach

                                         
                                        
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

