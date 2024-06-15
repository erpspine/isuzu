
@extends('layouts.app')
@section('title','DRR MANAGEMENT')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">DRR MANAGEMENT</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Drr Management</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
               
                <button type="button"
                            class="update_chart btn btn-info btn-min-width  btn-lg mr-1 mb-1"
                            data-val="custom" data-toggle="modal"
                            data-target="#custom"><i
                                class="fa fa-clock"></i> Filter
                    </button>
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
                   
                  

                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title">{!! $heading !!}</h4>
                        </div>
                      
                    </div>
                    
                       <div class="table-responsive sticky-table">
                                    <table id="mainTable" class="table editable-table table-bordered table-striped m-b-0">
                                        <thead>
                                            <tr class="sticky-header">
                                                <th  class="sticky-cell"  >Date</th>
                                                <th  class="sticky-cell"  >Lot&Job </th>
                                                <th class="sticky-cell"  >Vin</th>
                                                <th class="sticky-cell"  >Query  Name</th>
                                                <th class="sticky-cell"  >Defect</th>
                                                <th class="sticky-cell"  >Shop Captured</th>
                                                <th class="sticky-cell"  >Captured By</th>
                                                <th class="sticky-cell"  >Corrected</th>
                                               
                                            
                                                <th class="sticky-cell"  >MPA</th>
                                                <th class="sticky-cell"  >MPB</th>
                                                <th class="sticky-cell" >MPC</th>
                                   
                                            </tr>
                                        </thead>
                                        <tbody id="defectsummary">

                                            @foreach($defects as $defect)
                                            @php
                                            $drra_display="Yes";
                                            $drrb_display="Yes";
                                            $drrc_display="Yes";
                                            if($defect->mpa_drr==0){
                                                $drra_display="No";

                                            }
                                           
                                            if($defect->mpb_drr==0){
                                                $drrb_display="No";

                                            }
                                            if($defect->mpc_drr==0){
                                                $drrc_display="No";

                                            }
                                             
                                            @endphp
                                           
                                            <tr>
                                                    <td>{{dateFormat($defect->created_at)}}</td>
                                                    <td>{{$defect->getqueryanswer->vehicle->lot_no}} - {{$defect->getqueryanswer->vehicle->job_no}}</td>
                                                  
                                                    <td>{{$defect->getqueryanswer->vehicle->vin_no}}</td>
                                                   <td class="edit-disabled">{{$defect->getqueryanswer->routing->query_name}}</td>
                                                   
                                                   <td>{{$defect->defect_name}} </td>
                                                    <td >{{$defect->getqueryanswer->shop->shop_name}}</td>
                                                    <td>{{$defect->getqueryanswer->doneby->name}}</td>
                                                    <td  >{{$defect->repaired}}</td>
                                                  
                                                    <td data-name="mpa_drr" class="mpa_drr" id="mpa_drr" data-type="select" data-source="[{'value': '1', 'text': 'Yes'}, {'value': '0', 'text': 'No'}]" data-value="{{$defect->mpa_drr}}"  data-pk="{{$defect->id}}" data-url="{{route('updatedrr',[encrypt_data('defect_category')])}}" data-title="Update Corrected" >{{$drra_display}}</td>
                                                    <td data-name="mpb_drr" class="mpb_drr" id="mpb_drr" data-type="select" data-source="[{'value': '1', 'text': 'Yes'}, {'value': '0', 'text': 'No'}]" data-value="{{$defect->mpb_drr}}"  data-pk="{{$defect->id}}" data-url="{{route('updatedrr',[encrypt_data('defect_category')])}}" data-title="Update Corrected" >{{$drrb_display}}</td>
                                                    <td data-name="mpc_drr" class="mpc_drr" id="mpc_drr" data-type="select" data-source="[{'value': '1', 'text': 'Yes'}, {'value': '0', 'text': 'No'}]" data-value="{{$defect->mpc_drr}}"  data-pk="{{$defect->id}}" data-url="{{route('updatedrr',[encrypt_data('defect_category')])}}" data-title="Update Corrected" >{{$drrc_display}}</td>
    
                                                   
                                                   
                                                   
                                                  
                                                   
                                                </tr>

                                           @endforeach
                                        </tbody>
                                       
                                        
                                    </table>
                                </div>
                    
                    
                </div>
            </div>
        </div>
    </div>


 <!-- Custom content -->
                                <div id="custom" class="modal fade" tabindex="-1" role="dialog"
                                    aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                                <h4 class="modal-title" id="fullWidthModalLabel">Select Custom Date</h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>

                                            <div class="modal-body">
                                              

                                                 {{ Form::open(['route' => 'drrlist', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get', 'id' => 'create-user'])}}

                                                 <div class="form-group">
                                                    <label for="shop">Drr SHOP</label>
                                                    <select name="shop" class="form-control custom-select" id="shop">
                                                        <option value="">All Shops</option>
                                                        <option value="mpa">MPA</option>
                                                        <option value="mpb">MPB</option>
                                                        <option value="mpc">MPC</option>
                                                    </select>
                                                     
                                                </div>


                                                       


                                                    <div class="form-group">
                                                        <label for="date">From</label>
                                                        <input class="form-control from_custom_date" type="text" id="from"
                                                            required="" name="from_custom_date_single" data-toggle="datepicker" autocomplete="off"  >
                                                    </div>

                                                        <div class="form-group">
                                                        <label for="date">To</label>
                                                        <input class="form-control to_custom__date" type="text" id="to"
                                                            required="" name="to_custom_date_single" data-toggle="datepicker" autocomplete="off"  >
                                                    </div>

                                                    <div class="form-group text-center">
                                                        <button class="btn btn-primary" type="submit">Filter Record      </button>
                                                    </div>

                                                 {{ Form::close() }}

                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->




@endsection
@section('after-styles')
{{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
      {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
    {{ Html::style('assets/libs/sticky/jquery.stickytable.css') }}
    
@endsection



@section('after-scripts')
{{ Html::script('assets/libs/datepicker/datepicker.min.js') }}

{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
{{ Html::script('assets/libs/x-editable/dist/js/bootstrap-editable.js') }}
{{ Html::script('assets/libs/sticky/jquery.stickytable.js') }}





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
        

        
</script>
    @endsection