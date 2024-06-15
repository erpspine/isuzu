
@extends('layouts.app')
@section('title','GCA Steps Edit')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">GCA Steps Edit</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">GCA Steps Edit</li>
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
  <div class="content-header row pb-1">
                <div class="content-header-left col-md-6 col-12 mb-2">
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
            <div class="card">



                <div class="card-body">
                    {{ Form::model($reports, ['route' => ['gcasteps.update', $reports], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT', 'id' => 'update-step','file'=>true]) }}


                
                <div class="card-body">


            @include('gcasteps.form')

            <hr>
                <div class="card-body">
                    <div class="form-group mb-0 text-right">
                        {{ Form::submit('Update', ['class' => 'btn btn-info btn-md','id'=>'submit-data']) }}


                        {{ link_to_route('gcasteps.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
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

    
    
@endsection



@section('after-scripts')

{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/ckeditor/ckeditor.js') }}

    

<script type="text/javascript">
     $(document).on('submit', 'form#update-step', function(e){
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
                        //$('div.account_model').modal('hide');
                        toastr.success(result.msg);
                       // capital_account_table.ajax.reload();
                        //other_account_table.ajax.reload();

                        location.href = '{{ route("gcasteps.index") }}';
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });
        CKEDITOR.replace('testedit', {
            height: 150
        });
</script>
    @endsection