
@extends('layouts.app')
@section('title','DEFECT SUMMARY')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">DEFECT SUMMARY</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Defect Summary</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
               
                <div class="form-group">
                    <!-- basic buttons -->
                    
                    
                    
                   
                    <button type="button"
                            class="update_chart btn btn-info btn-min-width  btn-lg mr-1 mb-1"
                            data-val="custom" data-toggle="modal"
                            data-target="#custom"><i
                                class="fa fa-clock"></i> Filter
                    </button>

                </div>
            </div>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->




    <!-- Individual column searching (select inputs) -->


    <div class="row">
        <div class="col-12">
            <div class="card">


                <div class="card-body">
                   
                  

                    <div class="row">
                        <div class="col-8">
                            <h4 class="card-title"> {!! $heading !!} </h4>
                        </div>
                      
                    </div>
                    
                       <div class="table-responsive sticky-table">
                                    <table id="mainTable"
                                        class="table editable-table table-bordered table-striped m-b-0">
                                        <thead>
                                            <tr class="sticky-header">
                                                <th  class="sticky-cell" >Query  Name</th>
                                                <th  class="sticky-cell">Defect</th>
                                                <th  class="sticky-cell">Date&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                <th  class="sticky-cell">GCA WT</th>
                                                <th class="sticky-cell" >Shop Captured</th>
                                                <th class="sticky-cell" >Vin</th>
                                                <th class="sticky-cell" >Job</th>
                                                <th class="sticky-cell" >Lot</th>
                                                <th class="sticky-cell" >Inspection</th>
                                                <td class="sticky-cell" >VS</td>
                                                <td class="sticky-cell" >Float</td>
                                                <th class="sticky-cell" >Drl Score</th>
                                                <th class="sticky-cell" >Corrected</th>
                                                <th class="sticky-cell" >Inpected By</th>
                                                <th class="sticky-cell" >Change</th>

                                                
                                            
                                         



                                            </tr>
                                        </thead>
                                        <tbody id="defectsummary">
                                            
                                            @foreach($defects as $defect)
                                            @php



  
                                            @endphp

                                           
                                            <tr>
                                            <td class="edit-disabled">{{$defect->getqueryanswer->routing->query_name}}</td>
                                                <td>{{$defect->defect_name}} </td>
                                                <td>{{dateFormat($defect->created_at)}}</td>
                                                <td data-name="value_given" data-title="Update GCA " class="gca" data-type="text" data-pk="{{$defect->id}}" data-url="{{route('updatedefect',[encrypt_data('gca')])}}" >{{$defect->value_given}}</td>
                                                <td data-name="shop_id" class="shop" id="shop" data-type="select" data-source="{{$shops}}" data-value="{{$defect->getqueryanswer->shop->id}}"  data-pk="{{$defect->getqueryanswer->id}}" data-url="{{route('updatedefect',[encrypt_data('shop')])}}" data-title="Update Shop" >{{$defect->getqueryanswer->shop->shop_name}}</td>
                                                 <td>{{$defect->getqueryanswer->vehicle->vin_no}}</td>
                                                <td>{{$defect->getqueryanswer->vehicle->job_no}}</td>
                                                <td>{{$defect->getqueryanswer->vehicle->lot_no}}</td>
                                                <td>{{ check_units_complete($defect->shop_id,$defect->vehicle_id) ? 'Complete' : 'InProcess'}}</td>
                                                <td data-name="stakeholder" data-source="[{'value': 'MATERIAL HANDLING', 'text': 'MATERIAL HANDLING'}, {'value': 'PRODUCTION', 'text': 'PRODUCTION'}, {'value': 'LCD', 'text': 'LCD'}, {'value': 'PE', 'text': 'PE'}, {'value': 'MH/S', 'text': 'MH/S'}]" class="stakeholder" data-value="{{$defect->stakeholder}}" data-type="select" data-pk="{{$defect->id}}" data-title="Select Stakeholder" data-url="{{route('updatedefect',[encrypt_data('stakeholder')])}}">{{$defect->stakeholder}}</td>

                                                <td data-name="defect_category" class="defect_category" id="defect_category" data-type="select" data-source="{{$defectcategory}}" data-value="{{$defect->defect_category}}"  data-pk="{{$defect->id}}" data-url="{{route('updatedefect',[encrypt_data('defect_category')])}}" data-title="Update Defect Category" >{{$defect->defect_category}}</td>
                                                <td data-name="is_defect" class="is_defect" id="is_defect" data-type="select" data-source="[{'value': 'Yes', 'text': 'Yes'}, {'value': 'No', 'text': 'No'}]" data-value="{{$defect->is_defect}}"  data-pk="{{$defect->id}}" data-url="{{route('updatedefect',[encrypt_data('defect_category')])}}" data-title="Update Corrected" >{{$defect->is_defect}}</td>

                                                <td data-name="repaired" class="repaired" id="defect_category" data-type="select" data-source="[{'value': 'Yes', 'text': 'Yes'}, {'value': 'No', 'text': 'No'}]" data-value="{{$defect->repaired}}"  data-pk="{{$defect->id}}" data-url="{{route('updatedefect',[encrypt_data('defect_category')])}}" data-title="Update Corrected" >{{$defect->repaired}}</td>
                                                <td>{{$defect->getqueryanswer->doneby->name}}</td>
                                                <td>  <button data-href="{{route('changedefect',[$defect->id])}}" title="Change"  class="btn btn-xs btn-primary edit_unit_button"><i class="mdi mdi-tooltip-edit"></i> Correct </button></td>
                                               
                                                
                                              

                                               
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
                                                <h4 class="modal-title" id="fullWidthModalLabel">Filter Record </h4>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-hidden="true">×</button>
                                            </div>

                                            <div class="modal-body">
                                              

                                                 {{ Form::open(['route' => 'defectsummary', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'get', 'id' => 'create-user'])}}

                                                     


                                                      <div class="form-group">
                                                        <label for="date">Shops</label>
                                                        {!! Form::select('shop_id', $shops,  null, ['placeholder' => 'Select Shop', 'class' => 'form-control custom-select ']); !!}
                                                    </div>
                                               
                                                    <div class="form-group">
                                                        <label for="is_defect">Drl Score</label>
                                                        <select name="is_defect" class="form-control custom-select" id="is_defect">
                                                            <option value="">Drl Score</option>
                                                            <option value="Yes">Yes</option>
                                                            <option value="No">No</option>
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


                                <div class="modal fade unit_modal" tabindex="-1" role="dialog" 
                                aria-labelledby="gridSystemModalLabel">
                            </div>
