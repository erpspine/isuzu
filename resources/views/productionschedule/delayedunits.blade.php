
@extends('layouts.app')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Vehicle Assembling Report</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Delayed Units</li>
            </ol>
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
                    <h4 class="card-title">Delayed Units (Units that have stayed <span class="text-danger">more than one day</span>)</h4>
                    <div class="d-flex float-right mb-2">
                        {{ Form::open(['route' => 'delayedunitsExport', 'method' => 'GET'])}}
                        {{ csrf_field(); }}
                            <button style="background-color:teal; color:white;"
                            class="btn btn-md  float-right" ><i class="glyphicon glyphicon-edit"></i>Export to Excel</button>
                        {!! Form::close(); !!}
                    </div>
                    <div class="table-responsive">
                        @include('productionschedule.delayedunits_table');
                    </div>
                </div>
            </div>
        </div>
    </div>




@endsection

