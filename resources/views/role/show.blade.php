
@extends('layouts.app')
@section('title','Add Roles')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">Roles & Rights</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Roles and Permissions List</li>
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
                            @include('role.partials.role-header-buttons')
                        </div>
                    </div>
                </div>
            </div>

    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">

        <div class="card-body">

    <div class="card-header bg-primary mb-2">
        <h3 class="text-white">ROLE AND LIST OF PERMISSIONS </h3>
    </div>
    <div class="row">
    <div class="col-md-4">
        <div class="form-group" style="font-size: 18px;">
        {!! Form::label('name', 'Role Name:*') !!}
        {!! Form::label('name', $role->name, ['class' => 'font-weight-bold']); !!}

        </div>
        </div>
        </div>




        <!--RESPONSIVENESS-->
        <h4>RESPONSIVENESS SECTION</h4>
        <hr>
        <div class="row">

        <div class="col-3">
            <h5 class="ml-3">Scheduling Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'schedule-list', in_array('schedule-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'schedule6','disabled']); !!}
                        <label for="schedule6">View Schedule</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'schedule-print', in_array('schedule-print',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'schedule5','disabled']); !!}
                        <label for="schedule5">Print Label</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'schedule-create', in_array('schedule-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'schedule1','disabled']); !!}
                        <label for="schedule1">Create</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'schedule-import', in_array('schedule-import',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'schedule2','disabled']); !!}
                        <label for="schedule2">Import</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'schedule-edit', in_array('schedule-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'schedule3','disabled']); !!}
                        <label for="schedule3">Edit </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'schedule-delete', in_array('schedule-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'schedule4','disabled']); !!}
                        <label for="schedule4">Delete</label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Schedule Plan Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'prod-sche', in_array('prod-sche',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'prschedule','disabled']); !!}
                        <label for="prschedule">Prodn Schedule</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'fcw-sche', in_array('fcw-sche',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'fcwsche','disabled']); !!}
                        <label for="fcwsche">FCW Schedule  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'hist-sche', in_array('hist-sche',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'schhist','disabled']); !!}
                        <label for="schhist">Schedule History</label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Vehicle Models Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'model-list', in_array('model-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'model1','disabled']); !!}
                        <label for="model1">List </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'model-create',  in_array('model-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'model2','disabled']); !!}
                        <label for="model2">Create  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'model-edit', in_array('model-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'model3','disabled']); !!}
                        <label for="model3">Edit </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'model-delete', in_array('model-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'model4','disabled']); !!}
                        <label for="model4">Delete</label>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Performance Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">
                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'Effny-dashboard', in_array('Effny-dashboard',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'Effny1','disabled']); !!}
                        <label for="Effny1">Effny Dashboard</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'actual-production', in_array('actual-production',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'actprod','disabled']); !!}
                        <label for="actprod">Actual Productn</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'buffer-status', in_array('buffer-status',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'bstatus','disabled']); !!}
                        <label for="bstatus">Buffer Status</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'performance-tack', in_array('performance-tack',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'performance','disabled']); !!}
                        <label for="performance">Performance Rpt</label>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Swap Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'swap-create', in_array('swap-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'creswap','disabled']); !!}
                        <label for="creswap">Create Swap</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'swap-list', in_array('swap-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'liswap','disabled']); !!}
                        <label for="liswap">Swap List </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'swap-reset', in_array('swap-reset',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'swares','disabled']); !!}
                        <label for="swares">Reset Swap </label>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Re-routing Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'reroute-create', in_array('reroute-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'crereroute','disabled']); !!}
                        <label for="crereroute">Create Reroute</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'reroute-list', in_array('reroute-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'lireroute','disabled']); !!}
                        <label for="lireroute">Reroute List </label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Vehicle Units:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'delayed-units', in_array('delayed-units',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'del-units','disabled']); !!}
                        <label for="del-units">Delayed Units</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'pos-track', in_array('pos-track',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'pos-track','disabled']); !!}
                        <label for="pos-track">Position Track</label>
                    </div>
                </div>
            </div>
        </div>
        </div>


        <div class="col-3">
            <h5 class="ml-3">Summary Graphs:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'response-summary', in_array('response-summary',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'responsesum','disabled']); !!}
                        <label for="responsesum">Responsiveness</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'people-summary', in_array('people-summary',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'peoplesum','disabled']); !!}
                        <label for="peoplesum">People</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'quality-summary', in_array('quality-summary',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'qualitysum','disabled']); !!}
                        <label for="qualitysum">Quality</label>
                    </div>
                </div>
            </div>
        </div>
        </div>

    </div>



    <!--QUALITY-->
    <h4>QUALITY SECTION</h4>
    <hr>
    <div class="row">

        <div class="col-3">
            <h5 class="ml-3">Routing Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'routing-create', in_array('routing-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'routing1','disabled']); !!}
                        <label for="routing1">Create</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'routing-list', in_array('routing-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'routing5','disabled']); !!}
                        <label for="routing5">List</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'routing-import', in_array('routing-import',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'routing2','disabled']); !!}
                        <label for="routing2">Import</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'routing-edit', in_array('routing-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'routing3','disabled']); !!}
                        <label for="routing3">Edit </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'routing-delete', in_array('routing-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'routing4','disabled']); !!}
                        <label for="routing4">Delete</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'routing-bymodel', in_array('routing-bymodel',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'routingbm','disabled']); !!}
                        <label for="routingbm">Rt by Model</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'sort-routing', in_array('sort-routing',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'srtroute','disabled']); !!}
                        <label for="srtroute">Sort Routing</label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">DRL Target Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drltgt-list', in_array('drltgt-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drlli','disabled']); !!}
                        <label for="drlli">List Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drltgt-create', in_array('drltgt-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drltgtcr','disabled']); !!}
                        <label for="drltgtcr">Create Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drltgt-edit', in_array('drltgt-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drltgted','disabled']); !!}
                        <label for="drltgted">Edit Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drltgt-delete', in_array('drltgt-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drltgtdel','disabled']); !!}
                        <label for="drltgtdel">Delete Target</label>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Quality Output Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'qualityrpt-position', in_array('qualityrpt-position',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'qualityrpt1','disabled']); !!}
                        <label for="qualityrpt1">Curent Position</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'qualityrpt-marked', in_array('qualityrpt-marked',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'qualityrpt2','disabled']); !!}
                        <label for="qualityrpt2">Marked Routing</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drr-list', in_array('drr-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drrlist','disabled']); !!}
                        <label for="drrlist">DRR List</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'defect-list', in_array('defect-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'deflist','disabled']); !!}
                        <label for="deflist">Defect List</label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">Quality Report Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drl-report', in_array('drl-report',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drlrpt','disabled']); !!}
                        <label for="drlrpt">DRL Report</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drr-report', in_array('drr-report',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drrrpt','disabled']); !!}
                        <label for="drrrpt">DRR Report </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'gca-score', in_array('gca-score',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'gcascore','disabled']); !!}
                        <label for="gcascore">GCA Score </label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">DRR Target Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drrtgt-list', in_array('drrtgt-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drrli','disabled']); !!}
                        <label for="drrli">List Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drrtgt-create', in_array('drrtgt-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drrtgtcr','disabled']); !!}
                        <label for="drrtgtcr">Create Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drrtgt-edit', in_array('drrtgt-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drrtgted','disabled']); !!}
                        <label for="drrtgted">Edit Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'drrtgt-delete', in_array('drrtgt-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'drrtgtdel','disabled']); !!}
                        <label for="drrtgtdel">Delete Target</label>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">GCA Target Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'gcatgt-create', in_array('gcatgt-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'gcatarg','disabled']); !!}
                        <label for="gcatarg">Create Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'mangca-target', in_array('mangca-target',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'mangcatarg','disabled']); !!}
                        <label for="mangcatarg">Manage Target</label>
                    </div>

                </div>
            </div>
        </div>
        </div>

    </div>