@endsection
@section('after-styles')
   {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
      {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
        {{ Html::style('assets/libs/x-editable/dist/css/bootstrap-editable.css') }}
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
        selector: 'td.shop',
         validate: function(value){
   if($.trim(value) == '')
   {
    return 'This field is required';
   }
  },
        success: function (response, newValue) {
                        console.log('Updated', response)
                    }

    });


$('#defectsummary').editable({
  container: 'body',
  selector: 'td.gca',
  validate: function(value){
   if($.trim(value) == '')
   {
    return 'This field is required';
   }
  },
   success: function (response, newValue) {
                        console.log('Updated', response)
                    }
 });

$('#defectsummary').editable({
  container: 'body',
  selector: 'td.defect_category',
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
  selector: 'td.stakeholder',
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
  selector: 'td.repaired',
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
  selector: 'td.is_defect',
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
        
                    $(document).on('click', 'button.edit_unit_button', function() {   
        $('div.unit_modal').load($(this).data('href'), function() {
            $(this).modal('show');

           $('form#change_answer_form').submit(function(e) {
                e.preventDefault();
                $("#submit-data").attr('disabled', true);
                var data = $(this).serialize();

                $.ajax({
                    method: 'POST',
                    url: $(this).attr('action'),
                    dataType: 'json',
                    data: data,
                    success: function(result) {
                        if (result.success == true) {
                            $('div.unit_modal').modal('hide');
                            toastr.success(result.msg);
                            location.reload();  
                        } else {
                            toastr.error(result.msg);
                             $("#submit-data").attr('disabled', false);
                        }
                    },
                });
            });
        });
    });
   
</script>
    @endsection