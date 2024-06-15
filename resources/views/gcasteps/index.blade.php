@extends('layouts.app')
@section('title', 'GCA Appearance Zones ')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">GCA Steps</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Gca Steps</li>
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
                <h3 class="mb-0">Steps </h3>

            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">

                    <div class="media-body media-right text-right">
                        


                        @include('gcasteps.partial.gcasteps-header-buttons')
                    </div>
                </div>
            </div>
        </div>

        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">

                @foreach ( $steps as $step )
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title m-0">Title :  {{ $step->title }}  <span class="pl-5"> Time: {{ $step->audit_time }}Min</span> </h4>
                        <div>
                            <a  class="btn btn-primary" href="{{ route('gcasteps.edit', [$step->id]) }}">Edit</a>



                            &nbsp;
                            <a href="{{ route('gcasteps.destroy', [$step->id]) }}" class="btn btn-danger delete-step"><i class="glyphicon glyphicon-trash"></i> Delete</a>

                            
                          
                        </div>
                    </div>
                    <div class="card-body">
                        {!! $step->description !!}

                       
                    </div>
                </div>
                    
                @endforeach
       





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


                $(document).on('submit', 'form#create-zones', function(e) {
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
                                $('div.myModal').modal('hide');
                                toastr.success(result.msg);
                                window.location.reload();

                                //category_table.ajax.reload();
                            } else {
                                toastr.error(result.msg);
                            }
                        },
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



            $('a.delete-step').on('click', function(e) {
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
                            method: "POST",
                            url: href,
                            dataType: "json",
                            data: {

                                '_token': '{{ csrf_token() }}',
                                _method: 'DELETE',
                            },
                            success: function(result) {
                                if (result.success == true) {
                                    toastr.success(result.msg);
                                    window.location.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    } else {

                        Swal.fire('Step not deleted', '', 'info')
                    }
                });
            });

            

           /* CKEDITOR.replace('testedit', {
            height: 150
        });*/


        $(document).on('click', 'button.edit_modal', function() {

            
           
           $('div.editmodal').load($(this).data('href'), function() {
               $(this).modal('show',function () {
                CKEDITOR.replace('testedit', {
            height: 150
        });
        });
         
   
               $('form#update_record_form').submit(function(e) {
                   e.preventDefault();
                   $(this)
                       .find('button[type="submit"]')
                       .attr('disabled', true);
                   //var data = $(this).serialize();
   
                   $.ajax({
                       method: 'POST',
                       url: $(this).attr('action'),
                       data: new FormData(this),
                       contentType: false,
                  cache: false,
                  processData:false,
                       success: function(result) {
                           if (result.success == true) {
                               $('div.editmodal').modal('hide',function () {
            CKEDITOR.instances['testedit'].destroy();
        });
                               Swal.fire({
                     position: 'top-end',
                     icon: 'success',
                     title: result.msg,
                     showConfirmButton: false,
                     timer: 1500,
                     customClass: {
                       confirmButton: 'btn btn-primary'
                     },
                     buttonsStyling: false
                   });
                
   
                      location.reload();
                           } else {
                               $(this)
                       .find('button[type="submit"]')
                       .attr('disabled', false);
                               Swal.fire({
                         position: 'top-end',
                         title: 'Error!',
                         text: result.msg,
                         icon: 'error',
                         customClass: {
                           confirmButton: 'btn btn-primary'
                         },
                         buttonsStyling: false
                       });
                           }
                       },
                   });
               });
   
         
   
   
           });
       });
        </script>
    @endsection
