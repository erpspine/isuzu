
@extends('layouts.app')
@section('title','Import Schedule')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Import Parts By Bin Location </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Import Parts By Bin Location </li>
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
    <div class="container-fluid note-has-grid">

       	
        <!-- Basic Inputs start -->
        <section id="basic-input">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Import Parts By Bin Location </h4>
                        </div>
                        <div class="card-body">
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
                        @if (session('status') || !empty($status))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success" role="alert">
                                   
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


                            {!! Form::open(['route' => 'parts-accessories.store', 'method' => 'post','files' => true, 'class' => 'add-new-user modal-content pt-0', 'id' => 'category_add_form' ]) !!}
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12 mt-2">
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Import Parts By Bin</span>
                                        </div>
                                        <div class="custom-file">
                                            {!! Form::file('part_upload', ['class' => 'custom-file-input', 'id' => 'inputGroupFile01','accept'=>'.xls, .xlsx, .csv', 'required' => 'required']) !!}
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>


                                
                                </div>
                                <div class="col-xl-6 col-md-6 col-12 mt-2">
                                    <div class="mb-1">
                                       
                                        {{ Form::submit('Submit', ['class' => 'btn btn-primary me-1 data-submit','id'=>'submit-data']) }}
                                    </div>
                                </div>
                           
                            
                               
                            </div>
                            {!! Form::close() !!}



                         
                        </div>
                    </div>
                </div>
            </div>
        </section>

          <!-- Input Sizing start -->
          <section id="input-sizing">
            <div class="row ">
                <div class="col-12">
                    <div class="card">

                        <div class="card-body">
      
                            <table class="table table-striped">
                                <tr>
                                    <th>Column Name</th>
                                    <th>Column Name</th>
                                    <th>Instruction</th>
                                </tr>
                                <tr>
                                    <td>A</td>
                                    <td>Part Number <small class="text-muted">(Required)</small></td>
                                    <td>Part Number</td>
                                </tr>
                                <tr>
                                    <td>B</td>
                                    <td>Part Name  <small class="text-muted">(Required)</small></td>
                                    <td>Part Name</td>
                                </tr>
                                <tr>
                                    <td>E</td>
                                    <td>SLock <small class="text-muted">(Required)</small></td>
                                    <td>SLock</td>
                                </tr>
                                <tr>
                                    <td>F</td>
                                    <td>Bin Location <small class="text-muted">(Required)</small></td>
                                    <td>Bin Location</td>
                                </tr>
                       
                               
                             
            
                            </table>
            </div>
            </div>
        </div>
            </div>
        </section>
   </div>




@endsection
@section('after-styles')
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}


     
    
@endsection



@section('after-scripts')

{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}

    

<script type="text/javascript">
     
 /*$(document).on('submit', 'form#create-model', function(e){
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
                        //$('div.account_model').modal('hide');
                        toastr.success(result.msg);
                       // capital_account_table.ajax.reload();
                        //other_account_table.ajax.reload();

                        location.href = '{{ route("vehiclemodels.index") }}';
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });*/








    
</script>

  
    @endsection