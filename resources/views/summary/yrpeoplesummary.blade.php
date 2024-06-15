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
            <h5 class="text-white mb-0">GRAPHICAL SUMMARY REPORTS</h5>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active text-white">MONTHLY PEOPLE REPORT</li>
            </ol>

        </div>
        <div class="col-md-7">
            <div class="row float-left w-100">
                <div class="col-lg-7">
                    <span  class="btn waves-effect waves-light btn-lg"
                    style="background-color: #DAF7A6; opacity: 0.9; font-familiy:Times New Roman;">

                    <h6 class="float-right mt-2">{{\Carbon\Carbon::today()->format('j M Y')}}</h6></span>
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
    @include('summary.peopleheader')
    <!-- Individual column searching (select inputs) -->
       <div class="row">
        <div class="col-md-12">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body analytics-info">

                        {{ Form::open(['route' => 'yrpeoplesummary', 'method' => 'GET'])}}
                            @csrf
                            <div class="row">
                                <div class="col-md-2">
                                    <label>Choose Section:</label>
                                    <select name="shopid" id="" class="form-control select2" required>
                                        <option value="">Select Section</option>
                                        <option value="plant">Plant</option>
                                        @foreach ($shops as $shop)
                                            <option value="{{$shop->id}}">{{$shop->shop_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label>Choose Year:</label>
                                    <select name="years" id="" class="form-control select2" required>
                                        <option value="">Select Year</option>
                                        @for ($i = 0; $i < count($years); $i++)
                                            <option valule="{{$years[$i]}}">{{$years[$i]}}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-2 mt-4">
                                    <button class="btn btn-warning ml-3"><i class="mdi mdi-filter"></i> Filter Year</button>
                                </div>
                                <div class="col-md-6">
                                    <h4 class="card-title" style="color: indigo; text-transform:uppercase;"><u><b>{{$selectedshop}} PEOPLE BARS - {{$selectedyr}} </b></u></h4>
                                </div>
                            </div>
                            {{ Form::close() }}


                            <div id="basic-bar" style="height:400px;"></div>
                        </div>
                    </div>
                </div>

            </div> <!-- end card-->
        </div> <!-- end col -->
    </div>


    @section('after-scripts')
    {{ Html::script('assets/libs/jquery/dist/jquery.min.js') }}
    {{ Html::script('js/jquery-1.11.0.min.js') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
    {{ Html::style('assets/extra-libs/prism/prism.css') }}
    {{ Html::style('assets/libs/bootstrap/dist/css/bootstrap.min.css') }}

    {{ Html::script('dist/js/app.min.js') }}

    {{ Html::script('assets/libs/echarts/dist/echarts-en.min.js') }}

    {{ Html::script('assets/extra-libs/prism/prism.js') }}
    {{ Html::script('assets/libs/popper.js/dist/umd/popper.min.js') }}
    {{ Html::script('assets/libs/bootstrap/dist/js/bootstrap.min.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
    {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}

    <script type="text/javascript">
        $(".select2").select2();
    </script>

    <script>
    $(function() {
    "use strict";
    // ------------------------------
    // Basic bar chart
    // ------------------------------
    // based on prepared DOM, initialize echarts instance
        var myChart = echarts.init(document.getElementById('basic-bar'));
        var MonthTLavail = <?php echo $MonthTLavail; ?>;
        var monthabsentiesm = <?php echo $monthabsentiesm; ?>;
        var monthplant_eff = <?php echo $monthplant_eff; ?>;

        // specify chart configuration item and data
        var option = {
                // Setup grid
                grid: {
                    left: '1%',
                    right: '2%',
                    bottom: '3%',
                    containLabel: true
                },

                // Add Tooltip
                tooltip : {
                    trigger: 'axis'
                },

                legend: {
                    data:['TL Availability','Absenteeism', 'Efficiency']
                },
                toolbox: {
                    show : true,
                    feature : {

                        magicType : {show: true, type: ['line', 'bar']},
                        restore : {show: true},
                        saveAsImage : {show: true}
                    }
                },
                color: ["#e98bcd", "#c10010", "#880E4F"],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        data : ['Jan','Feb','Mar','Apr','May','Jun','July','Aug','Sept','Oct','Nov','Dec']
                    }
                ],
                yAxis : [
                    {
                        type : 'value'
                    }
                ],
                series : [
                    {
                        name:'TL Availability',
                        type:'bar',
                        data:MonthTLavail,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],

                    },
                    {
                        name:'Absenteeism',
                        type:'bar',
                        data:monthabsentiesm,//[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],

                    },
                    {
                        name:'Efficiency',
                        type:'bar',
                        data:monthplant_eff,//[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],

                    }
                ]
            };
        // use configuration item and data specified to show chart
        myChart.setOption(option);


       //------------------------------------------------------
       // Resize chart on menu width change and window resize
       //------------------------------------------------------
        $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".sidebartoggler").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                        stackedChart.resize();
                        stackedbarcolumnChart.resize();
                        barbasicChart.resize();
                    }, 200);
                }
            });
});

</script>
