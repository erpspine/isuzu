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
            <h3 class="text-white mb-0">WORK IN PROGRESS TRACKING</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active text-white">WIP TRACKING</li>
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
                    <a href="/home" id="btn-add-contact" class="btn btn-primary float-right"
               ><i class="mdi mdi-arrow-left font-16"></i> Back to Home</a>
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
                            <!-- Column -->

                    @foreach($shops as $shop)

                        <div class="col-lg-3 col-md-6">
                        <div class="card border-bottom border-info">
                            <div class="card-body">
                                <div class="d-flex no-block align-items-center">
                                    <div>
                                        <h2>
                                            @if ($shop->buffer == 1)
                                            <span>{{$buffer[$shop->id]}}</span>
                                            <span>|</span>
                                            <span>{{$inshop[$shop->id]}}</span> </h2>
                                            @else
                                            {{count($shop->unitmovement)}}
                                            @endif
                                        <h3 class="text-info">
                                            <a href="{{ route('unitspershop', $shop->id)}}">{{$shop->shop_name}}</a>
                                        </h3>
                                    </div>
                                    <div class="ml-auto">
                                        <span class="text-info display-6"><i class="ti-truck"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach

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
