@extends('layouts.app')
@section('title', 'Gca Audit Checksheet')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Gca Audit Checksheet</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Create </li>
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
                        @include('gcachecksheet.partial.gcachecksheet-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => 'gca-checksheet.create', 'class' => 'form-horizontal', 'files' => true, 'role' => 'form', 'method' => 'get']) }}
                        <div class="row mb-5">
                            <div class="col-md-3">
                                <input type="checkbox" name="has_size" id="md_checkbox_1"
                                    class="material-inputs chk-col-blue" {{ isset($data['has_size']) ? 'checked' : '' }} />
                                <label for="md_checkbox_1">Has Size</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="has_description" id="md_checkbox_2"
                                    class="material-inputs chk-col-blue"
                                    {{ isset($data['has_description']) ? 'checked' : '' }} />
                                <label for="md_checkbox_2">Has Description</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="has_quality" id="md_checkbox_3"
                                    class="material-inputs chk-col-blue"
                                    {{ isset($data['has_quality']) ? 'checked' : '' }} />
                                <label for="md_checkbox_3">Has Quality</label>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group row">
                                    <label class="control-label text-right col-md-4">Zones</label>
                                    <div class="col-md-8">
                                        {!! Form::select(
                                            'zone_type',
                                            [
                                                'No-Zones' => 'No-Zones',
                                                'Exterior-Interior' => 'Exterior-Interior',
                                                'ExteriorAB-Interior' => 'ExteriorAB-Interior',
                                                'ABCD' => 'ABCD',
                                                'Fluid-Level' => 'Fluid-Level',
                                                'Noise' => 'Noise',
                                                'Safety' => 'Safety',
                                            ],
                                            isset($data['zone_type']) ? $data['zone_type'] : null,
                                            [
                                                'class' => 'select2 form-control custom-select',
                                                'placeholder' => 'Zone Type',
                                                'style' => 'height: 25px;width: 100%;',
                                                'required' => 'required',
                                            ],
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <div class="row">
                            <!--/span-->
                            <div class="col-md-6">
                                <div class="form-group row">
                                    {{ Form::submit('Set Routings', ['class' => 'btn btn-info btn-md']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <hr>
                        @if (isset($data))
                            {{ Form::open(['route' => 'gca-checksheet.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-checksheet']) }}
                            {!! Form::hidden('has_size', isset($data['has_size']) ? '1' : '0') !!}
                            {!! Form::hidden('has_description', isset($data['has_description']) ? '1' : '0') !!}
                            {!! Form::hidden('has_quality', isset($data['has_quality']) ? '1' : '0') !!}
                            {!! Form::hidden('zone_type', $data['zone_type']) !!}
                            <div class="row">
                                <!--/span-->
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4">Name</label>
                                        <div class="col-md-8">
                                            {!! Form::text('category_name', null, [
                                                'placeholder' => 'Name',
                                                'class' => 'form-control',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4">Vehicle Type</label>
                                        <div class="col-md-8">
                                            {!! Form::select('vehicle_type', ['1' => 'Light Commercial', '2' => 'Heavy Commercial'], null, [
                                                'placeholder' => 'Select Vehicle Type',
                                                'class' => 'form-control custom-select ',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group row">
                                        <label class="control-label text-right col-md-4">Category</label>
                                        <div class="col-md-8">
                                            {!! Form::select('gca_audit_report_category_id', $gcacat, null, [
                                                'class' => 'select2 form-control custom-select',
                                                'placeholder' => 'Select Category',
                                                'required' => 'required',
                                            ]) !!}
                                        </div>
                                    </div>
                                </div>
                                <!--/span-->
                            </div>
                            <div class="table-responsive">
                                <table class="table" id="defectlist">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Defect&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                            <th>Tags&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            </th>
                                            <th class="{{ isset($data['has_size']) ? '' : 'hide' }}"> Size&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th class="{{ isset($data['has_description']) ? '' : 'hide' }}">
                                                Description&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th class="{{ isset($data['has_quality']) ? '' : 'hide' }}"> Quantity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            @if ($data['zone_type'] == 'ABCD')
                                                <th>Zone&nbsp;&nbsp;A</th>
                                                <th>Zone&nbsp;&nbsp;B</th>
                                                <th>Zone&nbsp;&nbsp;C</th>
                                                <th>Zone&nbsp;&nbsp;D</th>
                                            @elseif($data['zone_type'] == 'Exterior-Interior')
                                                <th>Exterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th>Interior&nbsp;&nbsp;Primary</th>
                                                <th>Interior&nbsp;&nbsp;Secondary </th>
                                            @elseif($data['zone_type'] == 'ExteriorAB-Interior')
                                                <th>Exterior A&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th>Exterior B&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th>Interior&nbsp;&nbsp;Primary</th>
                                                <th>Interior&nbsp;&nbsp;Secondary </th>
                                            @elseif($data['zone_type'] == 'No-Zones')
                                                <th>Weight Factor</th>
                                            @elseif($data['zone_type'] == 'Fluid-Level')
                                                <th>10mm&nbsp;&nbsp;above&nbsp;&nbsp;Maximum</th>
                                                <th>5mm&nbsp;&nbsp;above&nbsp;&nbsp;Maximum</th>
                                                <th>Below&nbsp;&nbsp;Min</th>
                                                <th>Not&nbsp;&nbsp;Visible</th>
                                                <th>Any&nbsp;&nbsp;Leak</th>
                                                <th>Incorrect&nbsp;&nbsp;Fluid</th>
                                            @elseif($data['zone_type'] == 'Noise')
                                                <th>Slight</th>
                                                <th>Moderate</th>
                                                <th>Loud</th>
                                            @elseif($data['zone_type'] == 'Safety')
                                                <th>L=loose</th>
                                                <th>D=damaged</th>
                                                <th>W=wrong</th>
                                                <th>M=missing</th>
                                                <th>F=function</th>
                                            @endif
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>{!! Form::textarea('defect[]', null, [
                                                'placeholder' => 'Defects',
                                                'id' => 'defects-0',
                                                'class' => 'form-control',
                                                'rows' => '2',
                                                'required' => 'required',
                                            ]) !!}</td>
                                            <td>{!! Form::select('tags[0][]', [], null, [
                                                'class' => 'defect_select form-control',
                                                'id' => 'tags-0',
                                                'aria-describedby' => 'basic-addon1',
                                                'multiple' => 'multiple',
                                            ]) !!} </td>
                                            <td class="{{ isset($data['has_size']) ? '' : 'hide' }}">
                                                {!! Form::text('size[]', null, ['placeholder' => 'Size', 'class' => 'form-control', 'id' => 'size']) !!}</td>
                                            <td class="{{ isset($data['has_description']) ? '' : 'hide' }}">
                                                {!! Form::text('description[]', null, [
                                                    'placeholder' => 'Description',
                                                    'class' => 'form-control',
                                                    'id' => 'description-0',
                                                ]) !!}</td>
                                            <td class="{{ isset($data['has_quality']) ? '' : 'hide' }}">
                                                {!! Form::text('quantity[]', null, [
                                                    'placeholder' => 'Quantity',
                                                    'id' => 'quantity-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                            @if ($data['zone_type'] == 'ABCD')
                                                <td>{!! Form::text('zonea[]', null, ['placeholder' => 'A', 'id' => 'zonea-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('zoneb[]', null, ['placeholder' => 'B', 'id' => 'zoneb-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('zonec[]', null, ['placeholder' => 'C', 'id' => 'zonec-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('zoned[]', null, ['placeholder' => 'D', 'id' => 'zoned-0', 'class' => 'form-control']) !!}</td>
                                            @elseif($data['zone_type'] == 'ExteriorAB-Interior')
                                                <td>{!! Form::text('exterior[]', null, [
                                                    'placeholder' => 'Exterior A',
                                                    'id' => 'exterior-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('exteriorb[]', null, [
                                                    'placeholder' => 'Exterior B',
                                                    'id' => 'exteriorb-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('interiorprimary[]', null, [
                                                    'placeholder' => 'Interior Primary',
                                                    'id' => 'interiorprimary-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('interiorsecondary[]', null, [
                                                    'placeholder' => 'Interior Secondary',
                                                    'id' => 'zonec-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                             @elseif($data['zone_type'] == 'Exterior-Interior')
                                             <td>{!! Form::text('exterior[]', null, [
                                                 'placeholder' => 'Exterior',
                                                 'id' => 'exterior-0',
                                                 'class' => 'form-control',
                                             ]) !!}</td>
                                             <td>{!! Form::text('interiorprimary[]', null, [
                                                 'placeholder' => 'Interior Primary',
                                                 'id' => 'interiorprimary-0',
                                                 'class' => 'form-control',
                                             ]) !!}</td>
                                             <td>{!! Form::text('interiorsecondary[]', null, [
                                                 'placeholder' => 'Interior Secondary',
                                                 'id' => 'zonec-0',
                                                 'class' => 'form-control',
                                             ]) !!}</td>    
                                            @elseif($data['zone_type'] == 'No-Zones')
                                                <td>{!! Form::text('weightfactor[]', null, [
                                                    'placeholder' => 'Weight Factor',
                                                    'id' => 'weightfactor-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                            @elseif($data['zone_type'] == 'Fluid-Level')
                                                <td>{!! Form::text('tenmmabove[]', null, [
                                                    'placeholder' => '10mm above Maximum',
                                                    'id' => 'tenmmabove-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('fivemmabove[]', null, [
                                                    'placeholder' => '5mm above Maximum',
                                                    'id' => 'fivemmabove-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('belowmin[]', null, [
                                                    'placeholder' => 'Below Min',
                                                    'id' => 'belowmin-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('notvisible[]', null, [
                                                    'placeholder' => 'Not Visible',
                                                    'id' => 'notvisible-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('anyleak[]', null, ['placeholder' => 'Any Leak', 'id' => 'anyleak-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('incorrectfluid[]', null, [
                                                    'placeholder' => 'Incorrect Fluid',
                                                    'id' => 'incorrectfluid-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                            @elseif($data['zone_type'] == 'Noise')
                                                <td>{!! Form::text('slight[]', null, ['placeholder' => 'Slight', 'id' => 'slight-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('moderate[]', null, [
                                                    'placeholder' => 'Moderate',
                                                    'id' => 'moderate-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('loud[]', null, ['placeholder' => 'Loud', 'id' => 'loud-0', 'class' => 'form-control']) !!}</td>
                                            @elseif($data['zone_type'] == 'Safety')
                                                <td>{!! Form::text('L[]', null, ['placeholder' => 'L', 'id' => 'L-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('D[]', null, ['placeholder' => 'D', 'id' => 'D-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('W[]', null, ['placeholder' => 'W', 'id' => 'W-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('M[]', null, ['placeholder' => 'M', 'id' => 'M-0', 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('F[]', null, ['placeholder' => 'F', 'id' => 'F-0', 'class' => 'form-control']) !!}</td>
                                            @endif
                                            <td> </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-8 col-xs-7 payment-method last-item-row sub_c">
                                    <div id="load_instruction" class="col-md-6 col-lg-12 mg-t-20 mg-lg-t-0-force"></div>
                                    <button type="button" class="btn btn-success" aria-label="Left Align" id="add-item">
                                        <i class="fa fa-plus-square"></i> Add Row
                                    </button>
                                </div>
                                <div class="col-md-4 col-xs-5 invoice-block pull-right">
                                </div>
                            </div>
                            <hr>
                            <div class="card-body">
                                <div class="form-group mb-0 text-right">
                                    {{ Form::submit('Save', ['class' => 'btn btn-info btn-md', 'id' => 'submit-data']) }}
                                    {{ link_to_route('gca-checksheet.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
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
        {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
        {{ Html::style('assets/libs/select2/dist/css/select2-bootstrap.css') }}
        {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
        <style>
            #added_product div:nth-child(even) .product {
                background: #FFF
            }

            #added_product div:nth-child(odd) .product {
                background: #eeeeee
            }

            #product_sub div:nth-child(odd) .v_product_t {
                background: #FFF
            }

            #product_sub div:nth-child(even) .v_product_t {
                background: #eeeeee
            }

            .hide {
                display: none;
            }
        </style>
    @endsection
    @section('after-scripts')
        {{ Html::script('assets/libs/datepicker/datepicker.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
        {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
        {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
        {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
        <script type="text/javascript">
            $(".select2").select2({
                theme: "bootstrap",
                width: 'auto',
                dropdownAutoWidth: true,
            });
            $(document).on('submit', 'form#create-checksheet', function(e) {
                e.preventDefault();
                $("#submit-data").hide();
                var data = $(this).serialize();
                $.ajax({
                    method: "post",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            //$('div.account_model').modal('hide');
                            toastr.success(result.msg);
                            // capital_account_table.ajax.reload();
                            //other_account_table.ajax.reload();
                            location.href = '{{ route('gca-checksheet.create') }}';
                        } else {
                            $("#submit-data").show();
                            toastr.error(result.msg);
                        }
                    }
                });
            });
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: 'dd-mm-yyyy',
            });
        </script>
        @if (isset($data))
            <script type="text/javascript">
                $(document).on('click', ".add_more", function(e) {
                    e.preventDefault();
                    var product_details = $('#main_product').clone().find(".old_id input:hidden").val(0).end();
                    product_details.find(".del_b").append(
                        '<button class="btn btn-danger v_delete_temp m-1 align-content-end"><i class="fa fa-trash"></i> </button>'
                    ).end();
                    $('#added_product').append(product_details);
                });

                function defectItemRow(n) {
                    var zonetype = @json($data['zone_type']);
                    var has_size = @json(isset($data['has_size']) ? '' : 'hide');
                    var has_description = @json(isset($data['has_description']) ? '' : 'hide');
                    var has_quality = @json(isset($data['has_quality']) ? '' : 'hide');
                    if (zonetype == 'ABCD') {
                        return `
   <tr>
<td> <textarea class="form-control" rows="2" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="A" name="zonea[]" id="zonea-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="B" name="zoneb[]" id="zoneb-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="C" name="zonec[]" id="zonec-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="D" name="zoned[]" id="zoned-${n}" required></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (zonetype == 'Exterior-Interior') {
                        //Interior Exterior
                        return `
   <tr>
<td> <textarea class="form-control" rows="2" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Exterior" name="exterior[]" id="exterior-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Interior Primary" name="interiorprimary[]" id="interiorprimary-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Interior Secondary" name="interiorsecondary[]" id="interiorsecondary-${n}" required></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    }else if (zonetype == 'ExteriorAB-Interior') {
                        //Interior Exterior
                        return `
   <tr>
<td> <textarea class="form-control" rows="2" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Exterior A" name="exterior[]" id="exterior-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Exterior B" name="exteriorb[]" id="exteriorb-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Interior Primary" name="interiorprimary[]" id="interiorprimary-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Interior Secondary" name="interiorsecondary[]" id="interiorsecondary-${n}" required></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (zonetype == 'No-Zones') {
                        return `
   <tr>
<td> <textarea class="form-control" rows="2" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Weight Factor" name="weightfactor[]" id="weightfactor-${n}" required></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (zonetype == 'Noise') {
                        return `
   <tr>
<td> <textarea class="form-control" rows="2" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Slight" name="slight[]" id="slight-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Moderate" name="moderate[]" id="moderate-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Loud"  name="loud[]" id="loud-${n}" required></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (zonetype == 'Fluid-Level') {
                        return `
   <tr>
<td> <textarea class="form-control" rows="2" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="10mm above Maximum" name="tenmmabove[]" id="tenmmabove-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="5mm above Maximum" name="fivemmabove[]" id="fivemmabove-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Below Min" name="belowmin[]" id="belowmin-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Not Visible" name="notvisible[]" id="notvisible-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Any Leak" name="anyleak[]" id="anyleak-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Incorrect Fluid" name="incorrectfluid[]" id="incorrectfluid-${n}" required></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (zonetype == 'Safety') {
                        return `
   <tr>
<td> <textarea class="form-control" rows="2" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="L" name="L[]" id="L-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="D" name="D[]" id="D-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="W" name="W[]" id="W-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="M" name="M[]" id="M-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="F" name="F[]" id="F-${n}" required></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    }
                }
                $(document).on('click', ".v_delete_temp", function(e) {
                    e.preventDefault();
                    $(this).closest('div .product').remove();
                });
                $(".defect_select").select2({
                    theme: "bootstrap",
                    tags: true,
                    tokenSeparators: [',', ' '],
                    width: 'auto',
                    dropdownAutoWidth: true,
                    allowClear: true,
                });
                // on clicking Add Title button
                let rowIndx = 0;
                $('#add-item').click(function() {
                    rowIndx++;
                    const i = rowIndx;
                    $('#defectlist tr:last').after(defectItemRow(i));
                    $(".defect_select").select2({
                        theme: "bootstrap",
                        tags: true,
                        tokenSeparators: [',', ' '],
                        width: 'auto',
                        dropdownAutoWidth: true,
                        allowClear: true,
                    });
                });
                $(document).on("click", ".remove_item_row", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        type: 'warning',
                        title: "You Want To Remove This  Item  From List?",
                        showCancelButton: true,
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete.value) {
                            $(this).closest("tr").remove();
                        } else {
                            Swal.fire('Item Not Removed!!', '', 'info')
                        }
                    });
                });
            </script>
        @endif
    @endsection
