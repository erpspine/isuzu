<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Attendance & Overtime</title>
    @include('layouts.header.header')
    @yield('after-styles')
    {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
</head>

<body>
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles" style="background: #da251c;">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0 text-light" style="text-transform: uppercase;">{{ $shop }}</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item text-light"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active text-light">Record Attandance</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
                <div class="d-flex ml-2">
                    <div class="text-right d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                        <a href="/attendance_view" id="btn-add-contact" class="btn btn-info"><i
                                class="mdi mdi-arrow-left font-16 mr-1"></i> Back</a>
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
        <div class="row">
            <!-- Individual column searching (select inputs) -->
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <h4 class="card-title" style="color: #da251c; text-transform: uppercase;">
                                    {{ $shop }} for
                                    {{ \Carbon\Carbon::createFromTimestamp(strtotime($date))->format('d M Y') }}
                                    <span style="color:margin-left:20px;">({{ $marked }})</span>
                                </h4>
                            </div>
                            <div class="col-3">


                           <!-- <div class="col-md-8 text-right d-flex justify-content-md-end justify-content-center mb-1">
                                <a href="javascript:void(0)" id="btn-add-employee" class="btn btn-info"><i class="mdi mdi-account-multiple-plus font-16 mr-1"></i> Add Employee</a>
                        </div>-->
                    </div>


                            <div class="col-4">
                                <h4 class="card-title float-right" style="color: #da251c; text-transform: uppercase;">
                                    <span class="text-primary" style="margin-left:20px;">({{ $dayname }})</span>
                                    {{ $prodday ? 'Production Scheduled' : 'No Production' }}
                                </h4>
                            </div>
                        </div>
                        {!! Form::open(['action' => ['App\Http\Controllers\attendance\AttendanceController@store'], 'method' => 'post']) !!}
                        {{ csrf_field() }}
                        <input type="hidden" value="{{ $date }}" name="date">
                        <input type="hidden" value="{{ $shopid }}" name="shop_id">
                        <input type="hidden" value="{{ $indirectshop }}" name="shop_type[]" id="shop_type">
                        <div class="table-responsive" id="saman-row-inv">
                            <table class="table table-striped table-bordered datatable-select-inputs1">
                                <thead>
                                    <tr>
                                        <td>No.</td>
                                        <th>Staff No</th>
                                        <th>Staff Name</th>
                                        <th>Normal Production Hrs</th>
                                        <th>Overtime</th>
                                        <th>Authorised Hrs</th>
                                        <th>OT Intershop Loaning</th>
                                        <th>Normal Hrs Intershop Loaning</th>
                                        <th>Total Hrs</th>
                                        @if ($shop_type=='Yes')<th class="text-center">#</th>@endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($staffs != null)
                                        @foreach ($staffs as $item)
                                            <input type="hidden" name="num" value="{{ $num++ }}">
                                            <!--NOT MARKED-->
                                            @if ($marked == 'Not marked')
                                            @if ($indirectshop == '')
                                           
                                            @include('attendances.partials.form-indirect')
                                        @else
                                            <input type="hidden" value="direct" name="shop_type[]"
                                                id="shop_type">
                                            @if ($item->team_leader == 'yes')
                                                @include('attendances.partials.form-team-leader')
                                            @else
                                                @include('attendances.partials.form-noteam-leader')
                                            @endif
                                        @endif

                                            @else

                                            @if ($indirectshop == '')
                                            
                                            @include('attendances.partials.form-indirect')
                                        @else
                                        
                                            <input type="hidden" value="direct" name="shop_type[]"
                                                id="shop_type">
                                            @if ($item->employee->team_leader == 'yes' )
                                                @include('attendances.partials.form-team-leader')
                                            @else
                                                @include('attendances.partials.form-noteam-leader')
                                            @endif
                                        @endif
                                            @endif



                                          
                                            
                                          
                                        @endforeach
                                    @endif

                                    @if ($shop_type=='Yes')
                                    <tr class="last-item-row-inv sub_c">
                                        <td class="add-row" colspan="3">
                                            <button type="button" class="btn btn-warning" aria-label="Left Align"
                                                id="add-row">
                                                <i class="fa fa-plus-square"></i> Add Row
                                            </button>
                                        </td>
                                    </tr>
                                        
                                    @endif
                                 
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>No.</td>
                                        <th>Staff No</th>
                                        <th>Staff Name</th>
                                        <th>Normal Production Hrs</th>
                                        <th>Overtime</th>
                                        <th>Authorised Hrs</th>
                                        <th>OT Intershop Loaning</th>
                                        <th>Normal Hrs Intershop Loaning</th>
                                        <th>Total Hrs</th>
                                        @if ($shop_type=='Yes')<th>#</th>@endif
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="row">
                            <input type="hidden" value="{{ $num }}" name="counter" id="invpganak">
                            <input type="hidden" value="{{ route('searchemployee') }}" id="Billtype">
                            <input type="hidden" value="{{ $indirect }}" name="indirect_value"
                                id="indirect_value">
                            <input type="hidden" value="{{ $overtime }}" name="overtime_value"
                                id="overtime_value">
                            <div class="col-md-6 col-12 align-self-center d-none d-md-block">
                                <div class="form-input">
                                    <textarea name="workdescriptionall" rows="3" required placeholder="Work description here..."
                                        class="form-control">{{ $attstatus != '' ? $attstatus->workdescription : '' }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6 col-12 align-self-center d-none d-md-block">
                                <div class="d-flex mt-2 justify-content-end">
                                    @if ($attstatus == '' || $attstatus->status_name == 'saved')
                                        <div class="d-flex ml-2">
                                            <div
                                                class="text-right d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                                                <button name="button" value="submitted" id="btn-add-contact"
                                                    class="btn btn-primary"><i
                                                        class="mdi mdi-content-save-all font-16 mr-1"></i>Save &
                                                    Submit</button>
                                            </div>
                                        </div>
                                        <div class="d-flex ml-2">
                                            <div
                                                class="text-right d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                                                <button value="saved" name="button" id="btn-add-contact"
                                                    class="btn btn-lighten-2 text-white" style="background:teal;">
                                                    <i class="mdi mdi-content-save-all font-16 mr-1"></i>Save</button>
                                            </div>
                                        </div>
                                    @elseif($attstatus->status_name == 'review' || $attstatus->status_name == 'savedreveiw')
                                        <div class="d-flex ml-2">
                                            <div
                                                class="text-right d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                                                <button type="button" id="btn-add-contact" data-toggle="modal"
                                                    data-target="#myModal"
                                                    class="btn btn-lighten-2 text-white btn-warning">
                                                    <i class="mdi mdi-content-save-all font-16 mr-1"></i>Check Response
                                                    & Resubmit</button>
                                            </div>
                                        </div>
                                        <div class="d-flex ml-2">
                                            <div
                                                class="text-right d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                                                <button type="submit" value="savedreveiw" name="button"
                                                    id="btn-add-contact" class="btn btn-lighten-2 text-white"
                                                    style="background:teal;">
                                                    <i class="mdi mdi-content-save-all font-16 mr-1"></i>Save</button>
                                            </div>
                                        </div>
                                    @elseif($attstatus->status_name == 'submitted')
                                        <h3>Awaiting Approval...</h3>
                                    @elseif($attstatus->status_name == 'approved')
                                        <h3>Approved</h3>
                                        <div class="d-flex ml-2">
                                            <div
                                                class="text-right d-flex justify-content-md-end justify-content-center mt-3 mt-md-0">
                                                <button type="button" id="btn-add-contact" data-toggle="modal"
                                                    data-target="#myModal"
                                                    class="btn btn-lighten-2 text-white btn-warning">
                                                    <i
                                                        class="mdi mdi-content-save-all font-16 mr-1"></i>Conversation</button>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- sample modal content -->
                                <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
                                    aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myModalLabel">Reveiw Instruction/Concern
                                                </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="card">
                                                    <div class="comment-widgets scrollable position-relative"
                                                        style="height: 350px;">
                                                        <!-- Comment Row -->
                                                        @if (count($conversation) > 0)
                                                            @foreach ($conversation as $item)
                                                                @if ($item->sender == 'groupleader')
                                                                    <div class="d-flex flex-row comment-row p-3">
                                                                        <div class="p-2"><span
                                                                                class="round text-white d-inline-block text-center"><img
                                                                                    src="../assets/images/users/user3.jpg"alt="user"
                                                                                    width="50"
                                                                                    class="rounded-circle"></span>
                                                                        </div>
                                                                        <div
                                                                            class="comment-text w-100 py-1 py-md-3 pr-md-3 pl-md-4 px-2 bg-light-success">
                                                                            <h5>{{ $item->user->name }}</h5>
                                                                            <p class="mb-1">{{ $item->message }}</p>
                                                                            <div class="comment-footer">
                                                                                <span
                                                                                    class="text-muted float-right">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('M d, Y H:i:s') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @elseif($item->sender == 'teamleader')
                                                                    <div class="d-flex flex-row comment-row p-3">
                                                                        <div class="p-2"><span
                                                                                class="round text-white d-inline-block text-center"><img
                                                                                    src="../assets/images/users/user3.jpg"alt="user"
                                                                                    width="50"
                                                                                    class="rounded-circle"></span>
                                                                        </div>
                                                                        <div
                                                                            class="comment-text w-100 py-1 py-md-3 pr-md-3 pl-md-4 px-2 bg-light-info">
                                                                            <h5>{{ $item->user->name }}</h5>
                                                                            <p class="mb-1">{{ $item->message }}</p>
                                                                            <div class="comment-footer">
                                                                                <span
                                                                                    class="text-muted float-right">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $item->created_at)->format('M d, Y H:i:s') }}</span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <!-- Comment Row -->
                                                        @if ($attstatus == '' || $attstatus->status_name != 'approved')
                                                            <div class="d-flex flex-row comment-row p-3 active">
                                                                <div class="p-2"><span
                                                                        class="round text-white d-inline-block text-center"><img
                                                                            src="../assets/images/users/user3.jpg"
                                                                            alt="user" width="50"
                                                                            class="rounded-circle"></span></div>
                                                                <div class="comment-text active w-100">
                                                                    <h5>{{ Auth()->User()->name }}</h5>
                                                                    <input type="hidden" name="statusid"
                                                                        value="{{ $attstatus ? $attstatus->id : '' }}">
                                                                    <input type="hidden" name="sender"
                                                                        value="teamleader">
                                                                    <input type="hidden" name="status"
                                                                        value="submitted">
                                                                    <textarea name="message" rows="3" placeholder="Reveiw instructions here..." class="form-control"></textarea>
                                                                    <div class="comment-footer ">
                                                                        <span
                                                                            class="text-muted float-right">{{ \Carbon\Carbon::today()->format('M d, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-light"
                                                    data-dismiss="modal">Close</button>
                                                @if ($attstatus == '' || $attstatus->status_name != 'approved')
                                                    <button type="submit" name="button" value="reveiwsubmitted"
                                                        class="btn btn-primary">Send</button>
                                                @endif
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->



                                
                            </div>
                        </div>
                        {!! Form::close() !!}

                               <!-- Modal Add Employee -->
                    <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Add Employee</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {!! Form::open(['route' => 'addemployeemodal', 'method' => 'post', 'id' => 'create-user' ]) !!}
                                <div class="modal-body">
                                    <input type="hidden" value="{{ $shopid }}" name="shop_id">
                                    <div class="add-contact-box">
                                        <div class="add-contact-content">
                                          
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="staff-number">
                                                            <input type="text" name="staff_no" id="s-number" class="form-control" placeholder="Staff Number" required>
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="staff-Name">
                                                            <input type="text" name="staff_name" id="c-email" class="form-control" placeholder="Staff name" required>
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <div class="category">

                                                            {!! Form::select('Category',['Direct'=>'Direct','Indirect'=>'Indirect'],null,['placeholder' => '-- Category --', 'class'=>' form-control','id'=> 'title','required'=>'required']) !!}

                                                           
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="contact-phone">
                                                            {!! Form::select('attachee',['no'=>'No','yes'=>'Yes'],null,['placeholder' => '-- Attachee --', 'class'=>' form-control','id'=> 'attache','required'=>'required']) !!}
                                                            <span class="validation-text"></span>
                                                        </div>
                                                    </div>
                                                </div>

                                             

                                             
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                               
                                    {{ Form::submit('Save ', ['class' => 'btn btn-success data-submit','id'=>'submit-data']) }}
                                    <button class="btn btn-danger" data-dismiss="modal"> Discard</button>
                                </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footer.script')
        @yield('after-scripts')
        @yield('extra-scripts')
        @section('after-styles')
            {{ Html::script('dist/js/pages/datatable/datatable-basic.init.js') }}
            {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
            {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
            {{ Html::style('assets/extra-libs/jquery-ui/jquery-ui.min.css') }}
            <style>
                .select2-container .select2-selection--single {
                    height: 34px !important;
                }

                .select2-container .select2-selection--single .select2-selection__rendered {
                    padding: 0 0 0 12px !important;
                }

                .hide {
                    display: none;
                }
            </style>
            {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
            {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
            {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
            {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
            {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
            {{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
            {{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
            {{ Html::script('assets/extra-libs/jquery-ui/jquery-ui.min.js') }}

            
            <script type="text/javascript">
                $(".select2").select2();
            </script>
            {!! Toastr::message() !!}
            <script>
                $(function() {
                    "use strict";
                    //SUM DIRECT AND INDIRECT
                    $(document).on('change keyup blur', '.normalhrs', function() {
                        var id_arr = $(this).attr('id');
                        var id = id_arr.split('_');
                        var directmh = $('#direct_' + id[1]).val();
                        var indirectmh = $('#indirect_' + id[1]).val();
                     
                        if (directmh == '') {
                            directmh = 0;
                        }
                        if (indirectmh == '') {
                            indirectmh = 0;
                        }

                     
                        var tot = parseInt(directmh) + parseInt(indirectmh);
                      
                        if (tot > 8) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Hours exceeds the normal hours (8 hours)',
                                footer: 'Please enter correct values.'
                            })
                            $(this).val("");
                        }
                    });
                    //INTERSHOP LOANING DIRECT
                    $(document).on('change', '.interloandir', function() {
                        var id_arr = $(this).attr('id');
                        var id = id_arr.split('_');
                        var over = $('#dirshopto_' + id[1]).val();
                        if (over == 0) {
                            $('#loandir_' + id[1]).attr('readonly', true);
                        } else {
                            $('#loandir_' + id[1]).attr('readonly', false);
                        }
                    });
                    //INTERSHOP LOANING OVERTIME
                    $(document).on('change', '.interloanover', function() {
                        var id_arr = $(this).attr('id');
                        var id = id_arr.split('_');
                        var over = $('#overshopto_' + id[1]).val();
                        if (over == 0) {
                            $('#loanov_' + id[1]).attr('readonly', true);
                        } else {
                            $('#loanov_' + id[1]).attr('readonly', false);
                        }
                    });
                    //CHECKING TOTAL
                    $(document).on('change keyup blur', '.hrs', function() {
                        var id_arr = $(this).attr('id');
                        var id = id_arr.split('_');
                        var directmh = $('#direct_' + id[1]).val();
                        var indirectmh = $('#indirect_' + id[1]).val();
                        var overtime = $('#overtime_' + id[1]).val();
                        var indovertime = $('#indovertime_' + id[1]).val();
                        var loandir = $('#loandir_' + id[1]).val();
                        var loanov = $('#loanov_' + id[1]).val();

                        console.log(loandir);
                        if (directmh == '') {
                            directmh = 0;
                        }
                        if (indirectmh == '') {
                            indirectmh = 0;
                        }
                        if (overtime == '') {
                            overtime = 0;
                        }
                        if (indovertime == '') {
                            indovertime = 0;
                        }
                        if (loanov == '') {
                            loanov = 0;
                        }
                        if (loandir == '') {
                            loandir = 0;
                        }
                      
                        var tot = parseInt(directmh) + parseInt(indirectmh) + parseInt(overtime) + parseInt(indovertime) + parseInt(loanov) + parseInt(loandir);
                       // console.log(parseInt(tot));


                        $('#total' + id[1]).html(tot);
                        var limit = parseInt("{{ round($hrslimit) }}");



                        //alert(limit);
                        if (tot > limit) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                text: 'Hours exceeds the acceptable hous of work.',
                                footer: 'Please enter correct values.'
                            })
                            $(this).val("");
                            //  return;
                        }

                    });
                });



                $(document).on('click', '.deloutsource', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: "Are you sure?",
                        text: "You will not be able to recover this staff details!",
                        type: "warning",
                        //buttons: true,
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Yes, Delete!",
                        cancelButtonText: "No, cancel please!",
                        closeOnConfirm: false,
                        closeOnCancel: false
                        //dangerMode: true,
                    }).then((result) => {
                        if (Object.values(result) == 'true') {
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
                                        //routingquery.ajax.reload();
                                        window.location = "attendance_view";
                                    } else {
                                        toastr.error(result.msg);
                                    }
                                }
                            });
                        }
                    });
                });
                $(document).on('click', '.assetdetails', function() {
                    $(this).parents('.input-group').next('.assetdetails-con').toggle();
                });
                $(document).on("click", ".remove_inv_row", function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You Want To Remove Employee From This List?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, Remove!',
                    }).then((willDelete) => {
                        if (willDelete.value) {
                            $(this).closest("tr").remove(); // remove row
                        } else {
                            Swal.fire('Employee Not Removed!!', '', 'info')
                        }
                    });
                });
                $('#add-row').on('click', function() {
                    var cvalue = parseInt($('#invpganak').val()) + 1;
                    var shop_type = $('#shop_type').val();
                    var indirect_value = $('#indirect_value').val();
                    var overtime_value = $('#overtime_value').val();
                    var billtype = $('#Billtype').val();
                    var nxt = parseInt(cvalue);
                    $('#invpganak').val(nxt);
                    var functionNum = "'" + cvalue + "'";
                    count = $('#saman-row-inv div').length;
                    // console.log(shop_type);
                    if (shop_type == '') {
                        //Indirect Shop
                        var data = '<tr><td colspan="3"> <input type="text" name="employeeno[]" id="employeeno_' + cvalue +
                            '"  class="form-control" autocomplete="off" placeholder="Search Emp By Name Or Number" ></td> <td><input type="text" class="form-control normalhrs hrs" value="' +
                            indirect_value +
                            '" name="indirect_hrs[]" id="indirect_' +
                            cvalue +
                            '" disabled > <input type="hidden" name="direct_hrs[]" class="form-control normalhrs hrs" autocomplete="off" placeholder="Direct" id="direct_' +
                            cvalue + '" value="0" required></td><td><input type="text" id="indovertime_' + cvalue +
                            '" name="indirect_othours[]" class="form-control hrs" autocomplete="off" placeholder="Indirect" disabled required><input type="hidden" id="overtime_' +
                            cvalue +
                            '" name="othours[]" class="form-control hrs" autocomplete="off" placeholder="Direct" value="0" required></td><td><div class="input-group"><input type="text" name="auth_othrs[]" class="form-control" id="authhrs_' +
                            cvalue +
                            '" value="' + overtime_value +
                            '" placeholder="Hours" aria-describedby="basic-default-password" disabled /><span class="input-group-text cursor-pointer"><i class="mdi mdi-clipboard-text assetdetails"></i></span></div><div class="assetdetails-con assetdetails-con_' +
                            overtime_value +
                            ' hide"><textarea class="form-control" name="workdescription[]" id="assetdescription-' +
                            overtime_value +
                            '" placeholder="Description"maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"></textarea></div></td><td><div class="col-lg-12 col-md-12 col-12"><div class="input-group mb-3"><div class="input-group-prepend"><select class="interloanover" id="overshopto_' +
                            cvalue +
                            '" name="otshop_loaned_to[]" style="width: 100%;" disabled><option value="0">Select shop</option></select></div><input type="text" readonly autocomplete="off"  id="loanov_' +
                            cvalue +
                            '" name="otloaned_hrs[]" class="form-control hrs" placeholder="Hrs"></div></div></td><td><div class="col-lg-12 col-md-12 col-12"><div class="input-group mb-3"><div class="input-group-prepend"><select class="interloandir" id="dirshopto_' +
                            cvalue +
                            '" name="shop_loaned_to[]" style="width: 100%;" disabled><option value="0">Select shop</option></select></div><input type="text" readonly autocomplete="off"  id="loandir_' +
                            cvalue +
                            '" name="loaned_hrs[]" class="form-control hrs" placeholder="Hrs"></div></div></td><td><span  id="total' +
                            cvalue +
                            '"></span> 0 Hrs</td><td class="text-center"><div class="action-btn"><a href="javascript:void(0)" class="text-danger remove_inv_row ml-2"><i class="mdi mdi-delete font-20"></i></a></div></td><input type="hidden" name="unit_fix_price[]" value="1" id="unit_fix_price-' +
                            cvalue + '"><input type="hidden" name="staff_id[]" id="staffid_' + cvalue +
                            '"><input type="hidden" name="marked_id[]"  class="form-control"  id="markedid_' + cvalue +
                            '" ></tr>';
                    } else {

                        //Direct Shop
                        var data = '<tr><td colspan="3"> <input type="text" name="employeeno[]" id="employeeno_' + cvalue +
                            '"  class="form-control" autocomplete="off" placeholder="Search Emp By Name Or Number" ></td> <td><div class="input-group"><input type="text" id="direct_' +
                            cvalue +
                            '" name="direct_hrs[]" value="{{ $direct }}"class="form-control normalhrs hrs" autocomplete="off" placeholder="Direct" required disabled><input type="text" name="indirect_hrs[]" class="form-control normalhrs hrs" autocomplete="off"placeholder="Indirect" id="indirect_' +
                            cvalue +
                            '" required disabled></div></td><td><div class="input-group"><input type="text" id="overtime_' +
                            cvalue +
                            '" name="othours[]" class="form-control hrs"autocomplete="off" placeholder="Direct" required disabled><input type="text" id="indovertime_' +
                            cvalue +
                            '" name="indirect_othours[]" class="form-control hrs" autocomplete="off" placeholder="Indirect" required disabled></div></td><td><div class="input-group"><input type="text" name="auth_othrs[]" class="form-control" id="authhrs_' +
                            cvalue +
                            '" value="' + overtime_value +
                            '" placeholder="Hours" aria-describedby="basic-default-password" disabled /><span class="input-group-text cursor-pointer"><i class="mdi mdi-clipboard-text assetdetails"></i></span></div><div class="assetdetails-con assetdetails-con_' +
                            overtime_value +
                            ' hide"><textarea class="form-control" name="workdescription[]" id="assetdescription-' +
                            overtime_value +
                            '" placeholder="Description"maxlength="255" style="margin-top:5px;padding:5px 10px;height:60px;"></textarea></div></td><td><div class="col-lg-12 col-md-12 col-12"><div class="input-group mb-3"><div class="input-group-prepend"><select class="interloanover" id="overshopto_' +
                            cvalue +
                            '" name="otshop_loaned_to[]" style="width: 100%;" disabled><option value="0">Select shop</option></select></div><input type="text" readonly autocomplete="off"  id="loanov_' +
                            cvalue +
                            '" name="otloaned_hrs[]" class="form-control hrs" placeholder="Hrs"></div></div></td><td><div class="col-lg-12 col-md-12 col-12"><div class="input-group mb-3"><div class="input-group-prepend"><select class="interloandir" id="dirshopto_' +
                            cvalue +
                            '" name="shop_loaned_to[]" style="width: 100%;" disabled><option value="0">Select shop</option></select></div><input type="text" readonly autocomplete="off"  id="loandir_' +
                            cvalue +
                            '" name="loaned_hrs[]" class="form-control hrs" placeholder="Hrs"></div></div></td><td><span  id="total' +
                            cvalue +
                            '"></span> 0 Hrs</td><td class="text-center"><div class="action-btn"><a href="javascript:void(0)" class="text-danger remove_inv_row ml-2"><i class="mdi mdi-delete font-20"></i></a></div></td><input type="hidden" name="unit_fix_price[]" value="1" id="unit_fix_price-' +
                            cvalue + '"><input type="hidden" name="staff_id[]" id="staffid_' + cvalue +
                            '"><input type="hidden" name="marked_id[]"  class="form-control"  id="markedid_' + cvalue +
                            '" ></tr>';


                    }
                    //ajax request
                    // $('#saman-row').append(data);
                    $('tr.last-item-row-inv').before(data);
                    row = cvalue;
                    $('#employeeno_' + cvalue).autocomplete({
                        source: function(request, response) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                url: billtype,
                                dataType: "json",
                                method: 'post',
                                data: 'keyword=' + request.term,
                                success: function(data) {
                                    response($.map(data, function(item) {
                                        return {
                                            label: item.name,
                                            value: item.name,
                                            data: item
                                        };
                                    }));
                                }
                            });
                        },
                        autoFocus: true,
                        minLength: 0,
                        select: function(event, ui) {
                            id_arr = $(this).attr('id');
                            id = id_arr.split("_");
                            $('#staffid_' + id[1]).val(ui.item.data.id);
                            $("#indirect_" + id[1]).prop('disabled', false);
                            $("#direct_" + id[1]).prop('disabled', false);
                            $("#indovertime_" + id[1]).prop('disabled', false);
                            $("#overtime_" + id[1]).prop('disabled', false);
                            $("#authhrs_" + id[1]).prop('disabled', false);
                            $("#overshopto_" + id[1]).prop('disabled', false);
                            $("#dirshopto_" + id[1]).prop('disabled', false);

                            $(".invdetails-con-" + id[1]).show();
                            //units
                            $("#overshopto_" + id[1]).find('option').not(':first').remove();
                            $("#dirshopto_" + id[1]).find('option').not(':first').remove();
                            $("#overshopto_" + id[1]).select2();
                            $("#dirshopto_" + id[1]).select2();
                            // AJAX request 
                            $.ajax({
                                url: "{{ route('loadshops') }}",
                                type: 'get',
                                dataType: 'json',
                                success: function(response) {
                                    var len = 0;
                                    if (response['data'] != null) {
                                        len = response['data'].length;
                                    }
                                    if (len > 0) {
                                        // Read data and create <option >
                                        for (var i = 0; i < len; i++) {
                                            //console.log(response['data'][i].id);
                                            var id = response['data'][i].id;
                                            var name = response['data'][i].report_name;
                                            var option = "<option value='" + id + "'  >" + name +
                                                "</option>";
                                            $("#overshopto_" + cvalue).append(option);
                                            $("#dirshopto_" + cvalue).append(option);
                                        }
                                    }
                                }
                            });
                            $(".details-con_" + cvalue).show();
                        },
                        create: function(e) {
                            $(this).prev('.ui-helper-hidden-accessible').remove();
                        }
                    });
                });

                $('#btn-add-employee').on('click', function(event) {
                   
		$('#addContactModal #btn-add').show();
		$('#addContactModal #btn-edit').hide();
		$('#addContactModal').modal('show');
	})


    $(document).on('submit', 'form#create-user', function(e){
            e.preventDefault();
            $("#submit-data").hide();
            var data = $(this).serialize();
            $.ajax({
                method: "post",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                success:function(result){
                    if(result.success == true){
                     
                        toastr.success(result.msg);
                    
                        $('#addContactModal').modal('hide');
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });
            </script>
