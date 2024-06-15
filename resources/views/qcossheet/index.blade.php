@extends('layouts.app')
@section('title', 'QCOS Sheet')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Generete QCOS sheet </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Gerenate</li>
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
                    </div>
                </div>
            </div>
        </div>
        <!-- Individual column searching (select inputs) -->
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    {{ Form::open(['route' => 'qcossheet.store', 'role' => 'form', 'method' => 'POST', 'id' => 'create-qcos', 'files' => false]) }}
                    @php
                        $sdate = null;
                        $custom_date = 'custom_date';
                        if (isset($selected_date)) {
                            $sdate = $selected_date;
                            $custom_date = '';
                        }
                    @endphp
                    <div class="row">
                        <div class="col-md-4">
                            <label for="lot">Shop</label>
                            {!! Form::select('shop_id', $shops,  null, ['id'=>'shop_id','class' => 'select2 form-control custom-select','style'=>'height: 40px;width: 100%;']); !!}
                            
                        </div>
                        <div class="col-md-4">
                            <label for="lot">Model</label>
                            {!! Form::select('model_id', $models,  null, ['id'=>'model_id','class' => 'select2 form-control custom-select','style'=>'height: 25px;width: 100%;']); !!}
                            
                        </div>
                        <div class="col-md-4">
                            <label for="lot">Joint</label>
                            {!! Form::select('joint_id', [],  null, ['id'=>'joint_id','class' => 'select2 form-control custom-select','style'=>'height: 25px;width: 100%;']); !!}
                            
                        </div>
                      
                      
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-4">
                           
                            <label for="lot">Select Date</label>
                            {!! Form::text('daterange', $sdate, [
                                'class' => 'form-control shawCalRanges',
                                'placeholder' => 'Select lot',
                            ]) !!}
                        </div>
                        <div class="col-md-4 p-4">
                            {{ Form::submit('Generate Report', ['class' => 'btn btn-primary btn-md','id'=>'submit-data']) }}
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>

@endsection
<style>
 .select2-container .select2-selection--single {
height: 34px !important;
}
.select2-container .select2-selection--single .select2-selection__rendered{
padding: 0 0 0 12px !important;
}
</style>

@section('after-styles')
    {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2-bootstrap.css') }}



@endsection
@section('after-scripts')

    {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
    {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
    {{ Html::script('assets/libs/x-editable/dist/js/bootstrap-editable.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
{{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
{{ Html::script('assets/libs/datepicker/datepicker.min.js') }}
    <script type="text/javascript">
      

 
       
      
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });
            $('#vehicle_data').editable({
                container: 'body',
                selector: 'td.traceable',
                validate: function(value) {
                    if ($.trim(value) == '') {
                        return 'This field is required';
                    }
                },
                success: function(response, newValue) {
                    console.log('Updated', response)
                }
            });
        })
        var today = new Date();
        $("#datepickers").datepicker({
            autoHide: true,
            format: "dd-mm-yyyy",
        });
        $('.custom_date').datepicker('setDate', 'today');
        $('#add-item').on('click', function() {
            var cvalue = parseInt($('#rowganak').val()) + 1;
            var nxt = parseInt(cvalue);
            $('#rowganak').val(nxt);
            var functionNum = "'" + cvalue + "'";
            count = $('#saman-row-gca div').length;
            //product row
            var data =
                '<tr><td><input type="text" class="form-control" name="gca_defect[]" required id="gca_defect-' + cvalue +
                '" ></td> <td><input type="text" class="form-control" required name="shop_captured[]" id="shop_captured-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="weight[]" id="weight-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="lot_job[]" id="lot_job-' +
                cvalue + '" ></td><td><input type="text" class="form-control" required name="model[]" id="model-' + cvalue +
                '" ></td> <td><button class="btn btn-danger v_delete_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>  </tr>';
            //ajax request
            // $('#saman-row').append(data);
            $('tr.last-item-row-gca').before(data);
        });
        $('#add-item-lcv').on('click', function() {
            var cvalue = parseInt($('#rowganaklcv').val()) + 1;
            var nxt = parseInt(cvalue);
            $('#rowganaklcv').val(nxt);
            var functionNum = "'" + cvalue + "'";
            count = $('#saman-row-lcv-gca div').length;
            //product row
            var data =
                '<tr><td><input type="text" class="form-control" name="lcv_gca_defect[]" required id="lcv_gca_defect-' + cvalue +
                '" ></td> <td><input type="text" class="form-control" required name="lcv_shop_captured[]" id="lcv_shop_captured-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="lcv_weight[]" id="lcv_weight-' +
                cvalue + '" ></td> <td><input type="text" class="form-control" required name="lcv_lot_job[]" id="lcv_lot_job-' +
                cvalue + '" ></td><td><input type="text" class="form-control" required name="lcv_model[]" id="lcv_model-' + cvalue +
                '" ></td> <td><button class="btn btn-danger v_delete_lcv_gca m-1 align-content-end"><i class="fa fa-trash"></i> </button></td>  </tr>';
            //ajax request
            // $('#saman-row').append(data);
            $('tr.last-item-row-lcv-gca').before(data);
        });
        $(document).on("click", ".v_delete_gca", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Remove This  Item  From List?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove!',
            }).then((willDelete) => {
                if (willDelete.value) {
                    $(this).closest("tr").remove(); // remove row
                } else {
                    Swal.fire('Item Not Removed!!', '', 'info')
                }
            });
        });

        $(document).on("click", ".v_delete_lcv_gca", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You Want To Remove This  Item  From List?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Remove!',
            }).then((willDelete) => {
                if (willDelete.value) {
                    $(this).closest("tr").remove(); // remove row
                } else {
                    Swal.fire('Item Not Removed!!', '', 'info')
                }
            });
        });



        $(".select2").select2({
                theme: "bootstrap",
                width: 'auto',
                dropdownAutoWidth: true,
            });

        $('.shawCalRanges').daterangepicker({
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
                alwaysShowCalendars: true,
            });


            $("#model_id").on('change', function() {
            $("#joint_id").val('').trigger('change');
           // console.log($('#shop_id').val());
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $("#joint_id").select2({
                ajax: {
                    url: '{{ route('loadbyjoint') }}',
                    dataType: 'json',
                    type: 'POST',
                    quietMillis: 10,
                    data: {
                        model_id: $(this).val(),
                        shop_id: $('#shop_id').val(),
                    },
                    processResults: function(data) {
                        console.log(data);
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.tool.tool_id + ' - ' + item.part_name_joint_id,
                                    id: item.id
                                }
                            })
                        };
                    },
                }
            });
        });
        //Print report
        $(document).on('submit', 'form#create-qcos', function(e){
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
                        var shop_id=result.data.shop_id;
                        var model_id=result.data.model_id;
                        var joint_id=result.data.joint_id;
                        var daterange=result.data.daterange;
                        
                       // console.log(result.data.shop_id);
                      location.href = '{{ route("generateqcosreport") }}?shop_id='+shop_id+'&model_id='+model_id+'&joint_id='+joint_id+'&daterange='+daterange+'&type=noprint';
                     $("#submit-data").show();
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });

    </script>
@endsection
