
@extends('layouts.app')
@section('title','GCA RAW DATA')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">GCA RAW DATA</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">BY VEHICLE TYPE</li>
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

        
        


         
    <!-- Individual column searching (select inputs) -->


    <div class="row">
        <div class="col-12">
            <div class="card">


                <div class="card-body">
                    @php
                    $daterange_value=null;

                  if (isset($daterange)){
                    $daterange_value=$daterange;

                  }
                   
                        
                  
                        
                    @endphp
                  
                   
                  

                    <div class="row">
                        <div class="col-12">
                            {{ Form::open(['route' => 'gcarawdata', 'class' => '', 'role' => 'form', 'method' => 'get', 'id' => 'create-report', 'files' => false]) }}


                            <div class="row">
                                <div class="col-6">
                                    <h4 class="card-title">Choose Date Range:</h4>
                                    <div class='input-group'>
                                        <!--<input type='text' name="mdate" class="form-control singledate" />-->
                                        <input type='text' name="daterange" value="{{ $daterange_value }}" class="form-control shawCalRanges" />

                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <span class="ti-calendar"></span>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                            <div class="col-6">
                                <button type="submit" class="btn btn-success mt-4">Load Report</button>
                            </div>

                            </div>
                          
                            {!! Form::close() !!}

                        </div>
                      
                    </div>
                    
                       
                    
                    
                </div>
            </div>
        </div>
    </div>
@if (isset($daterange))



    <div class="row">
        <div class="col-12">
            <div class="card">
               
                <div class="card-body">
                    
                   
                    <div class="row">
                        <div class="col-lg-12 mb-4">
                            <div class="btn-list">

                                <a href="{{ route('printgcarawdata', [encrypt_data('CV'),encrypt_data($daterange_value)]) }}"  class="btn btn-primary text-white btn_shop"><i class="fas fa-folder-open"></i>
                                   CV DATA</a> 
                                    <a href="{{ route('printgcarawdata', [encrypt_data('LCV'),encrypt_data($daterange_value)]) }}"  class="btn btn-success text-white btn_shop"><i class="fas fa-folder-open"></i>
                                        LCV DATA</a> 



                                
                               
                              
                            </div>
                        </div>
                       
                 
                    </div>

                </div>
            </div>
        </div>
    </div>





    @endif


@endsection
@section('after-styles')
{{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
      {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
    {{ Html::style('assets/libs/sticky/jquery.stickytable.css') }}
    
@endsection



@section('after-scripts')


{{ Html::script('assets/libs/moment/moment.js') }}
{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
{{ Html::script('assets/libs/x-editable/dist/js/bootstrap-editable.js') }}
{{ Html::script('assets/libs/sticky/jquery.stickytable.js') }}
{{ Html::script('assets/libs/daterangepicker/daterangepicker.js') }}





<script type="text/javascript">




      $('#daily-modal').on('shown.bs.modal', function () {
      
           $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: 'dd-mm-yyyy',

            
        });
      $('.from_date').datepicker('setDate', 'today');
            
         });
   
    $('#custom').on('shown.bs.modal', function () {
      
           $('[data-toggle="datepicker"]').datepicker({
            autoHide: true,
            format: 'dd-mm-yyyy',

            
        });
      $('.from_custom_date').datepicker('setDate', 'today');
       $('.to_custom__date').datepicker('setDate', 'today');
            
         });





// capital_account_table
       var defect = $('#defect').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("drrlist") }}',
                            data: function(d){
                               // d.account_status = $('#account_status').val();
                            }
                        },
                        columnDefs:[{
                                "targets": 6,
                                "orderable": false,
                                "searchable": false
                            }],
                        columns: [
                        
                            {data: 'created_at', name: 'created_at'},
                            {data: 'vin_no', name: 'vin_no'},
                            {data: 'lot_no', name: 'lot_no'},
                            {data: 'job_no', name: 'job_no'},
                            {data: 'shop_name', name: 'shop_name'},
                            {data: 'doneby', name: 'doneby'},
                            {data: 'action', name: 'action'}
                        ],
                        
                    });



  



$('table#defect tbody').on('click', 'a.delete-defect', function(e){
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
                              data:{
       
                             '_token': '{{ csrf_token() }}',
                                   },
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    defect.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }else{

                      Swal.fire('Record not deleted', '', 'info')
                    }
                });
            });
            $(function(){


        var today = new Date();
        $("#datepicker").datepicker({
            showDropdowns: true,
            format: "MM yyyy",
            viewMode: "years",
            minViewMode: "months",
            maxDate: today,
            }).on('changeDate', function(e){
    $(this).datepicker('hide');
});

$("#today").datepicker({
            showDropdowns: true,
            format: "dd-mm-yyyy",
            viewMode: "days",
            minViewMode: "days",
            maxDate: today,
            }).on('changeDate', function(e){
    $(this).datepicker('hide');
})
$("#year_datepicker").datepicker({
            showDropdowns: true,
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
            maxDate: today,
            }).on('changeDate', function(e){
    $(this).datepicker('hide');
})




        });





        $('#defectsummary').editable({
        container: 'body',
        selector: 'td.vs',
        value: 2,    
        source: [
              {value: 1, text: 'Active'},
              {value: 2, text: 'Blocked'},
              {value: 3, text: 'Deleted'}
           ]
    });



        $(document).ready(function () {

            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': '{{csrf_token()}}'
                    }
                });

        

        $('#defectsummary').editable({
  container: 'body',
  selector: 'td.mpa_drr',
  validate: function(value){
   if($.trim(value) == '')
   {
    return 'This field is required';
   }
  }, success: function (response, newValue) {
                        console.log('Updated', response)
                    }
 });

 $('#defectsummary').editable({
  container: 'body',
  selector: 'td.mpb_drr',
  validate: function(value){
   if($.trim(value) == '')
   {
    return 'This field is required';
   }
  }, success: function (response, newValue) {
                        console.log('Updated', response)
                    }
 });



 $('#defectsummary').editable({
  container: 'body',
  selector: 'td.mpc_drr',
  validate: function(value){
   if($.trim(value) == '')
   {
    return 'This field is required';
   }
  }, success: function (response, newValue) {
                        console.log('Updated', response)
                    }
 });


})

// capital_account_table
var defect = $('#mainTable').DataTable({
                      
                      'select': { style: 'multi',  selector: 'td:first-child'},
                      'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
              
                      dom: '<"row"lfB>rtip',
                      buttons: [
                          {
                              extend: 'pdf',
                              text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                              exportOptions: {
                                  columns: ':visible:Not(.not-exported)',
                                  rows: ':visible'
                              },
                              footer:true
                          },
                          {
                              extend: 'csv',
                              text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                              exportOptions: {
                                  columns: ':visible:Not(.not-exported)',
                                  rows: ':visible'
                              },
                              footer:true
                          },
                          {
                              extend: 'print',
                              text: '<i title="print" class="fa fa-print"></i>',
                              exportOptions: {
                                  columns: ':visible:Not(.not-exported)',
                                  rows: ':visible'
                              },
                              footer:true
                          },
                        
                          {
                              extend: 'colvis',
                              text: '<i title="column visibility" class="fa fa-eye"></i>',
                              columns: ':gt(0)'
                          },
                      ],
                                      
                                  });
        

                                  $(function(){
        'use strict'
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
        });   

     

       


                    $( ".btn_shop" ).click(function(e) {
                        e.preventDefault();
                        var url = $(this).attr('href');
                        window.open(url,"Overtime", "width=1300,height=700");
            

});
</script>
    @endsection