@extends('layouts.app')
@section('title', 'Add Weight')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Weight MANAGEMENT</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Weight</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
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
        <div class="content-header row pb-1">
            <div class="content-header-left col-md-6 col-12 mb-2">
            </div>
            <div class="content-header-right col-md-6 col-12">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('discrepancyweight.partial.discrepancyweight-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::model($discrepancyweight, ['route' => ['decrepancy_weight.update', $discrepancyweight], 'class' => 'form-material mt-4', 'role' => 'form', 'method' => 'PUT', 'id' => 'create-tool']) }}
                        <div class="card-body">
                            @include('discrepancyweight.form')
                            <hr>
                            <div class="card-body">
                                <div class="form-group mb-0 text-right">
                                    {{ Form::submit('Update', ['class' => 'btn btn-info btn-md', 'id' => 'submit-data']) }}
                                    {{ link_to_route('decrepancy_weight.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
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
            $(document).on('submit', 'form#create-tool', function(e) {
                e.preventDefault();
                $("#submit-data").hide();
                var data = $(this).serialize();
                $.ajax({
                    method: "POST",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            //$('div.account_model').modal('hide');
                            toastr.success(result.msg);
                            // capital_account_table.ajax.reload();
                            //other_account_table.ajax.reload();
                            location.href = '{{ route('decrepancy_weight.index') }}';
                        } else {
                            $("#submit-data").show();
                            toastr.error(result.msg);
                        }
                    }
                });
            });
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: 'dd-mm-yyyy',
            });
        </script>
    @endsection
