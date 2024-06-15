
@extends('layouts.app')
@section('title','Plant Divisions ')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Plant Division </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Manage  </li>
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
                    <h3 class="mb-0">Manage Plant Division</h3>

                </div>
                <div class="content-header-right col-md-6 col-12">
                    <div class="media width-250 float-right">

                        <div class="media-body media-right text-right">
                            
                            <div class="col-md-12 text-right d-flex justify-content-md-end justify-content-center mb-1">
                                <a href="javascript:void(0)" id="btn-add-division" class="btn btn-info"><i class="mdi mdi-account-multiple-plus font-16 mr-1"></i> Add Division</a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">



                <div class="card-body">
                   
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered " id="divisions">
                            <thead>
                                <tr>
                                   
                                 
                                    <th>Division  Name</th>
                                 
                                     <th>Action</th>

                                </tr>
                            </thead>
                        
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


              <!-- Modal Add Employee -->
              <div class="modal fade" id="addContactModal" tabindex="-1" role="dialog" aria-labelledby="addContactModalTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Add Employee</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {!! Form::open(['route' => 'division.store', 'method' => 'post', 'id' => 'create-division' ]) !!}
                        <div class="modal-body">
                          
                            <div class="add-contact-box">
                                <div class="add-contact-content">
                                  
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="staff-number">
                                                    <input type="text" name="division_name" id="s-number" class="form-control" placeholder="Enter Name" required>
                                                    <span class="validation-text"></span>
                                                </div>
                                            </div>
                                        
                                        </div>
                                     
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                       
                            {{ Form::submit('Save ', ['class' => 'btn btn-success data-submit','id'=>'submit-data']) }}
                            <button class="btn btn-danger" data-dismiss="modal"> Discard</button>
                        </div>
                        {!! Form::close() !!}
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



  




                  
       var divisions = $('#divisions').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: '{{ route("division.index") }}',
                            data: function(d){
                               
                            }
                        },
                    
                        columns: [
                            {data: 'division_name', name: 'division_name'},
                            {data: 'action', name: 'action'}
                        ],  order:[['0', 'asc']],
              'columnDefs': [
            {
                "orderable": false,
                "searchable": false,
                'targets': [1 ]
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





        $('table#models tbody').on('click', 'a.delete-model', function(e){
                e.preventDefault();
                Swal.fire({
                    type: 'warning',
                  title: "Are You Sure",
                  showCancelButton: true,
                  buttons: true,
                  dangerMode: true,
                }).then((willDelete) => {
                    if (willDelete) {
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
                                    divisions.ajax.reload();
                                } else {
                                    toastr.error(result.msg);
                                }
                            }
                        });
                    }
                });
            });

            $('#btn-add-division').on('click', function(event) {
                   
                   $('#addContactModal #btn-add').show();
                   $('#addContactModal #btn-edit').hide();
                   $('#addContactModal').modal('show');
               });

               $(document).on('submit', 'form#create-division', function(e){
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
                        toastr.success(result.msg);
                        $('#addContactModal').modal('hide');
                        divisions.ajax.reload();
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