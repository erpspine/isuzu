
@extends('layouts.app')

@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">GCA SCORE TARGET</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">SETTING GCA TARGET</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">

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
                    {{ Form::open(['route' => 'gcatarget', 'method' => 'GET'])}}
                            {{ csrf_field(); }}
                            <div class="row">
                               
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('status', 'Quarter :') !!}
                                            {!! Form::select('target_name', ['Q1' => 'Q1', 'Q2' => 'Q2','Q3' => 'Q3','Q4' => 'Q4'], null, [
                                                'class' => 'form-control select2',
                                                'style' => 'width:100%',
                                                'id' => 'status',
                                                'placeholder' => 'Status',
                                            ]) !!}
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('month', 'From Date:') !!}
                                            {{ Form::text('month', $selectedmonth, ['class' => 'form-control from', 'placeholder' => 'From', 'required' => 'required', 'autocomplete' => 'off']) }}

                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            {!! Form::label('to_date', 'To Date:') !!}
                                            {{ Form::text('to_date', $selectedmonth, ['class' => 'form-control  from', 'placeholder' => 'From', 'required' => 'required', 'autocomplete' => 'off']) }}
                                        </div>
                                    </div>
                              
                                
                                </div>
                         


                             
                            <hr/>
                    <div class="row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-4"><h5>DPV</h5></div>
                        <div class="col-sm-4 float-right"><h5>WDPV</h5></div>
                        <div class="col-sm-2"></div>

                        <div class="col-sm-2"><h4 class="float-right">CV:</h4></div>
                        <div class="col-sm-4 mb-2">
                            {{ Form::text('cvdpv', null, ['class' => 'form-control', 'placeholder' => 'CV DPV target here...','required'=>'required','autocomplete'=>'off']) }}
                        </div>
                        <div class="col-sm-4 mb-2">
                            {{ Form::text('cvwdpv', null, ['class' => 'form-control', 'placeholder' => 'CV WDPV target here...','required'=>'required','autocomplete'=>'off']) }}
                        </div>
                        <div class="col-sm-2"></div>

                        <div class="col-sm-2 mb-2"><h4 class="float-right">LCV:</h4></div>
                        <div class="col-sm-4 mb-2">
                            {{ Form::text('lcvdpv', null, ['class' => 'form-control', 'placeholder' => 'LCV DPV target here...','required'=>'required','autocomplete'=>'off']) }}
                        </div>
                        <div class="col-sm-4 mb-2">
                            {{ Form::text('lcvwdpv', null, ['class' => 'form-control', 'placeholder' => 'LCV WDPV target here...','required'=>'required','autocomplete'=>'off']) }}
                        </div>
                        <div class="col-sm-2"></div>

                        
                       
                    </div>

                    <hr/>
                    <div class="row">

                        <div class="col-sm-4">
                            <button type="submit" style="width: 80%;" class="btn btn-primary btn-md">Save/Update Target</button>
                    </div>
                    </div>


                    {!! Form::close(); !!}
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-block">

                        <div class="table-responsive">
                            <table class="table" id="target">
                                <thead class="bg-primary text-white" >

                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Month</th>
                                    <th>To</th>
                                    <th>CV DPV Target</th>
                                    <th>CV WDPV Target</th>
                                    <th>LCV DPV Target</th>
                                    <th>LCV WDPV Target</th>
                                    <th>Delete</th>
                                   
                                </tr>
                            </thead>
                            <tbody>
                                @if ($gcatargts != "")
                                    @foreach ($gcatargts as $item)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$item->target_name}}</td>
                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$item->month)->format('F Y');}}</td>
                                        <td>{{ ($item->date_to !=null) ? \Carbon\Carbon::createFromFormat('Y-m-d',$item->date_to)->format('F Y') : ''}}    </td>
                                        <td>{{$item->cvdpv}}</td>
                                        <td>{{$item->cvwdpv}}</td>
                                        <td>{{$item->lcvdpv}}</td>
                                        <td>{{$item->lcvwdpv}}</td>
                                        <td><a href="{{ route('remover', [$item->id]) }}" class="btn btn-xs btn-danger delete_brand_button delete-target"><i class="glyphicon glyphicon-trash"></i> Delete</a></td>
                                       
                                      
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
    <script>
         $(".select2").select2();
    </script>
     <script>
            $('.from').datepicker({
                autoclose: true,
                minViewMode: 1,
                format: "MM yyyy",
            });

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
                                    window.location = "gcatarget";
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            
      $('table#target tbody').on('click', 'a.delete-target', function(e){
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
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    window.location.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }else{

                      Swal.fire('Target Not deleted', '', 'info')
                    }
                });
            }); 



                </script>



    {!! Toastr::message() !!}

    
    @endsection

