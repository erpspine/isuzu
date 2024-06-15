
@extends('layouts.app')
@section('title','Routing Query')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Routing Query </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Routing Query</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
             
                <div class="media width-250 float-right">

                    <div class="media-body media-right text-right">
                        @include('querycategory.partial.querycategory-header-buttons')
                    </div>
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
    <div class="container-fluid">


    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">



                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered " id="routingquery">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Code</th>
                                     <th>Shop</th>
                                    <th>Name</th>
                                    <th>Done By</th>
                                    <th>Last Update</th>
                                    <th>Updated By</th>
                                    <th>Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>

                                </tr>
                            </thead>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection
@section('after-styles')
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    
@endsection



@section('after-scripts')

{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}

<script type="text/javascript">
    $(document).ready( function() {

     
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
       var routingquery = $('#routingquery').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("querycategory.index") }}',
                            data: function(d){
                               // d.account_status = $('#account_status').val();
                            }
                        },
                    
                        columns: [
                        
                            {data: 'image', name: 'image'},
                            {data: 'query_codes', name: 'query_codes'},
                             {data: 'shop', name: 'shop'},
                             {data: 'category_name', name: 'category_name'},
                             {data: 'done_by', name: 'done_by'},
                             {data: 'last_update', name: 'last_update'},
                             {data: 'user_updated', name: 'user_updated'},
                           
                           // {data: 'shop', name: 'shop'},
                           // {data: 'model', name: 'model'},
                            {data: 'action', name: 'action'}
                        ],  order:[['2', 'asc']],
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



            
 $('table#routingquery tbody').on('click', 'a.delete-query', function(e){
                e.preventDefault();
                Swal.fire({
                   title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((willDelete) => {
                    if (willDelete.value) {
                        var href = $(this).attr('href');
                        $.ajax({
                            method: "POST",
                            url: href,
                            dataType: "json",
                              data:{
							_method:'DELETE',
                            '_token': '{{ csrf_token() }}',
                                   },
                            success: function(result){
                                if(result.success == true){

                                    toastr.success(result.msg);
                                    vehicleunits.ajax.reload();
                                } else {
                                    
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }else{

                      Swal.fire('Query  Not Deleted', '', 'info')
                    }
                });
            });





</script>
    @endsection