@extends('layouts.app')
@section('title', 'Edit Gca Audit Checksheet')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Gca Audit Checksheet</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit </li>
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
                        <div class="row mb-5">
                            <div class="col-md-3">
                                <input type="checkbox" name="has_size" id="md_checkbox_1" disabled
                                    class="material-inputs chk-col-blue"
                                    {{ !empty($gcadata->has_size) ? 'checked' : '' }} />
                                <label for="md_checkbox_1">Has Size</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="has_description" id="md_checkbox_2" disabled
                                    class="material-inputs chk-col-blue"
                                    {{ !empty($gcadata->has_description) ? 'checked' : '' }} />
                                <label for="md_checkbox_2">Has Description</label>
                            </div>
                            <div class="col-md-3">
                                <input type="checkbox" name="has_quality" id="md_checkbox_3" disabled
                                    class="material-inputs chk-col-blue"
                                    {{ !empty($gcadata->has_quality) ? 'checked' : '' }} />
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
                                                'ABCD' => 'ABCD',
                                                'Fluid-Level' => 'Fluid-Level',
                                                'Noise' => 'Noise',
                                                'Safety' => 'Safety',
                                               
                                            ],
                                            !empty($gcadata->zone_type) ? $gcadata->zone_type : null,
                                            [
                                                'class' => 'select2 form-control custom-select',
                                                'placeholder' => 'Zone Type',
                                                'style' => 'height: 25px;width: 100%;',
                                                'required' => 'required',
                                                'disabled'=>'disabled',
                                            ],
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end row -->
                        <hr>
                        {{ Form::open(['route' => ['gca-checksheet.update',$gcadata->id], 'class' => 'form-horizontal','files' => true, 'role' => 'form', 'method' => 'PUT', 'id' => 'create-checksheet'])}}
                        {!! Form::hidden('has_size', !empty($gcadata->has_size) ? '1' : '0') !!}
                        {!! Form::hidden('has_description', !empty($gcadata->has_description) ? '1' : '0') !!}
                        {!! Form::hidden('has_quality', !empty($gcadata->has_quality) ? '1' : '0') !!}
                        {!! Form::hidden('zone_type', $gcadata->zone_type) !!}
                        {!! Form::hidden('checksheet_id', $gcadata->id) !!}
                        <div class="row">
                            <!--/span-->
                            <div class="col-md-4">
                                <label class="control-label  col-md-4">Name</label>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        {!! Form::text('category_name', $gcadata->category_name, [
                                            'placeholder' => 'Name',
                                            'class' => 'form-control',
                                            'required' => 'required',
                                        ]) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label  col-md-12">Vehicle Type</label>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        {!! Form::select(
                                            'vehicle_type',
                                            ['1' => 'Light Commercial', '2' => 'Heavy Commercial'],
                                            $gcadata->vehicle_type,
                                            [
                                                'placeholder' => 'Select Vehicle Type',
                                                'class' => 'form-control custom-select ',
                                                'required' => 'required',
                                            ],
                                        ) !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label col-md-12">Category</label>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        {!! Form::select('gca_audit_report_category_id', $gcacat, $gcadata->gca_audit_report_category_id, [
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
                                        <th class="{{ !empty($gcadata->has_size) ? '' : 'hide' }}">
                                            Size&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </th>
                                        <th class="{{ !empty($gcadata->has_description) ? '' : 'hide' }}">
                                            Description&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </th>
                                        <th class="{{ !empty($gcadata->has_quality) ? '' : 'hide' }}">
                                            Quantity&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        </th>
                                        @if ($gcadata->zone_type == 'ABCD')
                                            <th>Zone&nbsp;&nbsp;A</th>
                                            <th>Zone&nbsp;&nbsp;B</th>
                                            <th>Zone&nbsp;&nbsp;C</th>
                                            <th>Zone&nbsp;&nbsp;D</th>
                                        @elseif($gcadata->zone_type == 'Exterior-Interior')
                                            <th>Exterior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>Interior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Primary</th>
                                            <th>Interior&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Secondary </th>
                                        @elseif($gcadata->zone_type == 'No-Zones')
                                            <th>Weight&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Factor</th>
                                        @elseif($gcadata->zone_type == 'Fluid-Level')
                                            <th>10mm&nbsp;above&nbsp;Maximum</th>
                                            <th>5mm&nbsp;above&nbsp;&nbsp;Maximum</th>
                                            <th>Below&nbsp;Min</th>
                                            <th>Not&nbsp;Visible</th>
                                            <th>Any&nbsp;Leak</th>
                                            <th>Incorrect&nbsp;Fluid</th>
                                        @elseif($gcadata->zone_type == 'Noise')
                                            <th>Slight</th>
                                            <th>Moderate</th>
                                            <th>Loud</th>
                                        @elseif($gcadata->zone_type == 'Safety')
                                            <th>L=loose</th>
                                            <th>D=damaged</th>
                                            <th>W=wrong</th>
                                            <th>M=missing</th>
                                            <th>F=function</th>
                                        @endif
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($gcadata->query_items as $record)
                                        @php
                                            $i++;
                                            $tag_value = $record->gettags->pluck('name')->toArray();
                                        @endphp
                                        <tr>
                                            {!! Form::hidden('item_id[]', $record->id,['id' => "item_id-$i"]) !!}
                                            <td>{!! Form::textarea('defect[]', $record->defect, [
                                                'placeholder' => 'Defects',
                                                'id' => "defects-$i",
                                                'class' => 'form-control',
                                                'rows' => '5',
                                                'required' => 'required',
                                            ]) !!}</td>
                                            <td> <select name="tags[{{ $record->id }}][]"
                                                    class="defect_select form-control" id="tags-{{ $i }}"
                                                    multiple="multiple" style="height: 25px;width: 100%;">
                                                    @foreach ($record->gettags as $tag)
                                                        <option value="{{ $tag->name }}"
                                                            {{ in_array($tag->name, $tag_value) ? 'selected' : '' }}>
                                                            {{ $tag->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td class="{{ !empty($gcadata->has_size) ? '' : 'hide' }}">
                                                {!! Form::text('size[]', $record->size, ['placeholder' => 'Size', 'class' => 'form-control', 'id' => 'size']) !!}</td>
                                            <td class="{{ !empty($gcadata->has_description) ? '' : 'hide' }}">
                                                {!! Form::text('description[]', $record->description, [
                                                    'placeholder' => 'Description',
                                                    'class' => 'form-control',
                                                    'id' => "description-$i",
                                                ]) !!}</td>
                                            <td class="{{ !empty($gcadata->has_quality) ? '' : 'hide' }}">
                                                {!! Form::text('quantity[]', $record->quantity, [
                                                    'placeholder' => 'Quantity',
                                                    'id' => "quantity-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                            @if ($gcadata->zone_type == 'ABCD')
                                                <td>{!! Form::text('zonea[]', $record->zonea, ['placeholder' => 'A', 'id' => "zonea-$i", 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('zoneb[]', $record->zoneb, ['placeholder' => 'B', 'id' => "zoneb-$i", 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('zonec[]', $record->zonec, ['placeholder' => 'C', 'id' => "zonec-$i", 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('zoned[]', $record->zoned, ['placeholder' => 'D', 'id' => "zoned-$i", 'class' => 'form-control']) !!}</td>
                                            @elseif($gcadata->zone_type == 'Exterior-Interior')
                                                <td>{!! Form::text('exterior[]', $record->exterior, [
                                                    'placeholder' => 'Exterior',
                                                    'id' => "exterior-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('interiorprimary[]', $record->interiorprimary, [
                                                    'placeholder' => 'Interior Primary',
                                                    'id' => "interiorprimary-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('interiorsecondary[]', $record->interiorsecondary, [
                                                    'placeholder' => 'Interior Secondary',
                                                    'id' => "zonec-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                            @elseif($gcadata->zone_type == 'No-Zones')
                                                <td>{!! Form::text('weightfactor[]', $record->weightfactor, [
                                                    'placeholder' => 'Weight Factor',
                                                    'id' => "weightfactor-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                            @elseif($gcadata->zone_type == 'Fluid-Level')
                                                <td>{!! Form::text('tenmmabove[]', $record->tenmmabove, [
                                                    'placeholder' => '10mm above Maximum',
                                                    'id' => "tenmmabove-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('fivemmabove[]', $record->fivemmabove, [
                                                    'placeholder' => '5mm above Maximum',
                                                    'id' => "fivemmabove-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('belowmin[]', $record->belowmin, [
                                                    'placeholder' => 'Below Min',
                                                    'id' => "belowmin-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('notvisible[]', $record->notvisible, [
                                                    'placeholder' => 'Not Visible',
                                                    'id' => "notvisible-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('anyleak[]', $record->anyleak, [
                                                    'placeholder' => 'Any Leak',
                                                    'id' => 'anyleak-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('incorrectfluid[]', $record->incorrectfluid, [
                                                    'placeholder' => 'Incorrect Fluid',
                                                    'id' => "incorrectfluid-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                            @elseif($gcadata->zone_type == 'Noise')
                                                <td>{!! Form::text('slight[]', $record->slight, [
                                                    'placeholder' => 'Slight',
                                                    'id' => 'slight-0',
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('moderate[]', $record->moderate, [
                                                    'placeholder' => 'Moderate',
                                                    'id' => "moderate-$i",
                                                    'class' => 'form-control',
                                                ]) !!}</td>
                                                <td>{!! Form::text('loud[]', $record->loud, ['placeholder' => 'Loud', 'id' => 'loud-0', 'class' => 'form-control']) !!}</td>
                                            @elseif($gcadata->zone_type == 'Safety')
                                                <td>{!! Form::text('L[]', $record->L, ['placeholder' => 'L', 'id' => "L-$i", 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('D[]', $record->D, ['placeholder' => 'D', 'id' => "D-$i", 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('W[]', $record->W, ['placeholder' => 'W', 'id' => "W-$i", 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('M[]', $record->M, ['placeholder' => 'M', 'id' => "M-$i", 'class' => 'form-control']) !!}</td>
                                                <td>{!! Form::text('F[]', $record->F, ['placeholder' => 'F', 'id' => "F-$i", 'class' => 'form-control']) !!}</td>
                                            @endif
                                            <td><a href="javascript:void(0)" class="text-inverse" title=""
                                                    data-toggle="tooltip" data-original-title="Delete"><i
                                                        class="ti-trash remove_item_row"></i></a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div><br />
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
                            location.href = '{{ route('gca-checksheet.index') }}';
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
                var zonetype = @json($gcadata->zone_type);
                var has_size = @json(!empty($gcadata->has_size) ? '' : 'hide');
                var has_description = @json(!empty($gcadata->has_description) ? '' : 'hide');
                var has_quality = @json(!empty($gcadata->has_quality) ? '' : 'hide');
                if (zonetype == 'ABCD') {
                    return `
   <tr>
<td> <textarea class="form-control" rows="5" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="A" name="zonea[]" id="zonea-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="B" name="zoneb[]" id="zoneb-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="C" name="zonec[]" id="zonec-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="D" name="zoned[]" id="zoned-${n}" required></td>
<td><input type="hidden"   name="item_id[]" value="0" id="item_id-${n}"> <a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                } else if (zonetype == 'Exterior-Interior') {
                    //Interior Exterior
                    return `
   <tr>
<td> <textarea class="form-control" rows="5" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Exterior" name="exterior[]" id="exterior-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Interior Primary" name="interiorprimary[]" id="interiorprimary-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Interior Secondary" name="interiorsecondary[]" id="interiorsecondary-${n}" required></td>
<td><input type="hidden"   name="item_id[]" value="0" id="item_id-${n}"><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                } else if (zonetype == 'No-Zones') {
                    return `
   <tr>
<td> <textarea class="form-control" rows="5" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Weight Factor" name="weightfactor[]" id="weightfactor-${n}" required></td>
<td><input type="hidden"   name="item_id[]" value="0" id="item_id-${n}"><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                } else if (zonetype == 'Noise') {
                    return `
   <tr>
<td> <textarea class="form-control" rows="5" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Slight" name="slight[]" id="slight-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Moderate" name="moderate[]" id="moderate-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="Loud"  name="loud[]" id="loud-${n}" required></td>
<td><input type="hidden"   name="item_id[]" value="0" id="item_id-${n}"><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                } else if (zonetype == 'Fluid-Level') {
                    return `
   <tr>
<td> <textarea class="form-control" rows="5" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
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
<td><input type="hidden"   name="item_id[]" value="0" id="item_id-${n}"><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                } else if (zonetype == 'Safety') {
                    return `
   <tr>
<td> <textarea class="form-control" rows="5" placeholder="Defects" name="defect[]" id="defect-${n}" required></textarea></td>
<td><select name="tags[${n}][]" id="tags-${n}" class ="defect_select form-control custom-select" multiple></select></td>
<td class="${has_size}"> <input type="text" class="form-control " placeholder="Size" name="size[]" id="size-${n}" required></td>
<td class="${has_description}"> <input type="text" class="form-control" placeholder="Description" name="description[]" id="description-${n}" required></td>
<td class="${has_quality}"> <input type="text" class="form-control" placeholder="Quantity" name="quantity[]" id="quantity-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="L" name="L[]" id="L-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="D" name="D[]" id="D-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="W" name="W[]" id="W-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="M" name="M[]" id="M-${n}" required></td>
<td> <input type="text" class="form-control" placeholder="F" name="F[]" id="F-${n}" required></td>
<td><input type="hidden"   name="item_id[]" value="0" id="item_id-${n}"><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
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
            let rowIndx = @json($i);
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
    @endsection
