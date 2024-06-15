@extends('layouts.app')
@section('title', 'Gca Checksheet Items')
@section('content')
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">{{ $zones->category->name }} : {{ $zones->category_name }}  </h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Gca Checksheet Items</li>
            </ol>
        </div>
        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
                <div class="media width-250 float-right">
                    <div class="media-body media-right text-right">
                        @include('gcachecksheet.partial.gcachecksheet-header-buttons')
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
                      
                            @if ($zones->zone_type=='ABCD')
                            <table class="table table-striped table-bordered " id="routingquery">
                                <thead>
                                    <tr>
                                        <th>Defect</th>
                                        <th>Size </th>
                                        <th>Description </th>
                                        <th>Quality </th>
                                        <th>Zone A</th>
                                        <th>Zone B</th>
                                        <th>Zone C</th>
                                        <th>Zone D</th>
                                      
                                    </tr>
                                </thead>
                            </table>
                            @elseif($zones->zone_type=='Exterior-Interior')
                            <table class="table table-striped table-bordered " id="routingquery">
                                <thead>
                                    <tr>
                                        <th>Defect</th>
                                        <th>Size </th>
                                        <th>Description </th>
                                        <th>Quality </th>
                                        <th>Exterior</th>
                                        <th>Interior Primary</th>
                                        <th>Interior Secondary </th>
                                       
                                        
                                    </tr>
                                </thead>
                            </table>
                            @elseif($zones->zone_type=='ExteriorAB-Interior')
                            <table class="table table-striped table-bordered " id="routingquery">
                                <thead>
                                    <tr>
                                        <th>Defect</th>
                                        <th>Size </th>
                                        <th>Description </th>
                                        <th>Quality </th>
                                        <th>Exterior A</th>
                                        <th>Exterior B</th>
                                        <th>Interior Primary</th>
                                        <th>Interior Secondary </th>
                                       
                                        
                                    </tr>
                                </thead>
                            </table>
                            @elseif($zones->zone_type=='No-Zones')

                            <table class="table table-striped table-bordered " id="routingquery">
                                <thead>
                                    <tr>
                                        <th>Defect</th>
                                        <th>Size </th>
                                        <th>Description </th>
                                        <th>Quality </th>
                                        <th>Weight Factor</th>

                                        
                                    </tr>
                                </thead>
                            </table>
                            @elseif($zones->zone_type=='Fluid-Level')
                            <table class="table table-striped table-bordered " id="routingquery">
                                <thead>
                                    <tr>
                                        <th>10mm above Maximum</th>
                                                <th>5mm above Maximum</th>
                                                <th>Below Min</th>
                                                <th>Not Visible</th>
                                                <th>Any Leak</th>
                                                <th>Incorrect Fluid</th>
                                        
                                    </tr>
                                </thead>
                            </table>
                            @elseif($zones->zone_type=='Noise')
                            <table class="table table-striped table-bordered " id="routingquery">
                                <thead>
                                    <tr>
                                        <th>Slight</th>
                                        <th>Moderate</th>
                                        <th>Loud</th>
                                        
                                    </tr>
                                </thead>
                            </table>
                            @elseif($zones->zone_type=='Safety')
                            <table class="table table-striped table-bordered " id="routingquery">
                                <thead>
                                    <tr>
                                        <th>L=loose</th>
                                        <th>D=damaged</th>
                                        <th>W=wrong</th>
                                        <th>M=missing</th>
                                        <th>F=function</th> 
                                     
                                    </tr>
                                </thead>
                            </table>
                            @endif
                      
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
        @if ($zones->zone_type=='ABCD')
        <script type="text/javascript">
                var routingquery = $('#routingquery').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('gca-checksheet.show',[$zones->id]) }}',
                    data: function(d) {
                        // d.account_status = $('#account_status').val();
                    }
                },
                columns: [{
                        data: 'defect',
                        name: 'defect'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'zonea',
                        name: 'zonea'
                    },
                    {
                        data: 'zoneb',
                        name: 'zoneb'
                    },
                    {
                        data: 'zonec',
                        name: 'zonec'
                    },
                    {
                        data: 'zoned',
                        name: 'zoned'
                    }
                ],
                order: [
                    ['2', 'asc']
                ],
                'select': {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"lfB>rtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],
            });

              
        </script>
         @elseif($zones->zone_type=='Exterior-Interior')
         <script type="text/javascript">
    
            var routingquery = $('#routingquery').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '{{ route('gca-checksheet.show',[$zones->id]) }}',
                data: function(d) {
                    // d.account_status = $('#account_status').val();
                }
            },
            columns: [{
                    data: 'defect',
                    name: 'defect'
                },
                {
                    data: 'size',
                    name: 'size'
                },
                {
                    data: 'description',
                    name: 'description'
                },
                {
                    data: 'quantity',
                    name: 'quantity'
                },
                {
                    data: 'exterior',
                    name: 'exterior'
                },
                {
                    data: 'interiorprimary',
                    name: 'interiorprimary'
                },
                {
                    data: 'interiorsecondary',
                    name: 'interiorsecondary'
                }
            ],
            order: [
                ['2', 'asc']
            ],
            'select': {
                style: 'multi',
                selector: 'td:first-child'
            },
            'lengthMenu': [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            dom: '<"row"lfB>rtip',
            buttons: [{
                    extend: 'pdf',
                    text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    footer: true
                },
                {
                    extend: 'csv',
                    text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    footer: true
                },
                {
                    extend: 'print',
                    text: '<i title="print" class="fa fa-print"></i>',
                    exportOptions: {
                        columns: ':visible:Not(.not-exported)',
                        rows: ':visible'
                    },
                    footer: true
                },
                {
                    extend: 'colvis',
                    text: '<i title="column visibility" class="fa fa-eye"></i>',
                    columns: ':gt(0)'
                },
            ],
        });
    </script>
     @elseif($zones->zone_type=='ExteriorAB-Interior')
     <script type="text/javascript">

        var routingquery = $('#routingquery').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '{{ route('gca-checksheet.show',[$zones->id]) }}',
            data: function(d) {
                // d.account_status = $('#account_status').val();
            }
        },
        columns: [{
                data: 'defect',
                name: 'defect'
            },
            {
                data: 'size',
                name: 'size'
            },
            {
                data: 'description',
                name: 'description'
            },
            {
                data: 'quantity',
                name: 'quantity'
            },
            {
                data: 'exterior',
                name: 'exterior'
            },
            {
                data: 'exteriorb',
                name: 'exteriorb'
            },
            {
                data: 'interiorprimary',
                name: 'interiorprimary'
            },
            {
                data: 'interiorsecondary',
                name: 'interiorsecondary'
            }
        ],
        order: [
            ['2', 'asc']
        ],
        'select': {
            style: 'multi',
            selector: 'td:first-child'
        },
        'lengthMenu': [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        dom: '<"row"lfB>rtip',
        buttons: [{
                extend: 'pdf',
                text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer: true
            },
            {
                extend: 'csv',
                text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer: true
            },
            {
                extend: 'print',
                text: '<i title="print" class="fa fa-print"></i>',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
                footer: true
            },
            {
                extend: 'colvis',
                text: '<i title="column visibility" class="fa fa-eye"></i>',
                columns: ':gt(0)'
            },
        ],
    });
