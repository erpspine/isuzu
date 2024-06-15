@extends('layouts.app')
@section('title', 'Search Unit')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Search Unit </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Search Unit</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
                {{ Form::open(['route' => 'searchunitprofile', 'class' => '', 'role' => 'form', 'method' => 'get', 'id' => 'filter-qrcode', 'files' => false]) }}
                <div class="row">
                    <div class="col-md-8">
                        <label for="lot">Search By Lot Job Or Chasis</label>
                        {!! Form::select('vehicle_id', $lot, $vdata, [
                            'class' => 'select2 form-control custom-select',
                            'style' => 'height: 60px;width: 100%;',
                            'required' => 'required',
                            'placeholder' => 'Select Vehicle',
                        ]) !!}
                    </div>
                    <div class="col-md-4 p-3">
                        {{ Form::submit('Load Profile', ['class' => 'btn btn-primary btn-md ']) }}
                    </div>
                </div>
                {{ Form::close() }}
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
        @if (!empty($data))
            <div class="row">
                <!-- Column -->
                <div class="col-lg-4 col-xlg-3 col-md-5">
                    <div class="card">
                        <div class="card-body">
                            <center class="mt-4"> <img src="{{ asset('upload/' . $data['vehicle_data']->model->icon) }}"
                                    class="rounded-circle" width="150" />
                                <h4 class="card-title mt-2">{{ $data['vehicle_data']->vin_no }}</h4>
                                <h6 class="card-subtitle">{{ $data['vehicle_data']->model->model_name }}</h6>
                                <div class="row text-center justify-content-md-center">
                                    <div class="col-4"><a href="javascript:void(0)" class="link">Lot :<font
                                                class="font-medium">{{ $data['vehicle_data']->lot_no }}</font></a></div>
                                    <div class="col-4"><a href="javascript:void(0)" class="link">Job :<font
                                                class="font-medium">{{ $data['vehicle_data']->job_no }}</font></a></div>
                                </div>
                            </center>
                        </div>
                        <div>
                            <hr>
                        </div>
                        <div class="card-body"> <small class="text-muted">Engine No </small>
                            <h6>{{ $data['vehicle_data']->engine_no }}</h6>
                            <small class="text-muted pt-4 db">Offline Date</small>
                            <h6>{{ $data['offlinedate'] }}</h6>
                            <small class="text-muted pt-4 db">FCW Date</small>
                            <h6>{{ $data['fcw'] }}</h6>
                        </div>
                    </div>
                </div>
                <!-- Column -->
                <!-- Column -->
                <div class="col-lg-8 col-xlg-9 col-md-7">
                    <div class="card">
                        <!-- Tabs -->
                        <ul class="nav nav-pills custom-pills" id="pills-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="pills-timeline-tab" data-toggle="pill" href="#current-month"
                                    role="tab" aria-controls="pills-timeline" aria-selected="true">Routings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#last-month"
                                    role="tab" aria-controls="pills-profile" aria-selected="false">Defects</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="pills-setting-tab" data-toggle="pill" href="#previous-month"
                                    role="tab" aria-controls="pills-setting" aria-selected="false">Movement</a>
                            </li>
                            <li class="nav-item">
                                <div class="text-right">
                                    <a class="btn btn-default btn-outline"
                                        href="{{ route('printprofile', [$data['vehicle_data']->id, $data['token']]) }}"
                                        target="_blank"> <span><i class="fa fa-print"></i> Print</span></a>
                                </div>
                            </li>
                        </ul>
                        <!-- Tabs -->
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="current-month" role="tabpanel"
                                aria-labelledby="pills-timeline-tab">
                                <div class="card-body">
                                    @foreach ($data['shops'] as $shop)
                                        <div class="card-header bg-info">
                                            <h4 class="mb-0 text-white">{{ $shop->shop_name }}</h4>
                                        </div>
                                        @php
                                            $i = 0;
                                        @endphp
                                        @foreach ($shop->querycategory as $row)
                                            @php
                                                $i++;
                                            @endphp
                                            <div class="card-body">
                                                <h4 class="card-title"> {{ $i }}. {{ $row->query_code }} :
                                                    {{ $row->category_name }}</h4>
                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead class="bg-warning text-white">
                                                            <tr>
                                                                <!--<th scope="col">Image</th>-->
                                                                <th scope="col">Query Name</th>
                                                                <th scope="col">Answer</th>
                                                                <th scope="col">Defects</th>
                                                                <th scope="col">User</th>
                                                                <th scope="col">Signature</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($row->queryanswers as $rowdata)
                                                                <tr>
                                                                    @php
                                                                        $defect_name = '--';
                                                                        $weight = '--';
                                                                        $appuser = '--';
                                                                        $image_defect = '--';
                                                                        $signature = '--';
                                                                        if (!empty($rowdata->signature)) {
                                                                            $url = asset('upload/' . $rowdata->signature);
                                                                            $signature = '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
                                                                        }
                                                                        if ($rowdata->has_error == 'Yes') {
                                                                            $defect_name = $rowdata->get_defects->defect_name;
                                                                        }
                                                                    @endphp
                                                                    <td>{{ (isset($rowdata->queries)) ?  $rowdata->queries->query_name : ''}}  </td>
                                                                    <td>{{ $rowdata->answer }}</td>
                                                                    <td>{{ $defect_name }}</td>
                                                                    <td>{{ $rowdata->doneby->name }}</td>
                                                                    <td>{!! $signature !!}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endforeach
                                </div>
                            </div>
                            <div class="tab-pane fade" id="last-month" role="tabpanel" aria-labelledby="pills-profile-tab">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="bg-info text-white">
                                                <tr>
                                                    <th>Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                                    </th>
                                                    <th>Query Name</th>
                                                    <th>Defect</th>
                                                    <th>GCA</th>
                                                    <th>Drl Score</th>
                                                    <th>Inspected By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($data['unit_defects'] as $defect)
                                                    <tr>
                                                        <td>{{ dateFormat($defect->created_at) }}</td>
                                                        <td>{{ $defect->getqueryanswer->routing->query_name }}</td>
                                                        <td>{{ $defect->defect_name }} </td>
                                                        <td>{{ $defect->value_given }}</td>
                                                        <td>{{ $defect->is_defect }}</td>
                                                        <td>{{ $defect->getqueryanswer->doneby->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="previous-month" role="tabpanel"
                                aria-labelledby="pills-setting-tab">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead class="bg-info text-white">
                                                <tr>
                                                    <th>#</th>
                                                    <th>Shop</th>
                                                    <th>Date In</th>
                                                    <th>Date Out</th>
                                                    <th>Inspectd By</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i = 0;
                                                @endphp
                                                @foreach ($data['unit_movements'] as $unit_movement)
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $i }}</td>
                                                        <td>{{ $unit_movement->shop->shop_name }}</td>
                                                        <td>{{ dateFormat($unit_movement->datetime_in) }}</td>
                                                        <td>{{ dateFormat($unit_movement->datetime_out) }}</td>
                                                        <td>{{ $unit_movement->user->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Column -->
            </div>
        @else
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="alert alert-warning"> <i class="ti-info"></i> No Record Found,Search atleast one
                                unit.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span
                                        aria-hidden="true">&times;</span> </button>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col-->
            </div>
        @endif
    </div>
@endsection
@section('after-styles')
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/libs/dist/jquery-ui.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
@endsection
@section('after-scripts')
    {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
    {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
    {{ Html::script('assets/libs/jquery/dist/jquery-ui.min.js') }}
    {{ Html::script('assets/libs/jquery/dist/jquery-migrate-3.0.0.min.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
    <script type="text/javascript">
        $(".select2").select2();
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
    </script>
@endsection
