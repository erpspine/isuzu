@extends('layouts.app')
@section('title', 'Material  Lists')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Material  Lists </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Material  Lists</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
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
        <div class="content-header row pb-1">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="mb-0">Material  Lists</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('material_list.partial.material_list-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">

                        <ul class="list-group">
                            <li class="list-group-item active">  Details</li>
                            <li class="list-group-item">Case: <b>{{$details->pna_case }}</b></li>
                            <li class="list-group-item">Box: <b>{{$details->Box }}</b></li>
                            <li class="list-group-item">Partnumber: <b>{{$details->partnumber }}</b></li>
                            <li class="list-group-item">Description: <b>{{$details->Description }}</b></li>
                            <li class="list-group-item">Upc: <b>{{$details->upc }}</b></li>
                            <li class="list-group-item">FNA: <b>{{$details->FNA }}</b></li>
                            <li class="list-group-item">Qty/lot: <b>{{$details->qty_lot }}</b></li>
                            <li class="list-group-item">LOC1: <b>{{$details->LOC1 }}</b></li>
                            <li class="list-group-item">QTY1: <b>{{$details->QTY1 }}</b></li>
                            <li class="list-group-item">LOC2: <b>{{$details->LOC2 }}</b></li>
                            <li class="list-group-item">QTY2: <b>{{$details->QTY2 }}</b></li>
                            <li class="list-group-item">LOC3: <b>{{$details->LOC3 }}</b></li>
                            <li class="list-group-item">QTY3: <b>{{$details->QTY3 }}</b></li>
                            <li class="list-group-item">LOC4: <b>{{$details->LOC4 }}</b></li>
                            <li class="list-group-item">QTY4: <b>{{$details->QTY4 }}</b></li>
                            <li class="list-group-item">LOC5: <b>{{$details->LOC5 }}</b></li>
                            <li class="list-group-item">QTY5: <b>{{$details->QTY5 }}</b></li>
                            <li class="list-group-item">LOC6: <b>{{$details->LOC6 }}</b></li>
                            <li class="list-group-item">QTY6: <b>{{$details->QTY6 }}</b></li>
                            <li class="list-group-item">LOC7: <b>{{$details->LOC7 }}</b></li>
                            <li class="list-group-item">QTY7: <b>{{$details->QTY7 }}</b></li>
                            <li class="list-group-item">LOC8: <b>{{$details->LOC8 }}</b></li>
                            <li class="list-group-item">QTY8: <b>{{$details->QTY8 }}</b></li>
                            <li class="list-group-item">LOC9: <b>{{$details->LOC9 }}</b></li>
                            <li class="list-group-item">QTY9: <b>{{$details->QTY9 }}</b></li>
                            <li class="list-group-item">LOC10: <b>{{$details->LOC10 }}</b></li>
                            <li class="list-group-item">QTY10: <b>{{$details->QTY10 }}</b></li>
                            <li class="list-group-item">LOC11: <b>{{$details->LOC11 }}</b></li>
                            <li class="list-group-item">QTY11: <b>{{$details->QTY11 }}</b></li>
                            <li class="list-group-item">LOC12: <b>{{$details->LOC12 }}</b></li>
                            <li class="list-group-item">QTY12: <b>{{$details->QTY12 }}</b></li>



                          </ul>
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
            var tools = $('#tools').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('tcmjoint.index') }}',
                    data: function(d) {
                        // d.account_status = $('#account_status').val();
                    }
                },
                columnDefs: [{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
                columns: [{
                        data: 'tool_id',
                        name: 'tool_id'
                    },
                    {
                        data: 'part_name_joint_id',
                        name: 'part_name_joint_id'
                    },
                    {
                        data: 'station_used',
                        name: 'station_used'
                    },

                    {
                        data: 'models',
                        name: 'models'
                    },
                    {
                        data: 'upc',
                        name: 'upc'
                    },
                    {
                        data: 'sheet_no',
                        name: 'sheet_no'
                    },
                    {
                        data: 'mean_toque',
                        name: 'mean_toque'
                    },
                    {
                        data: 'upper_control_limit',
                        name: 'upper_control_limit'
                    },
                    {
                        data: 'lower_control_limit',
                        name: 'lower_control_limit'
                    },
                    {
                        data: 'upper_specification_limit',
                        name: 'upper_specification_limit'
                    },
                    {
                        data: 'lower_specification_limit',
                        name: 'lower_specification_limit'
                    },
                    {
                        data: 'sample_size',
                        name: 'sample_size'
                    },
                    {
                        data: 'frequency',
                        name: 'frequency'
                    },
                    {
                        data: 'kcds_code',
                        name: 'kcds_code'
                    },

                    {
                        data: 'action',
                        name: 'action'
                    }
                ],
            });


            $('table#appusers tbody').on('click', 'a.reset-password', function(e) {
                e.preventDefault();
                Swal.fire({
                    type: 'warning',
                    title: "Are You Sure",
                    showCancelButton: true,
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete.value) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "GET",
                            url: href,
                            dataType: "json",
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    appusers.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    } else {
                        Swal.fire('Passord not reset', '', 'info')
                    }
                });
            });
            $('table#tools tbody').on('click', 'a.delete-joint', function(e) {
                e.preventDefault();
                Swal.fire({
                    type: 'warning',
                    title: "Are You Sure",
                    showCancelButton: true,
                    buttons: true,
                    dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete.value) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "DELETE",
                            url: href,
                            dataType: "json",
                            data: {
                                '_token': '{{ csrf_token() }}',
                            },
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    tools.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    } else {
                        Swal.fire('Joint not deleted', '', 'info')
                    }
                });
            });
        </script>
    @endsection