</script>
         @elseif($zones->zone_type=='No-Zones')
         <script type="text/javascript">
          var routingquery = $('#routingquery').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('gca-checksheet.show',[$zones->id]) }}',
                    data: function(d) {
                        // d.account_status = $('#account_status').val();
                    }
                },
                columns: [{
                        data: 'defect',
                        name: 'defect'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'weightfactor',
                        name: 'weightfactor'
                    }
                ],
                order: [
                    ['2', 'asc']
                ],
                'select': {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"lfB>rtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],
            });



          </script>
         @elseif($zones->zone_type=='Fluid-Level')
         <script type="text/javascript">
          var routingquery = $('#routingquery').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('gca-checksheet.show',[$zones->id]) }}',
                    data: function(d) {
                        // d.account_status = $('#account_status').val();
                    }
                },
                columns: [{
                        data: 'defect',
                        name: 'defect'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'tenmmabove',
                        name: 'tenmmabove'
                    },
                    {
                        data: 'fivemmabove',
                        name: 'fivemmabove'
                    },
                    {
                        data: 'belowmin',
                        name: 'belowmin'
                    },
                    {
                        data: 'notvisible',
                        name: 'notvisible'
                    },
                    {
                        data: 'anyleak',
                        name: 'anyleak'
                    },
                    {
                        data: 'incorrectfluid',
                        name: 'incorrectfluid'
                    }
                ],
                order: [
                    ['2', 'asc']
                ],
                'select': {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"lfB>rtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],
            });

         </script>
         @elseif($zones->zone_type=='Noise')
         <script type="text/javascript">
         var routingquery = $('#routingquery').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('gca-checksheet.show',[$zones->id]) }}',
                    data: function(d) {
                        // d.account_status = $('#account_status').val();
                    }
                },
                columns: [{
                        data: 'defect',
                        name: 'defect'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'slight',
                        name: 'moderate'
                    },
                    {
                        data: 'loud',
                        name: 'loud'
                    }
                ],
                order: [
                    ['2', 'asc']
                ],
                'select': {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"lfB>rtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],
            });

         </script>
         @elseif($zones->zone_type=='Safety')
         <script type="text/javascript">
         var routingquery = $('#routingquery').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('gca-checksheet.show',[$zones->id]) }}',
                    data: function(d) {
                        // d.account_status = $('#account_status').val();
                    }
                },
                columns: [{
                        data: 'defect',
                        name: 'defect'
                    },
                    {
                        data: 'size',
                        name: 'size'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'quantity',
                        name: 'quantity'
                    },
                    {
                        data: 'L',
                        name: 'L'
                    },
                    {
                        data: 'D',
                        name: 'D'
                    },
                    {
                        data: 'W',
                        name: 'W'
                    },
                    {
                        data: 'M',
                        name: 'M'
                    },
                    {
                        data: 'F',
                        name: 'F'
                    }
                ],
                order: [
                    ['2', 'asc']
                ],
                'select': {
                    style: 'multi',
                    selector: 'td:first-child'
                },
                'lengthMenu': [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                dom: '<"row"lfB>rtip',
                buttons: [{
                        extend: 'pdf',
                        text: '<i title="export to pdf" class="fas fa-file-pdf"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'csv',
                        text: '<i title="export to csv" class="fas fa-file-alt"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'print',
                        text: '<i title="print" class="fa fa-print"></i>',
                        exportOptions: {
                            columns: ':visible:Not(.not-exported)',
                            rows: ':visible'
                        },
                        footer: true
                    },
                    {
                        extend: 'colvis',
                        text: '<i title="column visibility" class="fa fa-eye"></i>',
                        columns: ':gt(0)'
                    },
                ],
            });
         </script>
         @endif


    @endsection
