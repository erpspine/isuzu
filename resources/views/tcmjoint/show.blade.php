@extends('layouts.app')
@section('title', 'Manage Joints')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Manage Joints </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">View Joints</li>
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
                <h3 class="mb-0">Joint Details</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('tcmjoint.partial.tcmjoint-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                       
                        <ul class="list-group">
                            <li class="list-group-item active">Joint Details</li>
                            <li class="list-group-item">Joint ID: <b>{{$details->part_name_joint_id }}</b></li>
                            <li class="list-group-item">Tool ID:  <b>{{ $details->tool->tool_id }}</b></li>
                            <li class="list-group-item">Station ID:  <b>{{ $details->station_used }}</b></li>
                            <li class="list-group-item">UPC:  <b>{{ $details->upc }}</b></li>
                            <li class="list-group-item">Sheet Number:  <b>{{ $details->sheet_no }}</b></li>
                            <li class="list-group-item">Mean Torque:  <b>{{ $details->mean_toque }}</b></li>
                            <li class="list-group-item">UCL(Nm):  <b>{{ $details->upper_control_limit }}</b></li>
                            <li class="list-group-item">LCL(NM):  <b>{{ $details->lower_control_limit }}</b></li>
                            <li class="list-group-item">USL(NM):  <b>{{ $details->upper_specification_limit }}</b></li>
                            <li class="list-group-item">LSL(NM):  <b>{{ $details->lower_specification_limit }}</b></li>
                            <li class="list-group-item">Sample Size:  <b>{{ $details->sample_size }}</b></li>
                            <li class="list-group-item">Kcds Code:  <b>{{ $details->kcds_code }}</b></li>
                       
                          </ul>
                    </div>
                </div>
              
             
            </div>
            <div class="col-lg-4">
            
                <div class="card">
                    <div class="card-body text-center">
                        <h4 class="card-title">Image</h4>
                        <div class="profile-pic mb-3 mt-3">
                            <img src="{{asset('upload/qcos/'.$details->image_one)}}" width="150" class="rounded-circle" alt="user">
                           
                          
                        </div>
                   
                    </div>
              
                </div>

                <div class="card">
                    <div class="card-body">
                        <ul class="list-group">
                            <li class="list-group-item active">Vehicle Models Models</li>
                            @foreach ($tool_models as $data )
                            <li class="list-group-item"> <b>{{$data->model->model_name }}</b></li>
                                
                            @endforeach
                           
                            
                       
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
