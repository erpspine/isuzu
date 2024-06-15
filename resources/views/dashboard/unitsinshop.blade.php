<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Summary</title>

    @include('layouts.header.header')
    @yield('after-styles')
</head>
<body>

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles" style="background-color:#da251c;">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-white mb-0">REALTIME UNIT POSITION TRACKING</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active text-white">UNIT IN <span style="text-transform: uppercase;">{{$shopname}}</span> </li>
            </ol>

        </div>
        <div class="col-md-7">
            <div class="row float-left w-100">
                <div class="col-lg-7">
                    <span  class="btn waves-effect waves-light btn-lg"
                    style="background-color: #DAF7A6; opacity: 0.9; font-familiy:Times New Roman;">

                    <h5 class="float-right mt-2">{{\Carbon\Carbon::today()->format('j M Y')}}</h5></span>
                </div>
                <div class="col-5">
                    <a href="{{route('dashboard')}}" id="btn-add-contact" class="btn btn-primary float-right"
               ><i class="mdi mdi-arrow-left font-16"></i> Back</a>
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

         <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered datatable-select-inputs no-wrap">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Date In</th>
                                            <th>Vin No.</th>
                                            <th>Shop</th>
                                            <th>Model Name.</th>
                                            <th>Lot No.</th>
                                            <th>Job No.</th>
                                            <th>No. of days</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (count($units) > 0)
                                            @foreach ($units as $item)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$item->datetime_in}}</td>
                                                <td>{{$item->vehicle->vin_no}}</td>
                                                <td>{{$item->shop->shop_name}}</td>
                                                <td>{{$item->models->model_name}}</td>
                                                <td>{{$item->vehicle->lot_no}}</td>
                                                <td>{{$item->vehicle->job_no}}</td>
                                                <td>{{\Carbon\carbon::parse($item->datetime_in)->diffInDays(\Carbon\carbon::parse($today))}}</td>
                                            </tr>
                                            @endforeach
                                        @endif

                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Date In</th>
                                            <th>Vin No.</th>
                                            <th>Shop</th>
                                            <th>Model Name.</th>
                                            <th>Lot No.</th>
                                            <th>Job No.</th>
                                            <th>No. of days</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
            </div>



@section('after-scripts')
<script>
     var time = new Date().getTime();
     $(document.body).bind("mousemove keypress", function(e) {
         time = new Date().getTime();
     });

     function refresh() {
         if(new Date().getTime() - time >= 60000)
             window.location.reload(true);
         else
             setTimeout(refresh, 10000);
     }

     setTimeout(refresh, 10000);
</script>

  @endsection
