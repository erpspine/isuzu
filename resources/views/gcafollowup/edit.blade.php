
@extends('layouts.app')
@section('title','GCA FollowUp Edit')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">GCA Follow Up(s)</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit </li>
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
                            @include('gcafollowup.partial.gcafollowup-header-buttons')
                        </div>
                    </div>
                </div>
            </div>

    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">



                <div class="card-body">
                     {{ Form::open(['route' => ['gcafollowup.update',$gca->id], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT', 'id' => 'create-user'])}}


                
                <div class="card-body">


         

                    <div class="form-group row">
                        <label for="pname" class="col-sm-3 text-right control-label col-form-label">Note</label>
                        <div class="col-sm-9">
                            {{ Form::textarea('note', $gca->note, ['class' => 'form-control', 'placeholder' => 'Enter Note', 'required' => 'required', 'autocomplete' => 'off']) }}
                        </div>
                    </div>
               
                 

            <hr>
                <div class="card-body">
                    <div class="form-group mb-0 text-right">
                        {{ Form::submit('Update', ['class' => 'btn btn-info btn-md','id'=>'submit-data']) }}

                        {{ link_to_route('gcafollowup.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
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

    

<script type="text/javascript">
     $(document).on('submit', 'form#create-user', function(e){
            e.preventDefault();
            $("#submit-data").hide();
            var data = $(this).serialize();
            $.ajax({
                method: "POST",
                url: $(this).attr("action"),
                dataType: "json",
                data: data,
                success:function(result){
                    if(result.success == true){
                        //$('div.account_model').modal('hide');
                        toastr.success(result.msg);
                       // capital_account_table.ajax.reload();
                        //other_account_table.ajax.reload();

                        location.href = '{{ route("gcafollowup.index") }}';
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });
</script>
    @endsection