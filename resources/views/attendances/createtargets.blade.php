

@extends('layouts.app')
@section('title','Set Targets')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h4 class="text-themecolor mb-0">PRODUCTION TARGETS</h4>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">SET TARGETS</li>
            </ol>
        </div>

    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">

        <div class="col-sm-8 col-md-12">



            <div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <h6>SET PRODUCTION TARGETS</h6>
                            <form action="{{ route('savetargets') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                            <div class="row">
                                <div class="col-3"></div>
                                <label for="description" class="col-sm-2 text-right control-label col-form-label">Choose Month:</label>
                                <div class="col-6">

                                    <div class="input-group">
                                        <input type="text" required name="month" class="form-control form-control-1 input-sm from bg-white" readonly
                                        value="{{$selectedmonth}}" autocomplete="off" />
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <span class="ti-calendar"></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-1"></div>
                            </div>
                            <hr>
                            <div class="form-group col-md-12">
                            <div class="form-group row">
                                <label for="description" class="col-sm-3 text-left control-label col-form-label">Plant Targets:</label>
                                <div class="col-sm-4">
                                    {{Form::text('pefficiency', '', ['class'=>'form-control', 'id'=>'code', 'placeholder'=>'Efficiency target here',
                                    'autocomplete'=>'off','required'=>'required'])}}
                                </div>
                                <div class="col-sm-4">
                                    {{Form::text('pabsentieesm', '', ['class'=>'form-control', 'id'=>'code', 'placeholder'=>'Absentieesm target here',
                                    'autocomplete'=>'off','required'=>'required'])}}
                                </div>
                                <div class="col-sm-4">
                                    {{Form::hidden('ptlavailability', 00, ['class'=>'form-control', 'id'=>'code', 'placeholder'=>'T/L Availability target here',
                                    'autocomplete'=>'off','required'=>'required'])}}
                                </div>
                            </div>
                            </div>

                            <hr>

                                <button class="btn btn-success" id="savetarget">Save Targets</button>
                            </form>

                        </div>
                        </div>
                    </div>

                    <hr>

                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">

                                <div class="table-responsive">
                                    <table class="table">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>#</th>
                                                <th class="text-center">MONTH</th>
                                                <th class="text-center">EFFICIENCY TARGET</th>
                                                <th class="text-center">ABSENTIEESM TARGET</th>
                                                <th class="text-center">ACTION</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($thisyeartargets))
                                                @foreach ($thisyeartargets as $pl)
                                                <tr>
                                                    <td>{{'#'}}</td>
                                                    <td class="text-center">{{\Carbon\Carbon::createFromFormat('Y-m-d',$pl->month)->format('F Y');}}</td>
                                                    <td class="text-center">{{$pl->efficiency}}</td>
                                                    <td class="text-center">{{$pl->absentieesm}}</td>
                                                    <td class="text-center">
                                                        <a href="{{route('destroytag', $pl->id)}}"
                                                            class="btn btn-outline-danger btn-sm pull-right deltarget"><i
                                                            class="fa fa-trash"></i></a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            @endif


                                        </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>

                    </div>


            </div>

        @endsection
        @section('after-styles')
        {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
        {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
        {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
        {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
        @endsection

        @section('after-scripts')
         {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
        {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
        {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
        {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
        {{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
        {!! Toastr::message() !!}


        <script type="text/javascript">
            $('.from').datepicker({
                autoclose: true,
                minViewMode: 1,
                format: "MM yyyy",
            });


            $(".select2").select2();

            $(document).on('click', '.deltarget', function(e){

            e.preventDefault();
            var txt = "You will delete the target from the system!";
            var btntxt = "Yes, Delete!";
            var color = "#DD6B55";

            Swal.fire({
                title: "Are you sure?",
                text: txt,
                type: "warning",
            //buttons: true,
            showCancelButton: true,
            confirmButtonColor: color,
            confirmButtonText: btntxt,
            cancelButtonText: "No, cancel please!",
            closeOnConfirm: false,
            closeOnCancel: false

            //dangerMode: true,
            }).then((result) => {
                if (Object.values(result) == 'true') {
                    var href = $(this).attr('href');
                    $.ajax({
                        method: "POST",
                        url: href,
                        dataType: "json",
                        data:{

                        '_token': '{{ csrf_token() }}',
                            },
                        success: function(result){
                            if(result.success == true){
                                toastr.success(result.msg);
                                //routingquery.ajax.reload();
                                window.location = "createtargets";
                            } else {
                                toastr.error(result.msg);
                            }
                        }
                    });
                }
            });
        });

        </script>
        @endsection



