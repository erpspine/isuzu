@extends('layouts.app')
@section('title', 'Qcos Callibration')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Calibration</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Create </li>
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
                        @include('tcm.partial.tcm-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ Form::open(['route' => 'qcoscalibration.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-user']) }}
                        <div class="card-body">
                            @include('qcoscalibration.form')
                            <hr>
                            <div class="card-body">
                                <div class="form-group mb-0 text-right">
                                    {{ Form::submit('Save', ['class' => 'btn btn-info btn-md', 'id' => 'submit-data']) }}
                                    {{ link_to_route('qcoscalibration.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
 dd($item['bomitem_id']);        </div>
    @endsection
    @section('after-styles')
        {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
        {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
        {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
    @endsection
    @section('after-scripts')
        {{ Html::script('assets/libs/datepicker/datepicker.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
        {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
        {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
        <script type="text/javascript">
            $(document).on('submit', 'form#create-user', function(e) {
                e.preventDefault();
                $("#submit-data").hide();
                var data = $(this).serialize();
                $.ajax({
                    method: "post",
                    url: $(this).attr("action"),
                    dataType: "json",
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            //$('div.account_model').modal('hide');
                            toastr.success(result.msg);
                            // capital_account_table.ajax.reload();
                            //other_account_table.ajax.reload();
                            location.href = '{{ route('qcoscalibration.index') }}';
                        } else {
                            $("#submit-data").show();
                            toastr.error(result.msg);
                        }
                    }
                });
            });
            $(".select2").select2();
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: 'dd-mm-yyyy',
            });
               // print type
    $('#tcm_id').change(function() {
        var days=$('option:selected', this).attr('data-id');
        $('#days_to_next_calibrarion').val(days);


      
    });
        </script>
    @endsection
