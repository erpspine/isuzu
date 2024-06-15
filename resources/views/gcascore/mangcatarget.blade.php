

@extends('layouts.app')
@section('title','Set Targets')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">TARGETS</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">GCA TARGETS</li>
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
        <div class="col-sm-8 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered datatable-select-inputs">
                            <thead>

                                    <tr>
                                        <th>#</th>
                                        <th>MONTH</th>
                                        <th>CV DPV TARGET</th>
                                        <th>CV WDPV TARGET</th>
                                        <th>LCV DPV TARGET</th>
                                        <th>LCV WDPV TARGET</th>
                                        <th>ACTION</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!empty($targets))
                                        @foreach ($targets as $pl)
                                        <tr>
                                            <td>{{'#'}}</td>
                                            <td>{{\Carbon\Carbon::createFromFormat('Y-m-d',$pl->month)->format('F Y');}}</td>
                                            <td class="text-center">{{$pl->cvdpv}}</td>
                                            <td class="text-center">{{$pl->cvwdpv}}</td>
                                            <td class="text-center">{{$pl->lcvdpv}}</td>
                                            <td class="text-center">{{$pl->lcvwdpv}}</td>
                                            <td class="text-center">
                                                <a href="{{route('destroygcatag', $pl->id)}}"
                                                    class="btn btn-outline-danger btn-sm pull-right deltarget"><i
                                                    class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    @endif

                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Year</th>
                                    <th>Quarter</th>
                                    <th>CV DPV Target</th>
                                    <th>LCV WDPV Target</th>
                                    <th>CV DPV Target</th>
                                    <th>LCV WDPV Target</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                        </table>

                    <!--<div class="sticky-table sticky-ltr-cells">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr class="sticky-header">
                                        <th class="sticky-cell">Ford</th>
                                        <th class="sticky-cell">Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th class="sticky-cell-opposite">Escort</th>
                                        <th class="sticky-cell-opposite">Blue</th>
                                        <th class="sticky-cell-opposite">2000</th>
                                    </tr>
                                    <tr class="sticky-header">
                                        <th class="sticky-cell">Ford 2</th>
                                        <th class="sticky-cell">Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th class="sticky-cell-opposite">Escort 2</th>
                                        <th class="sticky-cell-opposite">Blue 2</th>
                                        <th class="sticky-cell-opposite">2000 2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>
                                    <tr>
                                        <td class="sticky-cell">Ford</td>
                                        <td class="sticky-cell">Escort</td class="sticky-cell">
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td>Escort</td>
                                        <td>Blue</td>
                                        <td>2000</td>
                                        <td>2000</td>
                                        <td>Ford</td>
                                        <td class="sticky-cell-opposite">Escort</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">Blue</td class="sticky-cell-opposite">
                                        <td class="sticky-cell-opposite">2000</td>
                                    </tr>

                                </tbody>
                                <tfoot>
                                    <tr class="sticky-footer">
                                        <th class="sticky-cell">Ford</th>
                                        <th class="sticky-cell">Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th>Escort</th>
                                        <th>Blue</th>
                                        <th>2000</th>
                                        <th>2000</th>
                                        <th>Ford</th>
                                        <th class="sticky-cell-opposite">Escort</th>
                                        <th class="sticky-cell-opposite">Blue</th>
                                        <th class="sticky-cell-opposite">2000</th>
                                    </tr>
                                    <tr class="sticky-footer">
                                        <th class="sticky-cell">Ford 2</th>
                                        <th class="sticky-cell">Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th>Escort 2</th>
                                        <th>Blue 2</th>
                                        <th>2000 2</th>
                                        <th>2000 2</th>
                                        <th>Ford 2</th>
                                        <th class="sticky-cell-opposite">Escort 2</th>
                                        <th class="sticky-cell-opposite">Blue 2</th>
                                        <th class="sticky-cell-opposite">2000 2</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>-->
                    </div>
                </div>

            </div>

            </div>

        {!! Toastr::message() !!}

        @endsection

        @section('after-styles')
            {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
            {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
            {{ Html::style('css/tablestick/jquery.stickytable.css') }}

        @endsection

        @section('after-scripts')
        {{ Html::script('assets/libs/jquery/dist/jquery.min.js') }}
        {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
        {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
        {{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
        {{ Html::script('js/tablestick/jquery.stickytable.js') }}
        {{ Html::script('js/tablestick/jquery.stickytable.js') }}

        <script type="text/javascript">
           //$(".select2").select2();
        </script>

        <script>


$(document).on('click', '.deltarget', function(e){

e.preventDefault();
        var txt = "You will delete the target from the system!";
        var btntxt = "Yes, Delete!";
        var color = "#DD6B55";

        Swal.fire({
            title: "Are you sure?",
            text: txt,
            type: "warning",
          //buttons: true,
        showCancelButton: true,
        confirmButtonColor: color,
        confirmButtonText: btntxt,
        cancelButtonText: "No, cancel please!",
        closeOnConfirm: false,
        closeOnCancel: false

          //dangerMode: true,
        }).then((result) => {
            if (Object.values(result) == 'true') {
                var href = $(this).attr('href');
                $.ajax({
                    method: "POST",
                    url: href,
                    dataType: "json",
                      data:{

                     '_token': '{{ csrf_token() }}',
                           },
                    success: function(result){
                        if(result.success == true){
                            toastr.success(result.msg);
                            //routingquery.ajax.reload();
                            window.location = "mangcatarget";
                        } else {
                            toastr.error(result.msg);
                        }
                    }
                });
            }
        });
    });
        </script>


