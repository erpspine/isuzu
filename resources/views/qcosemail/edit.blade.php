@extends('layouts.app')
@section('title', 'Qcos Emails Edit')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Email Configurations </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Edit Emails</li>
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
                        @include('qcosemail.partial.qcosemail-header-buttons')
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        
                        {{ Form::model($qcosemail, ['route' => ['qcosemail.update', $qcosemail], 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'PUT', 'id' => 'create-tool']) }}
                        <div class="card-body">
                            @include('qcosemail.form')
                            <hr>
                            <div class="card-body">
                                <div class="form-group mb-0 text-right">
                                    {{ Form::submit('Update', ['class' => 'btn btn-info btn-md', 'id' => 'submit-data']) }}
                                    {{ link_to_route('qcosemail.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
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
    {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2-bootstrap.css') }}
    @endsection
    @section('after-scripts')
    {{ Html::script('assets/libs/datepicker/datepicker.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
        <script type="text/javascript">
         $.ajaxSetup({ headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"} });
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
                            location.href = '{{ route('qcosemail.index') }}';
                        } else {
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
            $('[data-toggle="datepicker"]').datepicker({
                autoHide: true,
                format: 'dd-mm-yyyy',
            });

            $("#source").on('change', function() {
                $("#name").val('')
                $("#email").val('')
             $("#user_id").html('').select2({
                theme: "bootstrap",
                width: 'auto',
                dropdownAutoWidth: true,
                ajax: {
                    url: "{{ route('selectuser') }}",
                    type: 'POST',
                    quietMillis: 50,
                    data: ({term}) => ({ 
                        search: term, 
                        source: $("#source").val()
                    }),
                    processResults: data => ({ results: data.map(v => ({ text: v.name, id: v.id })) }),
                }
            });
        });


        $('#user_id').change(function() {
            var source= $("#source").val()
           var user_id= $(this).val();
           $.ajax({
            url: "{{ route('searchuserdetails') }}",
            type: 'POST',
            dataType: 'json',
            data: {source: source,user_id:user_id  },
            success: data => {$('#name').val(data.master.name),$('#email').val(data.master.email)},            
        });

        });
        </script>
    @endsection
