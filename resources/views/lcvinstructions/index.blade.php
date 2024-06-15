@extends('layouts.app')
@section('title', 'Appearance Zones CV ')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Appearance Zones CV</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Appearance Zones CV</li>
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
                <h3 class="mb-0">Instructions </h3>
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('lcvinstructions.partial.lcvinstructions-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->

        <div class="row">
          

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">

                        <h4 class="card-title mb-3">Instructions</h4>

                        <ul class="nav nav-pills bg-nav-pills nav-justified mb-3">
                            <li class="nav-item">
                                <a href="#home1" data-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0 active">
                                    <i class="mdi mdi-home-variant d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Appearance</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#specification" data-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Specification</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#profile1" data-toggle="tab" aria-expanded="true"
                                    class="nav-link rounded-0 ">
                                    <i class="mdi mdi-account-circle d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Static & Function</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#measurement" data-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Measurement</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#settings1" data-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Water Leaks</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#running" data-toggle="tab" aria-expanded="false"
                                    class="nav-link rounded-0">
                                    <i class="mdi mdi-settings-outline d-lg-none d-block mr-1"></i>
                                    <span class="d-none d-lg-block">Running</span>
                                </a>
                            </li>
                          
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane  show active" id="home1">
                             
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h4 class="card-title m-0">LCV Appearance &  Zones</h4>
                        <div>
                            <a href="{{ route('lcvinstructions.edit', [$appearance->id]) }}" class="h4 text-success" title="Add new field">
                                Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                                             
                        {!! $appearance->note !!}
                           
                    
                     
                       <hr />
                       <div class="row">
                           <div class="col-md-12 col-12">
                               <img style="width: 100%" src=" {{ asset('upload/qcos/' . $appearance->image_one) }}" />
                           </div>
                         
                         
                       </div>
                       <hr />
                       <div class="row">
                        <div class="col-md-12 col-12">
                            <img style="width: 100%" src=" {{ asset('upload/qcos/' . $appearance->image_two) }}" />
                        </div>
                      
                      
                    </div>
                    <hr />
                       <div class="row">
                           <div class="col-md-12 col-12">
                               <img style="width: 100%" src=" {{ asset('upload/qcos/' . $appearance->image_three) }}" />
                           </div>
                       </div>

                    
                   
                     
                   </div>
                </div>
            </div>
        </div>
                            </div>
                            <div class="tab-pane" id="specification">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h4 class="card-title m-0">Specification</h4>
                                                <div>
                                                    <a href="{{ route('lcvinstructions.edit', [$specification->id]) }}" class="h4 text-success" title="Add new field">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                             
                                                 {!! $specification->note !!}
                                                    
                                             
                                              
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $specification->image_one) }}" />
                                                    </div>
                                                  
                                                  
                                                </div>
                                                <hr />
                                                <div class="row">
                                                 <div class="col-md-12 col-12">
                                                     <img style="width: 100%" src=" {{ asset('upload/qcos/' . $specification->image_two) }}" />
                                                 </div>
                                               
                                               
                                             </div>
                                             <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $specification->image_three) }}" />
                                                    </div>
                                                </div>

                                             
                                            
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                            
                                        
                            </div>
                            <div class="tab-pane" id="profile1">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h4 class="card-title m-0">Static and Implementation Procedure</h4>
                                                <div>
                                                    <a href="{{ route('lcvinstructions.edit', [$static->id]) }}" class="h4 text-success" title="Add new field">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                             
                                                 {!! $static->note !!}
                                                    
                                             
                                              
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $static->image_one) }}" />
                                                    </div>
                                                  
                                                  
                                                </div>
                                                <hr />
                                                <div class="row">
                                                 <div class="col-md-12 col-12">
                                                     <img style="width: 100%" src=" {{ asset('upload/qcos/' . $static->image_two) }}" />
                                                 </div>
                                               
                                               
                                             </div>
                                             <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $static->image_three) }}" />
                                                    </div>
                                                </div>

                                             
                                            
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                            
                                        
                            </div>

                            <div class="tab-pane" id="measurement">

                                

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h4 class="card-title m-0">Measurement</h4>
                                                <div>
                                                    <a href="{{ route('lcvinstructions.edit', [$measurement->id]) }}" class="h4 text-success" title="Add new field">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                             
                                                 {!! $measurement->note !!}
                                                    
                                             
                                              
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $measurement->image_one) }}" />
                                                    </div>
                                                  
                                                  
                                                </div>
                                                <hr />
                                                <div class="row">
                                                 <div class="col-md-12 col-12">
                                                     <img style="width: 100%" src=" {{ asset('upload/qcos/' . $measurement->image_two) }}" />
                                                 </div>
                                               
                                               
                                             </div>
                                             <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $measurement->image_three) }}" />
                                                    </div>
                                                </div>
                                             
                                            
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>




                      
                            </div>

                            



                            <div class="tab-pane" id="settings1">

                                

                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h4 class="card-title m-0">Water Leaks</h4>
                                                <div>
                                                    <a href="{{ route('lcvinstructions.edit', [$waterleaks->id]) }}" class="h4 text-success" title="Add new field">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                             
                                                 {!! $waterleaks->note !!}
                                                    
                                             
                                              
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $waterleaks->image_one) }}" />
                                                    </div>
                                                  
                                                  
                                                </div>
                                                <hr />
                                                <div class="row">
                                                 <div class="col-md-12 col-12">
                                                     <img style="width: 100%" src=" {{ asset('upload/qcos/' . $waterleaks->image_two) }}" />
                                                 </div>
                                               
                                               
                                             </div>
                                             <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $waterleaks->image_three) }}" />
                                                    </div>
                                                </div>
                                             
                                            
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>




                      
                            </div>

                            <div class="tab-pane" id="running">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">
                                            <div class="card-header d-flex justify-content-between">
                                                <h4 class="card-title m-0">Running</h4>
                                                <div>
                                                    <a href="{{ route('lcvinstructions.edit', [$running->id]) }}" class="h4 text-success" title="Add new field">
                                                        Edit
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="card-body">

                                             
                                                 {!! $running->note !!}
                                                    
                                             
                                              
                                                <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $running->image_one) }}" />
                                                    </div>
                                                  
                                                  
                                                </div>
                                                <hr />
                                                <div class="row">
                                                 <div class="col-md-12 col-12">
                                                     <img style="width: 100%" src=" {{ asset('upload/qcos/' . $running->image_two) }}" />
                                                 </div>
                                               
                                               
                                             </div>
                                             <hr />
                                                <div class="row">
                                                    <div class="col-md-12 col-12">
                                                        <img style="width: 100%" src=" {{ asset('upload/qcos/' . $running->image_three) }}" />
                                                    </div>
                                                </div>

                                             
                                            
                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col -->
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
                height: 150
            });
        </script>
    @endsection
