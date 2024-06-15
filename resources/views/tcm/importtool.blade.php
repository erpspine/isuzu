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
                <h3 class="mb-0">Import  Tools</h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('tcm.partial.tcm-header-buttons')
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
                            {{ Form::open(['route' => 'savetoolimport', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'school-import','files' => true]) }}
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
                                <a href="{{ asset('files/tool_upload_v1.csv') }}" class="btn btn-success" download><i class="fa fa-download"></i> Download template file</a>
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
                                    <td>Shop <small class="text-danger">(Required)</small></td>
                                    <td>Shop <b>(Ex: Body Shop)</b></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Tool Model <small class="text-danger">(Required)</small></td>
                                    <td>Tool Model</td>
                                </tr>
                           
                                <tr>
                                    <td>4</td>
                                    <td>Tool Type <small class="text-danger">(Required)</small></td>
                                    <td>Tool Type<br>
                                        <strong>1.CLICK WRENCH<br>
                                                2.PULSE TOOL</strong></td>
                                </tr>
                                <tr>
                                    <td>5</td>
                                    <td>Serial Number  <small class="text-warning">(Optional)</small></td>
                                    <td>Serial Number
                                    </td>
                                </tr>
                                <tr>
                                    <td>6</td>
                                    <td>SKU Number <small class="text-warning">(Optional)</small></td>
                                    <td>SKU Number
                                    </td>
                                </tr>
                           
                              
                                <tr>
                                    <td>7</td>
                                    <td>Last Calibration Date <small class="text-danger">(Required)</small></td>
                                    <td>Last Calibration Date<br>
                                        <b>Format: mm-dd-yyyy; Ex: 11-25-2010</b>
                                    </td>
                                </tr>
                                <tr>
                                    <td>8</td>
                                    <td>Frequency Of Calibration     <small class="text-danger">(Required)</small></td>
                                    <td>Enter in days  <b>(Ex: 30 )</b></td>
                                </tr>

                                <tr>
                                    <td>4</td>
                                    <td>Status <small class="text-danger">(Required)</small></td>
                                    <td>Status<br>
                                        <strong>1.OK<br>
                                                2.NOK</strong></td>
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