<!--PEOPLE-->
<h4>PEOPLE SECTION</h4>
<hr>
<div class="row">
    <div class="col-3">
        <h5 class="ml-3">Attendance & OT Module:</h5>
    <div class="col-lg-12">
        <div class="card border-left border-right border-info">

            <div class="card-body">
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'attendance-mark', in_array('attendance-mark',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'attendance1','disabled']); !!}
                    <label for="attendance1">Attdnce & OT</label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'attendance-preview', in_array('attendance-preview',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'attendance2','disabled']); !!}
                    <label for="attendance2">Preview  Attdnce</label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'overtime-preview', in_array('overtime-preview',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'overtime2','disabled']); !!}
                    <label for="overtime2">Preview OT </label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'overtime-report', in_array('overtime-report',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'overtime3','disabled']); !!}
                    <label for="overtime3">OT Reports </label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'bulk-auth', in_array('bulk-auth',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'bulkauth','disabled']); !!}
                    <label for="bulkauth">Bulk Auth'n</label>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-3">
        <h5 class="ml-3">Headcount Module:</h5>
    <div class="col-lg-12">
        <div class="card border-left border-right border-info">

            <div class="card-body">
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'hc-list', in_array('hc-list',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'hc1','disabled']); !!}
                    <label for="hc1">List </label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'hc-import', in_array('hc-import',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'hc4','disabled']); !!}
                    <label for="hc4">Import</label>
                </div>
                <!--<div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'hc-create', false,
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'hc2']); !!}
                    <label for="hc2">Create  </label>
                </div>-->
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'hc-edit', in_array('hc-edit',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'hc3','disabled']); !!}
                    <label for="hc3">Edit </label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'hc-activate', in_array('hc-activate',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'hc7','disabled']); !!}
                    <label for="hc7">Deactivate</label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'hc-delete', in_array('hc-delete',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'hc6','disabled']); !!}
                    <label for="hc6">Delete</label>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-3">
        <h5 class="ml-3">Attendance Report Module:</h5>
    <div class="col-lg-12">
        <div class="card border-left border-right border-info">
            <div class="card-body">
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'direct-manpower', in_array('direct-manpower',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'direct','disabled']); !!}
                    <label for="direct">Drct ManPower</label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'stdhrs-generated', in_array('stdhrs-generated',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'people1','disabled']); !!}
                    <label for="people1">Hrs Generated</label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'stdActual-hours', in_array('stdActual-hours',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'stdact','disabled']); !!}
                    <label for="stdact">Std & Actual Hrs</label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'target-report', in_array('target-report',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'targetR','disabled']); !!}
                    <label for="targetR">Target Report</label>
                </div>
            </div>
        </div>
    </div>
    </div>

    <div class="col-3">
        <h5 class="ml-3">People Report Module:</h5>
    <div class="col-lg-12">
        <div class="card border-left border-right border-info">
            <div class="card-body">
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'people-summary', in_array('people-summary',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'people2','disabled']); !!}
                    <label for="people2">Summary Rprt</label>
                </div>

                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'hc-summary', in_array('hc-summary',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'hc5','disabled']); !!}
                    <label for="hc5">HC Summary  </label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'plant-register', in_array('plant-register',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'register1','disabled']); !!}
                    <label for="register1">Plant Register</label>
                </div>
                <div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'shop-attendance', in_array('shop-attendance',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'peopless','disabled']); !!}
                    <label for="peopless">Shop Attndnce</label>
                </div>
				<div class="mb-2">
                    {!! Form::checkbox('permissions[]', 'plant-attendance', in_array('plant-attendance',$perms),
                        [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'plattend','disabled']); !!}
                    <label for="plattend">Plant Attndnce</label>
                </div>
            </div>
        </div>
    </div>
    </div>

    </div>




    <!--CONFIGURATION-->
    <h4>CONFIGURATION SECTION</h4>
    <hr>
    <div class="row">
        <div class="col-3">
            <h5 class="ml-3">View Settings Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'shops-list', in_array('shops-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'shop','disabled']); !!}
                        <label for="shop">Shops </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'route-list', in_array('route-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'route','disabled']); !!}
                        <label for="route">Routes  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'route-mapping', in_array('route-mapping',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'route1','disabled']); !!}
                        <label for="route1">Route Mapping </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'unit-category', in_array('unit-category',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'unit','disabled']); !!}
                        <label for="unit">Unit Category</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'shop-section', in_array('shop-section',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'shopsect','disabled']); !!}
                        <label for="shopsect">Sections</label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">App Users Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'appuser-list', in_array('appuser-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'appuser1','disabled']); !!}
                        <label for="appuser1">List </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'appuser-create', in_array('appuser-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'appuser2','disabled']); !!}
                        <label for="appuser2">Create  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'appuser-edit', in_array('appuser-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'appuser3','disabled']); !!}
                        <label for="appuser3">Edit </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'appuser-reset', in_array('appuser-reset',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'appuser4','disabled']); !!}
                        <label for="appuser4">Reset  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'appuser-delete', in_array('appuser-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'appuser5','disabled']); !!}
                        <label for="appuser5">Delete  </label>
                    </div>

                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">People Settings Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">
                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'set-default', in_array('set-default',$perms),
                            ['class' => 'material-inputs chk-col-cyan', 'id'=>'default','disabled']); !!}
                        <label for="default">Set Default Hrs</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'manage-target', in_array('manage-target',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'target','disabled']); !!}
                        <label for="target">Manage Target</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'view-target', in_array('view-target',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'target2','disabled']); !!}
                        <label for="target2">View Targets</label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'set-stdhrs', in_array('set-stdhrs',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'target3','disabled']); !!}
                        <label for="target3">Set STD Hours</label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">System Users Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'sysuser-list', in_array('sysuser-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'sysuser1','disabled']); !!}
                        <label for="sysuser1">List </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'sysuser-create', in_array('sysuser-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'sysuser2','disabled']); !!}
                        <label for="sysuser2">Create  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'sysuser-edit', in_array('sysuser-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'sysuser3','disabled']); !!}
                        <label for="sysuser3">Edit </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'sysuser-delete', in_array('sysuser-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'sysuser5','disabled']); !!}
                        <label for="sysuser5">Delete  </label>
                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="col-3">
            <h5 class="ml-3">More on Sys. Users Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">

                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'sysuser-activate', in_array('sysuser-activate',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'sysuser6','disabled']); !!}
                        <label for="sysuser6">Deactivate  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'sysuser-reset', in_array('sysuser-reset',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'sysuser4','disabled']); !!}
                        <label for="sysuser4">Reset  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'assign-shop', in_array('assign-shop',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'assgnshop','disabled']); !!}
                        <label for="assgnshop">Assign Shop</label>
                    </div>


                </div>
            </div>
        </div>
        </div>


        <div class="col-3">
            <h5 class="ml-3">Role & Rights Module:</h5>
        <div class="col-lg-12">
            <div class="card border-left border-right border-info">

                <div class="card-body">
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'role-list', in_array('role-list',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'role1','disabled']); !!}
                        <label for="role1">List </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'role-create', in_array('role-create',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'role3','disabled']); !!}
                        <label for="role3">Create  </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'role-edit', in_array('role-edit',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'role2','disabled']); !!}
                        <label for="role2">Edit </label>
                    </div>
                    <div class="mb-2">
                        {!! Form::checkbox('permissions[]', 'role-delete', in_array('role-delete',$perms),
                            [ 'class' => 'material-inputs chk-col-cyan', 'id'=>'role4','disabled']); !!}
                        <label for="role4">Delete  </label>
                    </div>

                </div>
            </div>
        </div>
        </div>

        </div>


            <hr>
                <div class="card-body">
                    <div class="form-group mb-0 text-right">
                        {{ Form::submit('Save', ['class' => 'btn btn-info btn-md','id'=>'submit-data']) }}


                        {{ link_to_route('roles.index', 'Cancel', [], ['class' => 'btn btn-dark waves-effect waves-light']) }}
                    </div>
                </div>


         {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>

    {!! Toastr::message() !!}

    @endsection

    @section('after-styles')
        {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
        {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}

    @endsection

    @section('after-scripts')
    {{ Html::script('assets/libs/jquery/dist/jquery.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
    {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
    {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}





<script type="text/javascript">

     /*$(document).on('submit', 'form#create-user', function(e){
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
                        //$('div.account_model').modal('hide');
                        toastr.success(result.msg);
                       // capital_account_table.ajax.reload();
                        //other_account_table.ajax.reload();

                        location.href = '{{ route("appusers.index") }}';
                    }else{
                         $("#submit-data").show();
                        toastr.error(result.msg);
                    }
                }
            });
        });*/

      $(document).on('ifChecked', '.check_all', function() {
        $(this)
            .closest('.check_group')
            .find('.input-icheck')
            .each(function() {
                $(this).iCheck('check');
            });
    });
    $(document).on('ifUnchecked', '.check_all', function() {
        $(this)
            .closest('.check_group')
            .find('.input-icheck')
            .each(function() {
                $(this).iCheck('uncheck');
            });
    });
       $('.check_all').each(function() {
        var length = 0;
        var checked_length = 0;
        $(this)
            .closest('.check_group')
            .find('.input-icheck')
            .each(function() {
                length += 1;
                if ($(this).iCheck('update')[0].checked) {
                    checked_length += 1;
                }
            });
        length = length - 1;
        if (checked_length != 0 && length == checked_length) {
            $(this).iCheck('check');
        }
    });
     //initialize iCheck
    $('input[type="checkbox"].input-icheck, input[type="radio"].input-icheck').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
    });


</script>

