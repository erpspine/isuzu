@extends('layouts.app')
@section('title', 'Gca Checksheet Items')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Gca Checksheet Items </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Gca Checksheet Items {{ $title->query_group_name }}</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('gcachecksheetcv.partial.gcachecksheetcv-header-buttons')
                    </div>
                </div>
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
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            @if ($title->query_group_name == 'Paint')
                                <table class="table table-striped table-bordered" id="routingquery">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Qualy Zone</th>
                                            <th>Defect Condition </th>
                                            <th>0.5 </th>
                                            <th>1 </th>
                                            <th>10 </th>
                                            <th>50 </th>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            @elseif ($title->query_group_name == 'Function')
                                <table class="table table-striped table-bordered" id="routingquery">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Loose </th>
                                            <th>Dermage </th>
                                            <th>Wrong Assembly </th>
                                            <th>Lack Of Parts </th>
                                            <th>Function Defect</th>
                                            <th>10 </th>
                                            <th>50 </th>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            @elseif ($title->query_group_name == 'Functional Weighting Standard')
                                <table class="table table-striped table-bordered" id="routingquery">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Phenomenon</th>
                                            <th>Defect/Part</th>
                                            <th>0.5 </th>
                                            <th>1 </th>
                                            <th>10 </th>
                                            <th>50 </th>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            @elseif ($title->query_group_name == 'Label')
                                <table class="table table-striped table-bordered" id="routingquery">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Defect Item</th>
                                            <th>Regulatory Related Parts </th>
                                            <th>Engineering information related parts(Including Caution Label) </th>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            @elseif ($title->query_group_name == 'Lamp')
                                <table class="table table-striped table-bordered" id="routingquery">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Lamp Name</th>
                                            <th>Deviate to upper from standard Value </th>
                                            <th>Deviate to lower from standard value </th>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            @elseif ($title->query_group_name == 'Oil Filling')
                                <table class="table table-striped table-bordered" id="routingquery">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Portion</th>
                                            <th>More Than Standard </th>
                                            <th>Extra Ordinary </th>
                                            <th>Less than Inspection Standard </th>
                                            <th>Lower than Min. Position </th>
                                            <th>Extraordinary Few </th>
                                            <th>Leakage </th>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            @elseif ($title->query_group_name == 'ZoneABC')
                                <table class="table table-striped table-bordered" id="routingquery">
                                    <thead>
                                        <tr>
                                            <th>Category</th>
                                            <th>Defect NAme</th>
                                            <th>Defect Details</th>
                                            <th>Zone A</th>
                                            <th>Zone B</th>
                                            <th>Zone C</th>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endsection
    @section('after-styles')
        {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
        {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    @endsection
    @section('after-scripts')
        {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
        {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('submit', 'form#category_add_form', function(e) {
                    e.preventDefault();
                    $(this)
                        .find('button[type="submit"]')
                        .attr('disabled', true);
                    var data = $(this).serialize();
                    $.ajax({
                        method: 'POST',
                        url: $(this).attr('action'),
                        dataType: 'json',
                        data: data,
                        success: function(result) {
                            if (result.success === true) {
                                $('div.category_modal').modal('hide');
                                toastr.success(result.msg);
                                category_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
                    });
                });
            });
            // capital_account_table
            $('table#routingquery tbody').on('click', 'a.delete-query', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((willDelete) => {
                    if (willDelete.value) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "POST",
                            url: href,
                            dataType: "json",
                            data: {
                                _method: 'DELETE',
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    routingquery.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    } else {
                        Swal.fire('Query  Not Deleted', '', 'info')
                    }
                });
            });
        </script>
        @if ($title->query_group_name == 'Paint')
            <script type="text/javascript">
                var routingquery = $('#routingquery').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('gcacvchecksheet.show', [$title->id]) }}',
                        data: function(d) {
                            // d.account_status = $('#account_status').val();
                        }
                    },
                    columns: [{
                            data: 'category',
                            name: 'category'
                        }, {
                            data: 'defect_name',
                            name: 'defect_name'
                        },
                        {
                            data: 'defect_condition',
                            name: 'defect_condition'
                        },
                        {
                            data: 'factor_zero',
                            name: 'factor_zero'
                        },
                        {
                            data: 'factor_one',
                            name: 'factor_one'
                        },
                        {
                            data: 'factor_ten',
                            name: 'factor_ten'
                        },
                        {
                            data: 'factor_fifty',
                            name: 'factor_fifty'
                        }
                    ],
                    order: [
                        ['2', 'asc']
                    ],
                    'select': {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    'lengthMenu': [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: '<"row"lfB>rtip',
                    buttons: [{
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            </script>
        @elseif ($title->query_group_name == 'Function')
            <script type="text/javascript">
                var routingquery = $('#routingquery').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('gcacvchecksheet.show', [$title->id]) }}',
                        data: function(d) {
                            // d.account_status = $('#account_status').val();
                        }
                    },
                    columns: [{
                            data: 'category',
                            name: 'category'
                        }, {
                            data: 'defect_name',
                            name: 'defect_name'
                        },
                        {
                            data: 'defect_condition',
                            name: 'defect_condition'
                        },
                        {
                            data: 'loose',
                            name: 'loose'
                        },
                        {
                            data: 'dermaged',
                            name: 'dermaged'
                        },
                        {
                            data: 'wrong_assembly',
                            name: 'wrong_assembly'
                        },
                        {
                            data: 'lack_of_parts',
                            name: 'lack_of_parts'
                        }, {
                            data: 'function_defect',
                            name: 'function_defect'
                        }, {
                            data: 'factor_ten',
                            name: 'factor_ten'
                        }, {
                            data: 'factor_fifty',
                            name: 'factor_fifty'
                        }
                    ],
                    order: [
                        ['2', 'asc']
                    ],
                    'select': {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    'lengthMenu': [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: '<"row"lfB>rtip',
                    buttons: [{
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            </script>
        @elseif ($title->query_group_name == 'Functional Weighting Standard')
            <script type="text/javascript">
                var routingquery = $('#routingquery').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('gcacvchecksheet.show', [$title->id]) }}',
                        data: function(d) {
                            // d.account_status = $('#account_status').val();
                        }
                    },
                    columns: [{
                            data: 'category',
                            name: 'category'
                        }, {
                            data: 'defect_name',
                            name: 'defect_name'
                        },
                        {
                            data: 'phenomenon',
                            name: 'phenomenon'
                        },
                        {
                            data: 'factor_zero',
                            name: 'factor_zero'
                        },
                        {
                            data: 'factor_one',
                            name: 'factor_one'
                        },
                        {
                            data: 'factor_ten',
                            name: 'factor_ten'
                        },
                        {
                            data: 'factor_fifty',
                            name: 'factor_fifty'
                        }
                    ],
                    order: [
                        ['2', 'asc']
                    ],
                    'select': {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    'lengthMenu': [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: '<"row"lfB>rtip',
                    buttons: [{
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            </script>
        @elseif ($title->query_group_name == 'Label' || $title->query_group_name == 'Lamp')
            <script type="text/javascript">
                var routingquery = $('#routingquery').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('gcacvchecksheet.show', [$title->id]) }}',
                        data: function(d) {
                            // d.account_status = $('#account_status').val();
                        }
                    },
                    columns: [{
                            data: 'category',
                            name: 'category'
                        }, {
                            data: 'defect_name',
                            name: 'defect_name'
                        },
                        {
                            data: 'zone_a',
                            name: 'zone_a'
                        },
                        {
                            data: 'zone_b',
                            name: 'zone_b'
                        }
                    ],
                    order: [
                        ['2', 'asc']
                    ],
                    'select': {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    'lengthMenu': [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: '<"row"lfB>rtip',
                    buttons: [{
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            </script>
        @elseif ($title->query_group_name == 'Oil Filling')
            <script type="text/javascript">
                var routingquery = $('#routingquery').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('gcacvchecksheet.show', [$title->id]) }}',
                        data: function(d) {
                            // d.account_status = $('#account_status').val();
                        }
                    },
                    columns: [{
                            data: 'category',
                            name: 'category'
                        }, {
                            data: 'defect_name',
                            name: 'defect_name'
                        },
                        {
                            data: 'zone_a',
                            name: 'zone_a'
                        },
                        {
                            data: 'zone_b',
                            name: 'zone_b'
                        },
                        {
                            data: 'zone_c',
                            name: 'zone_c'
                        },
                        {
                            data: 'zone_d',
                            name: 'zone_d'
                        },
                        {
                            data: 'zone_e',
                            name: 'zone_e'
                        }, {
                            data: 'zone_f',
                            name: 'zone_f'
                        }
                    ],
                    order: [
                        ['2', 'asc']
                    ],
                    'select': {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    'lengthMenu': [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: '<"row"lfB>rtip',
                    buttons: [{
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            </script>
        @elseif ($title->query_group_name == 'ZoneABC')
            <script type="text/javascript">
                var routingquery = $('#routingquery').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: '{{ route('gcacvchecksheet.show', [$title->id]) }}',
                        data: function(d) {
                            // d.account_status = $('#account_status').val();
                        }
                    },
                    columns: [{
                            data: 'category',
                            name: 'category'
                        }, {
                            data: 'defect_name',
                            name: 'defect_name'
                        }, {
                            data: 'defect_condition',
                            name: 'defect_condition'
                        },
                        {
                            data: 'zone_a',
                            name: 'zone_a'
                        },
                        {
                            data: 'zone_b',
                            name: 'zone_b'
                        },
                        {
                            data: 'zone_c',
                            name: 'zone_c'
                        }
                    ],
                    order: [
                        ['2', 'asc']
                    ],
                    'select': {
                        style: 'multi',
                        selector: 'td:first-child'
                    },
                    'lengthMenu': [
                        [10, 25, 50, -1],
                        [10, 25, 50, "All"]
                    ],
                    dom: '<"row"lfB>rtip',
                    buttons: [{
                            extend: 'pdf',
                            text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'csv',
                            text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'print',
                            text: '<i title="print" class="fa fa-print"></i>',
                            exportOptions: {
                                columns: ':visible:Not(.not-exported)',
                                rows: ':visible'
                            },
                            footer: true
                        },
                        {
                            extend: 'colvis',
                            text: '<i title="column visibility" class="fa fa-eye"></i>',
                            columns: ':gt(0)'
                        },
                    ],
                });
            </script>
        @endif
    @endsection
