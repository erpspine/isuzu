
@extends('layouts.app')
@section('title','Packaging List ')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Packaging List</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Packaging List</li>
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
                    <h3 class="mb-0">Packaging List</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            @include('partbybin.partial.partbybin-header-buttons')
                        </div>
                    </div>
                </div>
            </div>

    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">



                <div class="card-body">
                    {!! Form::open(['route' => 'packaging-list.index', 'method' => 'get','files' => true, 'class' => 'add-new-user modal-content pt-0', 'id' => 'parts_add_form' ]) !!}
                    <div class="row">

                        @php
                                
                                  
                         $ship = null;
                        if (isset($shipment_number)) {
                          $ship = $shipment_number;
                            
                        }
                        
                      @endphp



                        <div class="col-xl-8 col-md-6 col-12 mt-2">
                            <div class="form-group row">
                             
                                <div class="col-md-9 pl-5">
                                     {!! Form::select('shipment_number', $shipping_details,  $ship, ['placeholder' => 'Select Shipping Number', 'class' => 'select2 form-control custom-select ','style'=>'height: 40px;width: 100%;']); !!}
                                    </div>
                            </div>
                        </div>
                      
                        <div class="col-xl-4 col-md-6 col-12 mt-2">
                            <div class="mb-1">
                               
                                {{ Form::submit('Search', ['class' => 'btn btn-primary me-1 data-submit','id'=>'submit-data']) }}
                            </div>
                        </div>
                   
                    
                       
                    </div>
                    {!! Form::close() !!}
                    @if(isset($shipment_number)) 
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered" id="pickinglist">
                            <thead>
                                <tr>
                                    <th>Case  Number</th>
                                    <th>Sales Order Number</th>
                                    <th>Supplier Part Number</th>
                                    <th>Order Part Number</th>
                                    <th>Qty Ordered </th>
                                    <th>Qty Confirmed</th>
                                    <th>Descrepancy</th>
                                    <th>Status</th>
                                   

                                </tr>
                            </thead>
                        
                        </table>
                    </div>
                    @endif


                </div>
            </div>
        </div>
    </div>




@endsection
@section('after-styles')
      {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css') }}
    {{ Html::style('assets/libs/ckeditor/samples/css/samples.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}

 {{ Html::style('assets/libs/bootstrap-switch/dist/css/bootstrap3/bootstrap-switch.min.css') }}

    
@endsection



@section('after-scripts')

{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}

  <!-- This Page JS -->
  {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
  {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
  {{ Html::script('assets/libs/bootstrap-switch/dist/js/bootstrap-switch.min.js') }}

<script type="text/javascript">
    $(document).ready( function() {
        $(".select2").select2();
     
    $(document).on('submit', 'form#category_add_form', function(e) {
        e.preventDefault();
        $(this)
            .find('button[type="submit"]')
            .attr('disabled', true);
        var data = $(this).serialize();

        $.ajax({
            method: 'POST',
            url: $(this).attr('action'),
            dataType: 'json',
            data: data,
            success: function(result) {
                if (result.success === true) {
                    $('div.category_modal').modal('hide');
                    toastr.success(result.msg);
                    category_table.ajax.reload();
                } else {
                    toastr.error(result.msg);
                }
            },
        });
    });


        
    });



  
// capital_account_table
// capital_account_table
var parts = $('#pickinglist').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("packaging-list.index") }}',
                            data: function(d){
                             d.shipment_number = @json($ship);
                            }
                        },
                    
                        columns: [
                        
                        {data: 'case_number', name: 'case_number'},
                            {data: 'sales_order_no', name: 'sales_order_no'},
                            {data: 'supplier_part_number', name: 'supplier_part_number'},
                            {data: 'order_part_number', name: 'order_part_number'},
                            {data: 'qty', name: 'qty'},
                            {data: 'qty_confirmed', name: 'qty_confirmed'},
                            {data: 'descripancy', name: 'descripancy'},
                            {data: 'status', name: 'status'}
                        ],  order:[['1', 'asc']],
        'columnDefs': [
            {
                "orderable": false,
                "searchable": false,
                'targets': [7 ]
            }
        
        ],
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





      





      $('table#appusers tbody').on('click', 'a.reset-password', function(e){
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
                            method: "GET",
                            url: href,
                            dataType: "json",
                            success: function(result){
                                if(result.success == true){
                                    toastr.success(result.msg);
                                    appusers.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }else{

                      Swal.fire('Passord not reset', '', 'info')
                    }
                });
            }); 



          $('table#appusers tbody').on('click', 'a.delete-user', function(e){
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
                                    appusers.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }else{

                      Swal.fire('User not deleted', '', 'info')
                    }
                });
            });


</script>
    @endsection