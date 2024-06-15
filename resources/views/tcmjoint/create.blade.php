
@extends('layouts.app')
@section('title','Add JOINT')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">JOINT</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Add </li>
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



                <div class="card-body">
                     {{ Form::open(['route' => 'tcmjoint.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-tcmjoint','files' => true])}}


                
                <div class="card-body">


            @include('tcmjoint.form')

            <hr>
                <div class="card-body">
                    <div class="form-group mb-0 text-right">
                        {{ Form::submit('Save', ['class' => 'btn btn-info btn-md','id'=>'submit-data','files' => true]) }}


                        {{ link_to_route('tcmjoint.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
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
    {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2-bootstrap.css') }}

    
    
@endsection



@section('after-scripts')

{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}

    

<script type="text/javascript">
$(document).on('submit', 'form#create-tcmjoint', function(e){
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

                        location.href = '{{ route("tcmjoint.index") }}';
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });

        $(".select2").select2({
                theme: "bootstrap",
                width: 'auto',
                dropdownAutoWidth: true,
            });

</script>
    @endsection