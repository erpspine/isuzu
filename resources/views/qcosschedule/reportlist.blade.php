@extends('layouts.app')
@section('title', 'Manage Tools')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Manage Tools </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Tools</li>
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
                <h3 class="mb-0">Manage Tools</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('qcosschedule.partial.qcosschedule-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="card">
            <div class="card-header">
                Filters
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('status', 'Ststus :') !!}
                                    {!! Form::select('status',  ['OK' => 'Ok', 'NOK' => 'NOK'], null, [
                                        'class' => 'form-control select2',
                                        'style' => 'width:100%',
                                        'id' => 'status',
                                        'placeholder' => 'Select Status',
                                    ]) !!}
                                </div>
                            </div>
                        
                            <div class="col-4">
                                <h4 class="card-title">Filter By Next Calibration Date :</h4>
                                <div class='input-group'>
                                    <input type='text' name="daterange" class="form-control shawCalRangese" readonly id="daterange" />

                                </div>

                            </div>


                      
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered " id="tools">
                                <thead>
                                    <tr>
                                   
                                        <th>ID</th>
                                        <th>Serial</th>
                                        <th>SKU</th>
                                        <th>Model</th>
                                        <th>Type</th>
                                        <th>Shop</th>
                                        <th>Last Calibration</th>
                                        <th>Next Calibration</th>
                                        <th>Days To Next Calibration</th>
                                     
                                    </tr>
                                </thead>
                            </table>
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
    {{ Html::script('assets/libs/moment/moment.js') }}
        {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
        {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
        <script type="text/javascript">
          $(function(){
        'use strict'
        $('.shawCalRangese').daterangepicker({
           autoUpdateInput: false,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')], 
        },
                alwaysShowCalendars: true,
              
            });
        });

        
        $('.shawCalRangese').on('apply.daterangepicker', function(ev, picker) {
      $(this).val(picker.startDate.format('DD/MM/YYYY') + '-' + picker.endDate.format('DD/MM/YYYY'));
      tools.ajax.reload();
  });

  $('.shawCalRangese').on('cancel.daterangepicker', function(ev, picker) {
      $(this).val('');
      tools.ajax.reload();
  });
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
                    url: '{{ route('scheduler.index') }}',
                    data: function(d) {
                        d.status = $('#status').val();
                        d.daterange = $('#daterange').val();
                        
                    }
                },
                columns: [{
                        data: 'tool_id',
                        name: 'tool_id'
                    },
                    {
                        data: 'serial_number',
                        name: 'serial_number'
                    },
                    {
                        data: 'sku',
                        name: 'sku'
                    },
                    {
                        data: 'tool_model',
                        name: 'tool_model'
                    },
                    {
                        data: 'tool_type',
                        name: 'tool_type'
                    },
                    {
                        data: 'shop',
                        name: 'shop'
                    },
                    {
                        data: 'last_calibration_date',
                        name: 'last_calibration_date'
                    },
                    {
                        data: 'next_calibration_date',
                        name: 'next_calibration_date'
                    },
                    {
                        data: 'days',
                        name: 'days'
                    }
                ],
                order: [
                    ['2', 'asc']
                ],
                'columnDefs': [{
                    "orderable": false,
                    "searchable": false,
                    'targets': [0]
                }],
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
            $('table#tools tbody').on('click', 'a.delete-tcm', function(e) {
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
                        Swal.fire('Tool not deleted', '', 'info')
                    }
                });
            });
            $(document).on('change', '#status',
                function() {
                    tools.ajax.reload();
                });
        </script>
    @endsection
