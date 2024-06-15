@extends('layouts.app')
@section('title', 'Gca LCV Checksheet Item')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Gca LCV Checksheet Item</h3>
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
                        @include('gcalcvchecksheetitem.partial.gcalcvchecksheetitem-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => 'gcalcvchecksheetitem.create', 'class' => 'form-horizontal ', 'files' => true, 'role' => 'form', 'method' => 'get']) }}
                        <div class="row ">
                            @php
                                $cat = [];
                                if (isset($input)) {
                                    $cat = $querycategory;
                                }
                            @endphp
                            <div class="col-sm-12 col-xs-12">
                                <div class="row">
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label class="control-label mt-3" for="example-input1-group2">Template</label>
                                        {!! Form::select(
                                            'query_category',
                                            [
                                                'Label' => 'Label',
                                                'ZoneABC' => 'ZoneABC',
                                                'No-Zones' => 'No-Zones',
                                                'Exterior-Interior' => 'Exterior-Interior',
                                                'ExteriorAB-Interior' => 'ExteriorAB-Interior',
                                                'ABCD' => 'ABCD',
                                                'Fluid-Level' => 'Fluid-Level',
                                                'Noise' => 'Noise',
                                                'Safety' => 'Safety',
                                                'Weight Factor' => 'Weight Factor',
                                            ],
                                            isset($input['query_category']) ? $input['query_category'] : null,
                                            [
                                                'class' => 'select2 form-control custom-select',
                                                'placeholder' => 'Select Template',
                                                'style' => 'height: 25px;width: 100%;',
                                                'id' => 'query_category',
                                                'required' => 'required',
                                            ],
                                        ) !!}
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label class="control-label mt-3" for="example-input1-group2">Stage</label>
                                        {!! Form::select('gca_stage_id', $steps, isset($input['gca_stage_id']) ? $input['gca_stage_id'] : null, [
                                            'class' => 'select2 form-control custom-select',
                                            'placeholder' => 'Select Stage',
                                            'id' => 'gca_stage_id',
                                            'style' => 'height: 25px;width: 100%;',
                                            'required' => 'required',
                                        ]) !!}
                                    </div>
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <label class="control-label mt-3" for="example-input1-group2">Query Category</label>
                                        {!! Form::select(
                                            'query_category_id',
                                            $cat,
                                            isset($input['query_category_id']) ? $input['query_category_id'] : null,
                                            [
                                                'class' => 'select2 form-control custom-select',
                                                'placeholder' => 'Query  Type',
                                                'style' => 'height: 25px;width: 100%;',
                                                'id' => 'query_category_id',
                                                'required' => 'required',
                                            ],
                                        ) !!}
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <!--/span-->
                                    <div class="col-md-6 mb-3 mb-md-0">
                                        {{ Form::submit('Set Routings', ['class' => 'btn btn-info btn-md']) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                        <hr>
                        @if (isset($input))
                            {{ Form::open(['route' => 'gcalcvchecksheetitem.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-checksheet']) }}
                            {!! Form::hidden('query_category', $input['query_category']) !!}
                            {!! Form::hidden('gca_stage_id', $input['gca_stage_id']) !!}
                            {!! Form::hidden('gca_query_category_cv_id', $input['query_category_id']) !!}
                            @if ($input['query_category'] == 'Label')
                                @include('gcalcvchecksheetitem.sections.label')
                            @elseif($input['query_category'] == 'ZoneABC')
                                @include('gcalcvchecksheetitem.sections.zoneabc')
                            @elseif($input['query_category'] == 'ABCD')
                                @include('gcalcvchecksheetitem.sections.zoneabcd')
                            @elseif($input['query_category'] == 'No-Zones')
                                @include('gcalcvchecksheetitem.sections.nozones')
                            @elseif($input['query_category'] == 'Exterior-Interior')
                                @include('gcalcvchecksheetitem.sections.exteriorinterior')
                            @elseif($input['query_category'] == 'ExteriorAB-Interior')
                                @include('gcalcvchecksheetitem.sections.exteriorabinterior')
                            @elseif($input['query_category'] == 'Safety')
                                @include('gcalcvchecksheetitem.sections.safety')
                            @elseif($input['query_category'] == 'Weight Factor')
                                @include('gcalcvchecksheetitem.sections.weightfactor')
                            @elseif($input['query_category'] == 'Fluid-Level')
                                @include('gcalcvchecksheetitem.sections.fluidlevel')
                            @elseif($input['query_category'] == 'Noise')
                                @include('gcalcvchecksheetitem.sections.noise')
                            @endif
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
                                    {{ link_to_route('gcalcvchecksheetitem.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
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

            input[type=checkbox] {
                transform: scale(1.5);
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
            $("#query_category").on('change', function() {
                $("#gca_stage_id").val('').trigger('change');
                $("#query_category_id").val('').trigger('change');
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#gca_stage_id").select2({
                    theme: "bootstrap",
                    width: 'auto',
                    dropdownAutoWidth: true,
                    ajax: {
                        url: '{{ route('load-gca-stage') }}',
                        dataType: 'json',
                        type: 'POST',
                        quietMillis: 10,
                        data: {
                            term: $(this).val(),
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.title,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    }
                });
            });
            $("#gca_stage_id").on('change', function() {
                $("#query_category_id").val('').trigger('change');
                var academic_year = $(this).val();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $("#query_category_id").select2({
                    theme: "bootstrap",
                    width: 'auto',
                    dropdownAutoWidth: true,
                    ajax: {
                        url: '{{ route('load-gcalcv-query-category') }}',
                        dataType: 'json',
                        type: 'POST',
                        quietMillis: 10,
                        data: {
                            query_category: $('#query_category').val(),
                            gca_stage_id: $(this).val(),
                        },
                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.name,
                                        id: item.id
                                    }
                                })
                            };
                        },
                    }
                });
            });
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
                            // location.href = '{{ route('gcacvchecksheet.create') }}';
                            location.reload();
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
        @if (isset($input))
            <script type="text/javascript">
                $(document).on('click', ".add_more", function(e) {
                    e.preventDefault();
                    var product_details = $('#main_product').clone().find(".old_id input:hidden").val(0).end();
                    product_details.find(".del_b").append(
                        '<button class="btn btn-danger v_delete_temp m-1 align-content-end"><i class="fa fa-trash"></i> </button>'
                    ).end();
                    $('#added_product').append(product_details);
                });
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
                let rowIndx = '{{ count($records) }}';
                $('#add-item').click(function() {
                    const i = rowIndx;
                    $('#defectlist tr:last').after(defectItemRow(i));
                    $(".defect_select").select2({
                        theme: "bootstrap",
                        width: 'auto',
                        dropdownAutoWidth: true,
                        placeholder: 'Select Category',
                        ajax: {
                            url: '{{ route('load-cv-category') }}',
                            dataType: 'json',
                            quietMillis: 10,
                            processResults: function(data) {
                                return {
                                    results: $.map(data, function(item) {
                                        return {
                                            text: item.name,
                                            id: item.id
                                        }
                                    })
                                };
                            },
                        }
                    });
                    rowIndx++;
                });

                function defectItemRow(n) {
                    var querycategory = @json($input['query_category']);
                    if (querycategory == 'Label') {
                        return `<tr>
                            <td> <textarea class="form-control" rows="3" placeholder="Defect Items" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" Required><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_b[${n}]" id="zone_b-${n}" class ="form-control custom-select" Required><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'ZoneABC') {
                        return `<tr>
                            <td><input type="text" class="form-control " placeholder="Defect Name" name="defect_condition[]" id="defect_condition-${n}" ></td>
                            <td> <textarea class="form-control" rows="3" placeholder="Defect Details" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_b[${n}]" id="zone_b-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_c[${n}]" id="zone_c-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'ABCD') {
                        return `<tr>
                            <td><input type="text" class="form-control " placeholder="Size" name="defect_condition[]" id="defect_condition-${n}" ></td>
                            <td> <textarea class="form-control" rows="3" placeholder="Description" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td><input type="text" class="form-control " placeholder="Quantity" name="phenomenon[]" id="phenomenon-${n}" ></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_b[${n}]" id="zone_b-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_c[${n}]" id="zone_c-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_d[${n}]" id="zone_d-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'No-Zones') {
                        return `<tr>
                            <td><input type="text" class="form-control " placeholder="Size" name="defect_condition[]" id="defect_condition-${n}" ></td>
                            <td> <textarea class="form-control" rows="3" placeholder="Description" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td><input type="text" class="form-control " placeholder="Quantity" name="phenomenon[]" id="phenomenon-${n}" ></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'Exterior-Interior') {
                        return `<tr>
                            <td><input type="text" class="form-control " placeholder="Size" name="defect_condition[]" id="defect_condition-${n}" ></td>
                            <td> <textarea class="form-control" rows="3" placeholder="Description" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td><input type="text" class="form-control " placeholder="Quantity" name="phenomenon[]" id="phenomenon-${n}" ></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_b[${n}]" id="zone_b-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_c[${n}]" id="zone_c-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'ExteriorAB-Interior') {
                        return `<tr>
                            <td><input type="text" class="form-control " placeholder="Size" name="defect_condition[]" id="defect_condition-${n}" ></td>
                            <td> <textarea class="form-control" rows="3" placeholder="Description" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td><input type="text" class="form-control " placeholder="Quantity" name="phenomenon[]" id="phenomenon-${n}" ></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_b[${n}]" id="zone_b-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_c[${n}]" id="zone_c-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td> <select name="zone_d[${n}]" id="zone_d-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'Safety') {
                        return `<tr>
                            <td> <textarea class="form-control" rows="2" placeholder="Operation" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
<td> <textarea class="form-control" rows="2" placeholder="Description" name="defect_condition[]" id="defect_condition-${n}" ></textarea></td>
<td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <input name="loose[]" type="checkbox" value="L" id="md_checkbox_20" class="chk-col-red mt-2"  /></td>
<td> <input name="dermaged[]" type="checkbox" value="D"  id="md_checkbox_21" class="chk-col-red mt-2"  /></td>
<td> <input name="wrong_assembly[${n}]" type="checkbox" value="W"  id="md_checkbox_22" class="chk-col-red mt-2"  /></td>
<td> <input name="lack_of_parts[${n}]" type="checkbox" value="M"  id="md_checkbox_23" class="chk-col-red mt-2"  /></td>
<td> <input name="function_defect[${n}]" type="checkbox" value="F"  id="md_checkbox_24" class="chk-col-red mt-2"  /></td>
<td> <input name="factor_ten[${n}]" type="checkbox" value="10"  id="md_checkbox_25" class="chk-col-red mt-2"  /></td>
<td> <input name="factor_one[${n}]" type="checkbox" value="20"  id="md_checkbox_25" class="chk-col-red mt-2"  /></td>
<td> <input name="factor_fifty[${n}]" type="checkbox" value="50"  id="md_checkbox_26" class="chk-col-red mt-2"  /></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'Weight Factor') {
                        return `<tr>
                            <td> <textarea class="form-control" rows="3" placeholder="Name" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td> <textarea class="form-control" rows="3" placeholder="Details" name="defect_condition[]" id="defect_condition-${n}" ></textarea></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="1">1</option><option value="5">5</option><option value="10">10</option><option value="20">20</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'Fluid-Level') {
                        return `<tr>
                            <td> <textarea class="form-control" rows="3" placeholder="Fluid" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_b[${n}]" id="zone_b-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_c[${n}]" id="zone_c-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_d[${n}]" id="zone_d-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_e[${n}]" id="zone_e-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_f[${n}]" id="zone_f-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    } else if (querycategory == 'Noise') {
                        return `<tr>
                            <td> <textarea class="form-control" rows="3" placeholder="Fluid" name="defect_name[]" id="defect_name-${n}" ></textarea></td>
                            <td class=""> <input type="text" class="form-control " placeholder="Position" name="defect_position[]" id="defect_position-${n}" required></td>
<td> <select name="zone_a[${n}]" id="zone_a-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_b[${n}]" id="zone_b-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td> <select name="zone_c[${n}]" id="zone_c-${n}" class ="form-control custom-select" ><option value="">Select</option><option value="0.5">0.5</option><option value="1">1</option><option value="10">10</option><option value="50">50</option></select></td>
<td><a href="javascript:void(0)" class="text-inverse" title="" data-toggle="tooltip" data-original-title="Delete"><i class="ti-trash remove_item_row"></i></a></td>
</tr>
`;
                    }
                }
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
