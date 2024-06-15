@extends('layouts.app')
@section('title', 'Manage Joint')
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
                <h3 class="mb-0">Import  TCM Joint</h3>
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
            <div class="col-12">
                <div class="card">

                    @if (session('status') || !empty($status))
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert {{ (session('status.success')== 1) ? 'alert-success' : 'alert-danger'}}  " role="alert">
                                <div class="alert-body">
                                    @if(!empty($status['msg']))
                                    {{$status['msg']}}
                                @elseif(session('status.msg'))
                                    {{ session('status.msg') }}
                                @endif

                                </div>
                            </div>

                          
                        </div>  
                    </div>     
                @endif



               
                    @if (session('notification') || !empty($notification))
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="alert alert-danger" role="alert">
                               
                                <div class="alert-body">
                                    @if(!empty($notification['msg']))
                                    {{$notification['msg']}}
                                @elseif(session('notification.msg'))
                                    {{ session('notification.msg') }}
                                @endif

                                </div>
                            </div>

                          
                        </div>  
                    </div>     
                @endif

                    <div class="card-body">
                        <div class="card-body">
                            {{ Form::open(['route' => 'savetooljointimport', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'school-import','files' => true]) }}
                            <div class="card-body">
                                <div class="form-group row">
                                    <label for="rate" class="col-sm-4 text-right control-label col-form-label">File to import<span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        {!! Form::file('tools_upload',[
                                            'placeholder' => 'Select Tool To Import',
                                            'class' => 'form-control custom-select','id' => 'formFile','accept'=>'.xls, .xlsx, .csv', 'required' => 'required'
                                        ]) !!}
                                    </div>
                                </div>
                                <hr>
                                <div class="card-body">
                                    <div class="form-group mb-0 text-right">
                                        {{ Form::submit('Save', ['class' => 'btn btn-info btn-md', 'id' => 'submit-data']) }}
                                        {{ link_to_route('tcm.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
                                    </div>
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>


                        <div class="row">
                            <div class="col-sm-4">
                                <a href="{{ asset('files/tool_joint_upload_v1.csv') }}" class="btn btn-success" download><i class="fa fa-download"></i> Download template file</a>
                            </div>
                        </div>
                 


                           <!-- Input Sizing start -->
        <section id="input-sizing">
            <div class="row ">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
      
                            <table class="table table-striped">
                                <tr>
                                    <th>Column Number</th>
                                    <th>Column Name</th>
                                    <th>Instruction</th>
                                </tr>
                                <tr>
                                    <td>1</td>
                                    <td>Tool ID  <small class="text-danger">(Required)</small></td>
                                    <td>Tool ID </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Vehicle Model <small class="text-danger">(Required)</small></td>
                                    <td>Vehicle Model <b>(Ex: NLR77U-EE1AYN)</b></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Part Name/Joint ID <small class="text-danger">(Required)</small></td>
                                    <td>Part Name/Joint ID</td>
                                </tr>
                           
                                <tr>
                                    <td>4</td>
                                    <td>Station Used <small class="text-danger">(Required)</small></td>
                                    <td>Station Used</td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Upc  <small class="text-danger">(Required)</small></td>
                                    <td>Upc
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>Sheet  Number <small class="text-danger">(Required)</small></td>
                                    <td>Sheet Number
                                    </td>
                                </tr>
                           
                              
                                <tr>
                                    <td>7</td>
                                    <td>Mean Torque (Nm)<small class="text-danger">(Required)</small></td>
                                    <td>Mean Torque (Nm)
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Upper Control Limit (Nm)    <small class="text-danger">(Required)</small></td>
                                    <td>Upper Control Limit(Nm) </td>
                                </tr>

                                <tr>
                                    <td>9</td>
                                    <td>Lower Control Limit (Nm)<small class="text-danger">(Required)</small></td>
                                    <td>Lower Control Limit (Nm)</td>
                                </tr>
                                <tr>
                                    <td>10</td>
                                    <td>Upper Specification Limit (Nm)<small class="text-danger"> (Required)</small></td>
                                    <td>Upper Specification Limit (Nm)</td>
                                </tr>
                                <tr>
                                    <td>11</td>
                                    <td>Lower Specification Limit (Nm)<small class="text-danger"> (Required)</small></td>
                                    <td>Lower Specification Limit (Nm)</td>
                                </tr>
                                <tr>
                                    <td>12</td>
                                    <td>KCDS Code <small class="text-danger"> (Required)</small></td>
                                    <td><strong>1.PS1<br>
                                                2.PF1<br>
                                                3.PS2<br>
                                                4.PF2<br>
                                        </strong></td>
                                </tr>
                                <tr>
                                    <td>13</td>
                                    <td>Sample Size<small class="text-danger"> (Required)</small></td>
                                    <td>Sample Size</td>
                                </tr>
                                <tr>
                                    <td>14</td>
                                    <td>Frequency<small class="text-danger"> (Required)</small></td>
                                    <td>Frequency</td>
                                </tr>
                           
                           
                               
                             
            
                            </table>
            </div>
            </div>
        </div>
            </div>
        </section>



                   
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
                    url: '{{ route('tcm.index') }}',
                    data: function(d) {
                        // d.account_status = $('#account_status').val();
                    }
                },
                columnDefs: [{
                    "targets": 1,
                    "orderable": false,
                    "searchable": false
                }],
                columns: [
                    {
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
                        data: 'status',
                        name: 'status'
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
        </script>
        
    @endsection
