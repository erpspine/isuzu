@extends('layouts.app')
@section('title', 'FCA Dashboard')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Make GCA Dashboard </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Create</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">
        <div class="content-header row pb-1">
            <div class="content-header-left col-md-6 col-12 mb-2">
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'filterfcaboard', 'class' => '', 'role' => 'form', 'method' => 'get', 'id' => 'filter-qrcode', 'files' => false]) }}
                    @php
                        $sdate = null;
                        $custom_date = 'custom_date';
                        if (isset($selected_date)) {
                            $sdate = $selected_date;
                            $custom_date = '';
                        }
                    @endphp
                    <div class="row">
                        <div class="col-md-3">
                            <label for="lot">Select Date</label>
                            {!! Form::text('date', $sdate, [
                                'id' => 'datepickers',
                                'class' => 'form-control custom-select ' . $custom_date . '',
                                'placeholder' => 'Select lot',
                            ]) !!}
                        </div>
                        <div class="col-md-3 p-4">
                            {{ Form::submit('Get Record', ['class' => 'btn btn-primary btn-md ']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @php
                        //print_r($data);
                    @endphp
                    @if (isset($selected_date))
                        <div class="card-body">
                            {{ Form::open(['route' => 'fcaboard.store', 'class' => '', 'role' => 'form', 'method' => 'post', 'id' => 'create-report', 'files' => false]) }}
                            {!! Form::hidden('date', $selected_date) !!}
                            <div class="row bg-primary text-white pb-2">
                                <div class="col-md-2">
                                    <label for="lot">Drl</label>
                                    {!! Form::text('drl', drl_today($sdate)['drl'], [
                                        'id' => 'drr',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Drl',
                                    ]) !!}
                                </div>
                                <div class="col-md-2">
                                    <label for="lot">Drl Target</label>
                                    {!! Form::text('drl_target', drl_today($sdate)['drl_target_value'], [
                                        'id' => 'drl',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Drl Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-2">
                                    <label for="lot">Drr </label>
                                    {!! Form::text('drl_target', today_drr($sdate)['plant_drr'], [
                                        'id' => 'drl_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Drr',
                                    ]) !!}
                                </div>
                                <div class="col-md-2">
                                    <label for="lot">Drr Target</label>
                                    {!! Form::text('drr_target', today_drr($sdate)['drr_target_value'], [
                                        'id' => 'drr_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Drr Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-2">
                                    <label for="lot">Care </label>
                                    {!! Form::text('care', today_drr($sdate)['care'], [
                                        'id' => 'care',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care',
                                    ]) !!}
                                </div>
                                <div class="col-md-2">
                                    <label for="lot">Care Target</label>
                                    {!! Form::text('care_target', 100, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row  mt-1 bg-warning text-white pb-2">
                                <div class="col-md-3">
                                    <label for="lot">DPV CV</label>
                                    {!! Form::text('care_target', $cv_dpvscore, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="lot"> DPV CV Target</label>
                                    {!! Form::text('care_target', $cvdpvtarget, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="lot">DPV LCV</label>
                                    {!! Form::text('care_target', $lcv_dpvscore, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="lot">DPV LCV Target</label>
                                    {!! Form::text('care_target', $lcvdpvtarget, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                            </div>
                            <div class="row mt-1 bg-info text-white pb-2">
                                <div class="col-md-3">
                                    <label for="lot">WDPV CV</label>
                                    {!! Form::text('care_target', $cv_wdpvscore, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="lot">WDPV CV Target </label>
                                    {!! Form::text('care_target', $cvwdpvtarget, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="lot">WDPV LCV</label>
                                    {!! Form::text('care_target', $lcv_wdpvscore, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                                <div class="col-md-3">
                                    <label for="lot">WDPV LCV Target</label>
                                    {!! Form::text('care_target', $lcvwdpvtarget, [
                                        'id' => 'care_target',
                                        'class' => 'form-control custom-select',
                                        'placeholder' => 'Care Target',
                                    ]) !!}
                                </div>
                            </div>
							 <div class="card-body">
                                <div class="box-body">
                                    <h2 class="text-center text-primary">DRR DEFECTS</h2>
                                    <div class="row">
                                        <div class="col-sm-12 col-sm-offset-2">
                                            <table class="table table-bordered table-striped table-condensed"
                                                id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th>Check</th>
                                                        <th >Query</th>
                                                        <th >Defect</th>
                                                        <th >Shop Captured</th>
                                                        <th >Weight</th>
                                                        <th >Lot & Job</th>
                                                        <th >Model</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle_data">
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($drr_defects as $defect)
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="mb-2">
                                                                    {!! Form::checkbox('drr_check[]', $defect->id, false, [
                                                                        'class' => 'material-inputs chk-col-cyan',
                                                                        'id' => 'drr_check' . $i . '',''.$drr_check[$defect->id].'',
                                                                    ]) !!}
                                                                    <label for="drr_check{{ $i }}"></label>
                                                                </div>
                                                            </td>
                                                            <td>{{ $defect->getqueryanswer->routing->query_name }}</td>
                                                            <td><input type="text" value="{{ (!empty($drr_defect[$defect->id])) ? $drr_defect[$defect->id] : $defect->defect_name}}  " class="form-control"
                                                                name="drr_defect[{{ $defect->id }}]"  id="drr_defect-0{{ $i }}">
                                                                
        
                                                           </td>
                                                            <td>
                                                                {{ $defect->getqueryanswer->shop->shop_name }}
                                                            </td>
                                                            <td>
                                                                {{ $defect->value_given }}
                                                            </td>
                                                            <td>Lot: {{ $defect->getqueryanswer->vehicle->lot_no }} Job:
                                                                {{ $defect->getqueryanswer->vehicle->job_no }}</td>
                                                            <td>{{ $defect->getqueryanswer->vehicle->model->model_name }}
                                                            </td>
                                
                                                            {!! Form::hidden('drr_shop['.$defect->id.']', $defect->getqueryanswer->shop->shop_name) !!}
                                                            {!! Form::hidden('drr_weight['.$defect->id.']',$defect->value_given) !!}
                                                            {!! Form::hidden('drr_lot_job['.$defect->id.']', 'Lot: '.$defect->getqueryanswer->vehicle->lot_no.' Job: '.$defect->getqueryanswer->vehicle->job_no) !!}
                                                            {!! Form::hidden('drr_model['.$defect->id.']', $defect->getqueryanswer->vehicle->model->model_name) !!}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body ">
                                <div class="box-body">
                                    <h2 class="text-center text-primary">DRL DEFECTS</h2>
                                    <div class="row">
                                        <div class="col-sm-12 col-sm-offset-2">
                                            <table class="table table-bordered table-striped table-condensed"
                                                id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th>Check</th>
                                                        <th>Query</th>
                                                        <th>Defect</th>
                                                        <th>Shop Captured</th>
                                                        <th>Weight</th>
                                                        <th>Lot & Job</th>
                                                        <th>Model</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle_data">
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($defects as $defect)
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="mb-2">
                                                                    {!! Form::checkbox('drl_check[]',$defect->id, false, [
                                                                        'class' => 'material-inputs chk-col-cyan',
                                                                        'id' => 'drl_check_' . $i . '',''.$drl_check[$defect->id].'',
                                                                    ]) !!}
                                                                    <label for="drl_check_{{ $i }}"></label>
                                                                </div>
                                                            </td>
                                                            <td>{{ $defect->getqueryanswer->routing->query_name }}</td>
                                                            <td><input type="text" value="{{ (!empty($drl_defect[$defect->id])) ? $drl_defect[$defect->id] : $defect->defect_name}}  " class="form-control"
                                                                name="drl_defect[{{ $defect->id }}]"  id="drl_defect-0{{ $i }}">
                                                                
                                                                
                                                               </td>
                                                            <td>
                                                                {{ $defect->getqueryanswer->shop->shop_name }}
                                                            </td>
                                                            <td>
                                                                {{ $defect->value_given }}
                                                            </td>
                                                            <td>Lot: {{ $defect->getqueryanswer->vehicle->lot_no }} Job:
                                                                {{ $defect->getqueryanswer->vehicle->job_no }}</td>
                                                            <td>{{ $defect->getqueryanswer->vehicle->model->model_name }}
                                                            </td>
                                                          
                                                            {!! Form::hidden('drl_shop['.$defect->id.']', $defect->getqueryanswer->shop->shop_name) !!}
                                                            {!! Form::hidden('drl_weight['.$defect->id.']',$defect->value_given) !!}
                                                            {!! Form::hidden('drl_lot_job['.$defect->id.']', 'Lot: '.$defect->getqueryanswer->vehicle->lot_no.' Job: '.$defect->getqueryanswer->vehicle->job_no) !!}
                                                            {!! Form::hidden('drl_model['.$defect->id.']', $defect->getqueryanswer->vehicle->model->model_name) !!}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           
                            <div class="card-body">
                                <div class="box-body">
                                    <h2 class="text-center text-primary">CARE DEFECTS</h2>
                                    <div class="row">
                                        <div class="col-sm-12 col-sm-offset-2">
                                            <table class="table table-bordered table-striped table-condensed"
                                                id="product_table">
                                                <thead>
                                                    <tr>
                                                        <th>Check</th>
                                                        <th >Query</th>
                                                        <th >Defect</th>
                                                        <th >Shop Captured</th>
                                                        <th >Weight</th>
                                                        <th >Lot & Job</th>
                                                        <th >Model</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="vehicle_data">
                                                    @php
                                                        $i = 0;
                                                    @endphp
                                                    @foreach ($care as $defect)
                                                        @php
                                                            $i++;
                                                        @endphp
                                                        <tr>
                                                            <td>
                                                                <div class="mb-2">
                                                                    {!! Form::checkbox('care_check[]', $defect->id, false, [
                                                                        'class' => 'material-inputs chk-col-cyan',
                                                                        'id' => 'care_check' . $i . '',''.$care_check[$defect->id].'', 
                                                                    ]) !!}
                                                                    <label for="care_check{{ $i }}"></label>
                                                                </div>
                                                            </td>
                                                            <td>{{ $defect->getqueryanswer->routing->query_name }}</td>
                                                            <td><input type="text" value="{{ (!empty($care_defect[$defect->id])) ? $care_defect[$defect->id] : $defect->defect_name}}  " class="form-control"
                                                                name="care_defect[{{ $defect->id }}]"  id="care_defect-0{{ $i }}">
                                                                
                                    
                                                                
                                                                
                                                               </td>
                                                            <td>
                                                                {{ $defect->getqueryanswer->shop->shop_name }}
                                                            </td>
                                                            <td>
                                                                {{ $defect->value_given }}
                                                            </td>
                                                            <td>Lot: {{ $defect->getqueryanswer->vehicle->lot_no }} Job:
                                                                {{ $defect->getqueryanswer->vehicle->job_no }}</td>
                                                            <td>{{ $defect->getqueryanswer->vehicle->model->model_name }}
                                                            </td>
                                                          
                                                            {!! Form::hidden('care_shop['.$defect->id.']', $defect->getqueryanswer->shop->shop_name) !!}
                                                            {!! Form::hidden('care_weight['.$defect->id.']',$defect->value_given) !!}
                                                            {!! Form::hidden('care_lot_job['.$defect->id.']', 'Lot: '.$defect->getqueryanswer->vehicle->lot_no.' Job: '.$defect->getqueryanswer->vehicle->job_no) !!}
                                                            {!! Form::hidden('care_model['.$defect->id.']', $defect->getqueryanswer->vehicle->model->model_name) !!}
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="box-body">
                                    <h2 class="text-center text-primary">CV GCA DEFECTS</h2>
                                    <div class="row">
                                        <div class="col-sm-12 col-sm-offset-2 saman-row-gca">
                                            <table class="table table-bordered table-striped table-condensed"
                                                id="gca_table">
                                                <thead>
                                                    <tr>
                                                        <th >Defect</th>
                                                        <th >Shop Captured</th>
                                                        <th>Weight</th>
                                                        <th >Lot & Job</th>
                                                        <th >Model</th>
                                                        <th >X</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @if (count($gca_cv)>0)
                                                    @php
                                                        $i=0;
                                                    @endphp
                                                    @foreach ( $gca_cv as $row)
                                                    @php
                                                      $i++;  
                                                    @endphp
                                                    <tr>
                                                        <td><input type="text" class="form-control"
                                                                name="gca_defect[]" value="{{ $row->defect}}" required id="gca_defect-{{ $i }}"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="shop_captured[]" value="{{ $row->shop}}"  required id="shop_captured-{{ $i }}"></td>
                                                        <td><input type="text" class="form-control" value="{{ $row->weight}}" required name="weight[]"
                                                                id="weight-{{ $i }}"></td>
                                                        <td><input type="text" class="form-control" value="{{ $row->lot_job}}"  required name="lot_job[]"
                                                                id="lot_job-{{ $i }}"></td>
                                                        <td><input type="text" class="form-control" value="{{ $row->model}}" required name="model[]"
                                                                id="model-{{ $i }}"></td>
                                                                <td><button class="btn btn-danger v_delete_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>
                                                        
                                                    </tr>
                                                        
                                                    @endforeach
                                                
                                                    
                                                        
                                                    @else

                                                    <tr>
                                                        <td><input type="text" class="form-control"
                                                                name="gca_defect[]" required id="gca_defect-0"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="shop_captured[]" required id="shop_captured-0"></td>
                                                        <td><input type="text" class="form-control" required name="weight[]"
                                                                id="weight-0"></td>
                                                        <td><input type="text" class="form-control" required name="lot_job[]"
                                                                id="lot_job-0"></td>
                                                        <td><input type="text" class="form-control" required name="model[]"
                                                                id="model-0"></td>
                                                                <td><button class="btn btn-danger v_delete_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>
                                                        
                                                    </tr>
                                                        
                                                    @endif
                                                  
                                                    <tr class="last-item-row-gca sub_c">
                                                        <td class="add-row">
                                                            <button type="button" class="btn btn-info"
                                                                aria-label="Left Align" id="add-item">
                                                                <i class="fa fa-plus-square"></i> Add Another Item
                                                            </button>
                                                        </td>
                                                        <td colspan="5"></td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="box-body">
                                    <h2 class="text-center text-primary">LCV GCA DEFECTS</h2>
                                    <div class="row">
                                        <div class="col-sm-12 col-sm-offset-2 saman-row-lcv-gca">
                                            <table class="table table-bordered table-striped table-condensed"
                                                id="lcv_gca_table">
                                                <thead>
                                                    <tr>
                                                        <th >Defect</th>
                                                        <th>Shop Captured</th>
                                                        <th>Weight</th>
                                                        <th>Lot & Job</th>
                                                        <th>Model</th>
                                                        <th>X</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    @if (count($gca_lcv)>0)
                                                    @php
                                                        $m=0;
                                                    @endphp
                                                    @foreach ( $gca_lcv as $row)
                                                    @php
                                                      $m++;  
                                                    @endphp

<tr>
    <td><input type="text" class="form-control"
            name="lcv_gca_defect[]" value="{{ $row->defect}}" required id="lcv_gca_defect-{{ $m }}"></td>
    <td><input type="text" class="form-control"
            name="lcv_shop_captured[]" value="{{ $row->shop}}" required id="shop_captured-{{ $m }}"></td>
    <td><input type="text" class="form-control" value="{{ $row->weight}}" required name="lcv_weight[]"
            id="lcv_weight-{{ $m }}"></td>
    <td><input type="text" class="form-control" value="{{ $row->lot_job}}"  required name="lcv_lot_job[]"
            id="lcv_lot_job-{{ $m }}"></td>
    <td><input type="text" class="form-control" value="{{ $row->model}}" required name="lcv_model[]"
            id="lcv_model-{{ $m }}"></td>
            <td><button class="btn btn-danger v_delete_lcv_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>
    
</tr>



                                                     @endforeach
                                                     @else
                                                     <tr>
                                                        <td><input type="text" class="form-control"
                                                                name="lcv_gca_defect[]" required id="lcv_gca_defect-0"></td>
                                                        <td><input type="text" class="form-control"
                                                                name="lcv_shop_captured[]" required id="shop_captured-0"></td>
                                                        <td><input type="text" class="form-control" required name="lcv_weight[]"
                                                                id="lcv_weight-0"></td>
                                                        <td><input type="text" class="form-control" required name="lcv_lot_job[]"
                                                                id="lcv_lot_job-0"></td>
                                                        <td><input type="text" class="form-control" required name="lcv_model[]"
                                                                id="lcv_model-0"></td>
                                                                <td><button class="btn btn-danger v_delete_lcv_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>
                                                        
                                                    </tr>

                                                     @endif



                                                
                                                    <tr class="last-item-row-lcv-gca sub_c">
                                                        <td class="add-row">
                                                            <button type="button" class="btn btn-info"
                                                                aria-label="Left Align" id="add-item-lcv">
                                                                <i class="fa fa-plus-square"></i> Add Another Item
                                                            </button>
                                                        </td>
                                                        <td colspan="5"></td>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="form-group mb-0 text-right">
                                    <input type="hidden" value="{{ count($gca_cv) }}" name="counter" id="rowganak">
                                    <input type="hidden" value="{{ count($gca_lcv) }}" name="counter" id="rowganaklcv">
                                    <button type="submit" class="btn btn-info waves-effect waves-light">Save</button>
                                    <button type="submit" class="btn btn-dark waves-effect waves-light">Cancel</button>
                                </div>
                            </div>
                            {{ Form::close() }}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('after-styles')
    {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
@endsection
@section('after-scripts')
    {{ Html::script('assets/libs/datepicker/datepicker.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
    {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
    {{ Html::script('assets/libs/x-editable/dist/js/bootstrap-editable.js') }}
    <script type="text/javascript">
        $(document).ready(function() {
            //Add products
            if ($('#search_product_for_label').length > 0) {
                $('#search_product_for_label')
                    .autocomplete({
                        source: 'get_units',
                        minLength: 2,
                        response: function(event, ui) {
                            if (ui.content.length == 1) {
                                ui.item = ui.content[0];
                                $(this)
                                    .data('ui-autocomplete')
                                    ._trigger('select', 'autocompleteselect', ui);
                                $(this).autocomplete('close');
                            } else if (ui.content.length == 0) {
                                Swal.fire("Unit Not Found!");
                                //swal('LANG.no_products_found');
                            }
                        },
                        select: function(event, ui) {
                            $(this).val(null);
                            get_label_product_row(ui.item.id);
                        },
                    })
                    .autocomplete('instance')._renderItem = function(ul, item) {
                        //console.log(item);
                        return $('<li>')
                            .append('<div>Lot No:' + item.lot_no + ' Job No:' + item.job_no + ' Chasis:' + item
                                .vin_no + '</div>')
                            .appendTo(ul);
                    };
            }
            $('input#is_show_price').change(function() {
                if ($(this).is(':checked')) {
                    $('div#price_type_div').show();
                } else {
                    $('div#price_type_div').hide();
                }
            });
            $('button#labels_preview').click(function() {
                if ($('form#preview_setting_form table#product_table tbody tr').length > 0) {
                    var url = base_path + '/labels/preview?' + $('form#preview_setting_form').serialize();
                    window.open(url, 'newwindow');
                    // $.ajax({
                    //     method: 'get',
                    //     url: '/labels/preview',
                    //     dataType: 'json',
                    //     data: $('form#preview_setting_form').serialize(),
                    //     success: function(result) {
                    //         if (result.success) {
                    //             $('div.display_label_div').removeClass('hide');
                    //             $('div#preview_box').html(result.html);
                    //             __currency_convert_recursively($('div#preview_box'));
                    //         } else {
                    //             toastr.error(result.msg);
                    //         }
                    //     },
                    // });
                } else {
                    swal(LANG.label_no_product_error).then(value => {
                        $('#search_product_for_label').focus();
                    });
                }
            });
            $(document).on('click', 'button#print_label', function() {
                window.print();
            });
        });

        function get_label_product_row(unit_id) {
            if (unit_id) {
                var row_count = $('table#product_table tbody tr').length;
                $.ajax({
                    method: 'GET',
                    url: '{{ route('add_unit_row') }}',
                    dataType: 'html',
                    data: {
                        unit_id: unit_id,
                        row_count: row_count
                    },
                    success: function(result) {
                        $('table#product_table tbody').append(result);
                    },
                });
            }
        }
        $(document).on('click', ".v_delete_temp", function(e) {
            e.preventDefault();
            $(this).closest('tr').remove();
        });
        $("#lot_no").on('change', function() {
            $("#job_no").val('').trigger('change');
            // var lot_no = $(this).val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#job_no").select2({
                ajax: {
                    url: '{{ route('loadbyjob') }}',
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 10,
                    data: {
                        lot_no: $(this).val(),
                    },
                    processResults: function(data) {
                        console.log(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.model.model_name + ' - ' + item.job_no,
                                    id: item.id
                                }
                            })
                        };
                    },
                }
            });
        });
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $('#vehicle_data').editable({
                container: 'body',
                selector: 'td.traceable',
                validate: function(value) {
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    }
                },
                success: function(response, newValue) {
                    console.log('Updated', response)
                }
            });
        })
        var today = new Date();
        $("#datepickers").datepicker({
            autoHide: true,
            format: "dd-mm-yyyy",
        });
        $('.custom_date').datepicker('setDate', 'today');
        $('#add-item').on('click', function() {
            var cvalue = parseInt($('#rowganak').val()) + 1;
            var nxt = parseInt(cvalue);
            $('#rowganak').val(nxt);
            var functionNum = "'" + cvalue + "'";
            count = $('#saman-row-gca div').length;
            //product row
            var data =
                '<tr><td><input type="text" class="form-control" name="gca_defect[]" required id="gca_defect-' + cvalue +
                '" ></td> <td><input type="text" class="form-control" required name="shop_captured[]" id="shop_captured-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="weight[]" id="weight-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="lot_job[]" id="lot_job-' +
                cvalue + '" ></td><td><input type="text" class="form-control" required name="model[]" id="model-' + cvalue +
                '" ></td> <td><button class="btn btn-danger v_delete_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>  </tr>';
            //ajax request
            // $('#saman-row').append(data);
            $('tr.last-item-row-gca').before(data);
        });
        $('#add-item-lcv').on('click', function() {
            var cvalue = parseInt($('#rowganaklcv').val()) + 1;
            var nxt = parseInt(cvalue);
            $('#rowganaklcv').val(nxt);
            var functionNum = "'" + cvalue + "'";
            count = $('#saman-row-lcv-gca div').length;
            //product row
            var data =
                '<tr><td><input type="text" class="form-control" name="lcv_gca_defect[]" required id="lcv_gca_defect-' + cvalue +
                '" ></td> <td><input type="text" class="form-control" required name="lcv_shop_captured[]" id="lcv_shop_captured-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="lcv_weight[]" id="lcv_weight-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="lcv_lot_job[]" id="lcv_lot_job-' +
                cvalue + '" ></td><td><input type="text" class="form-control" required name="lcv_model[]" id="lcv_model-' + cvalue +
                '" ></td> <td><button class="btn btn-danger v_delete_lcv_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>  </tr>';
            //ajax request
            // $('#saman-row').append(data);
            $('tr.last-item-row-lcv-gca').before(data);
        });
        $(document).on("click", ".v_delete_gca", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Remove This  Item  From List?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove!',
            }).then((willDelete) => {
                if (willDelete.value) {
                    $(this).closest("tr").remove(); // remove row
                } else {
                    Swal.fire('Item Not Removed!!', '', 'info')
                }
            });
        });

        $(document).on("click", ".v_delete_lcv_gca", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Remove This  Item  From List?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove!',
            }).then((willDelete) => {
                if (willDelete.value) {
                    $(this).closest("tr").remove(); // remove row
                } else {
                    Swal.fire('Item Not Removed!!', '', 'info')
                }
            });
        });

        $(document).on('submit', 'form#create-report', function(e){
            e.preventDefault();
            $("#submit-data").hide();
            var data = $(this).serialize();
            $.ajax({
                method: "post",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                success:function(result){
                    if(result.success == true){
                     
                        toastr.success(result.msg);
                        location.href = '{{ route("fcaboard.index") }}';
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });
    </script>
@endsection
