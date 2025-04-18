@extends('layouts.app')
@section('title', 'Manage GCA Action')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Manage GCA Action </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View GCA Details</li>
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
                <h3 class="mb-0">Gca Action  Details</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('gcadefectaction.partial.gcadefectaction-header-buttons')
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
                            <li class="list-group-item active">GCA Action  Details</li>
                            <li class="list-group-item">Date: <b>{{ dateFormat($details->vehicle->gca_completion_date) }}</b></li>
                            <li class="list-group-item">Vehicle Type: <b>{{$details->vehicle_type }}</b></li>
                            <li class="list-group-item">Vehicle: <b>{{$details->vehicle->vin_no }}</b></li>
                            <li class="list-group-item">Lot & Job: <b>{{$details->vehicle->lot_no . ', ' . $details->vehicle->job_no }}</b></li>
                            <li class="list-group-item">Shop: <b>{{$details->shop->report_name }}</b></li>
                            <li class="list-group-item">Category: <b>{{$details->auditCategory->name }}</b></li>
                            <li class="list-group-item">UPC/FCA/Sheet No: <b>{{$details->gca_manual_reference }}</b></li>
                            <li class="list-group-item">Teamleader: <b>{{ $details->responsible_team_leader }}</b></li>
                            <li class="list-group-item">Defect Count: <b>{{ $details->defect_count}}</b></li>
                            <li class="list-group-item">Defect Weight: <b>{{ $details->weight }}</b></li>
                            <li class="list-group-item">Status: <b>{{ ($details->is_corrected == 'No') ? 'Open' : 'Closed'}}</b></li>
                      
                       
                          </ul>
                    </div>
                </div>
              
             
            </div>
           
        </div>
        @if ($details->defect_image !=null)
            
      
        <div class="row">
            <div class="col-sm-6">

        <div class="card">
            <img class="card-img-top" src="{{ $details->DefectImageUri }}" alt="Card image cap">
           
          </div>
            </div>
        </div>
        @endif
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
