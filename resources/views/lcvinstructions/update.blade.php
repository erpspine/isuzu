@extends('layouts.app')
@section('title', 'Add Instructions ')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Edit Instructions</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Instructions</li>
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
        <div class="content-header row pb-1">
            <div class="content-header-left col-md-6 col-12 mb-2">
                <h3 class="mb-0">Edit Instructions </h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('appearancezonescv.partial.appearancezones-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($cvzone, ['route' => ['instructions.update', $cvzone], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT', 'id' => 'create-cvzones','file'=>true]) }}
                        {{ Form::hidden('vehicle_type', 'LCV', ['class' => 'form-control', 'placeholder' => 'Note', 'required' => 'required', 'autocomplete' => 'off','file'=>true]) }}
                        <div class="card-body">
                            @include('appearancezonescv.addform')
                            <hr>
                            <div class="card-body">
                                <div class="form-group mb-0 text-right">
                                    {{ Form::submit('Update', ['class' => 'btn btn-info btn-md', 'id' => 'submit-data']) }}
                                    {{ link_to_route('appearance-zones-lcv', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
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
        {{ Html::script('assets/libs/ckeditor/ckeditor.js') }}

   
        <script type="text/javascript">
            $(document).ready(function() {
                $(document).on('submit', 'form#create-cvzones', function(e){
            e.preventDefault();
            //var data = $(this).serialize();
            $("#submit-data").hide();
            $.ajax({
                method: "post",
                url: $(this).attr("action"),
                data:  new FormData(this),
               contentType: false,
               cache: false,
               processData:false,
                success:function(result){
                    if(result.success == true){
                        toastr.success(result.msg);
                        window.location.reload();
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });


            
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
            $('table#appusers tbody').on('click', 'a.delete-user', function(e) {
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
                                    appusers.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    } else {
                        Swal.fire('User not deleted', '', 'info')
                    }
                });
            });
         
            CKEDITOR.replace('testedit', {
            height: 600
        });
   
        </script>
    @endsection
