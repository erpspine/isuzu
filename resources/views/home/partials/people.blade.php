
    <div class="card-body">
        <div class="d-flex ">
            <h4 class="card-title ml-3">PEOPLE</h4>

        </div>

        <div class="col-lg-12 mb-4">
            <div class="card-header bg-primary mb-3">
               <h4 class="mb-0 text-white">MTD ABSENTIEESM</h4>
            </div>
                <div class="gaugejs-box">
                    <canvas id="absentieesm" class="gaugejs1">guage</canvas>
                    <hr>
                    <div class="text-center aline">
                        <h4 class="font-weight-light mb-3"><span style="margin-right: 12%;">Actual: {{$master['absentiesm']}}%</span>
                            Target: {{$master['plantabb']}}%</h4>

                     </div>
                </div>
        </div>

        <div class="col-lg-12 mb-4">
            <div class="card-header bg-primary mb-3">
               <h4 class="mb-0 text-white">MTD T/L AVAILABILITY</h4>
            </div>
                <div class="gaugejs-box">
                    <canvas id="tlavail" class="gaugejs2">guage</canvas>
                    <hr>
                    <div class="text-center aline">
                        <h4 class="font-weight-light mb-3"><span style="margin-right: 12%;">Actual: {{$master['TLavail']}}%</span>
                            Target: {{$master['planttlav']}}%</h4>
                     </div>
                </div>
        </div>
        </div>
      
        <style type="text/css">
            .gaugejs1 {
                    margin-top: 0px;
                    width: 52%;
                    margin-left: 20%;
            }
            .gaugejs2 {
                    margin-top: 0px;
                    width: 52%;
                    margin-left: 20%;
            2
            
            .aline{
                margin-bottom: 9%;
            }
            
            </style>

        <script type="text/javascript">
        
$(function(){
//ABSENTIEESM
var opts = {
        angle: 0, // The span of the gauge arc
        lineWidth: 0.2, // The line thickness
        radiusScale: 1.1, // Relative radius
        pointer: {
            length: 0.60, // // Relative to gauge radius
            strokeWidth: 0.05, // The thickness
            color: '#000000' // Fill color
        },
        limitMax: false, // If false, the max value of the gauge will be updated if value surpass max
        limitMin: false, // If true, the min value of the gauge will be fixed unless you set it manually
       // colorStart: '#009efb', // Colors
        //colorStop: '#009efb', // just experiment with them
        //strokeColor: '#E0E0E0', // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,
        staticZones: [
        {strokeStyle: "#30B32D", min: 0, max:'{{$master['plantabb']}}' }, // Red from 100 to 130
        {strokeStyle: "#F03E3E", min: '{{$master['plantabb']}}', max: 100}  // Red

], // High resolution support
    };
    var value = '{{$master['absentiesm']}}';
    var effy = document.getElementById('absentieesm'); // your canvas element
    var gauge = new Gauge(effy).setOptions(opts); // create sexy gauge!
    gauge.maxValue = 100; // set max gauge value
    gauge.setMinValue(0); // Prefer setter over gauge.minValue = 0
    gauge.animationSpeed = 45; // set animation speed (32 is default value)
    gauge.set(value); // set actual value


    //TL AVAIBAVILITY
    var opts = {
        angle: 0, // The span of the gauge arc
        lineWidth: 0.2, // The line thickness
        radiusScale: 1.1, // Relative radius
        pointer: {
            length: 0.60, // // Relative to gauge radius
            strokeWidth: 0.05, // The thickness
            color: '#000000' // Fill color
        },
        limitMax: false, // If false, the max value of the gauge will be updated if value surpass max
        limitMin: false, // If true, the min value of the gauge will be fixed unless you set it manually
       // colorStart: '#009efb', // Colors
        //colorStop: '#009efb', // just experiment with them
        //strokeColor: '#E0E0E0', // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,
        staticZones: [
    {strokeStyle: "#F03E3E", min: 0, max:'{{$master['planttlav']}}' }, // Red from 100 to 130
    {strokeStyle: "#30B32D", min: '{{$master['planttlav']}}', max: 100}  // Red

], // High resolution support
    };
    var value = '{{$master['TLavail']}}';
    var effy = document.getElementById('tlavail'); // your canvas element
    var gauge = new Gauge(effy).setOptions(opts); // create sexy gauge!
    gauge.maxValue = 100; // set max gauge value
    gauge.setMinValue(0); // Prefer setter over gauge.minValue = 0
    gauge.animationSpeed = 45; // set animation speed (32 is default value)
    gauge.set(value); // set actual value

});



$(function() {
    "use strict";

         $("#sparkline1").sparkline([0,75,80,56,96,90,56,85,33,60,60,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#e3c1f0',
            fillColor: '#e3c1f0',
            minSpotColor:'#e3c1f0',
            maxSpotColor: '#e3c1f0',
            highlightLineColor: 'rgba(227, 193, 240, 0.2)',
            highlightSpotColor: '#e3c1f0'
        });


   $("#sparkline2").sparkline([0,75,80,56,96,90,56,85,33,60,60,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#bae592',
            fillColor: '#bae592',
            minSpotColor:'#bae592',
            maxSpotColor: '#bae592',
            highlightLineColor: 'rgba(227, 193, 240, 0.2)',
            highlightSpotColor: '#bae592'
        });


       $("#sparkline3").sparkline([0,56,55,55,85,58,57,60,50,70,80,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#1e88e5',
            fillColor: '#1e88e5',
            minSpotColor:'#1e88e5',
            maxSpotColor: '#1e88e5',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#1e88e5'
        });

  $("#sparkline4").sparkline([0,56,55,55,85,58,57,60,50,70,80,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#ffa056',
            fillColor: '#ffa056',
            minSpotColor:'#ffa056',
            maxSpotColor: '#ffa056',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#ffa056'
        });

    $("#sparkline5").sparkline([0,56,55,55,85,58,57,60,50,70,80,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#8dddd0',
            fillColor: '#8dddd0',
            minSpotColor:'#8dddd0',
            maxSpotColor: '#8dddd0',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#8dddd0'
        });

        $("#sparklineGCA").sparkline([0,56,55,55,85,58,57,60,50,70,80,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#8dddd0',
            fillColor: '#8dddd0',
            minSpotColor:'#8dddd0',
            maxSpotColor: '#8dddd0',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#8dddd0'
        });

        $("#sparkline6").sparkline([0,56,55,55,85,58,57,60,50,70,80,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#ccc210',
            fillColor: '#ccc210',
            minSpotColor:'#ccc210',
            maxSpotColor: '#ccc210',
            highlightLineColor: 'rgba(204, 194, 16, 0.2)',
            highlightSpotColor: '#ccc210'
        });

        $("#sparkline7").sparkline([0,56,55,55,85,58,57,60,50,70,80,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#00ffff',
            fillColor: '#00ffff',
            minSpotColor:'#00ffff',
            maxSpotColor: '#00ffff',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#00ffff'
        });


         $("#sparkline8").sparkline([0,70,50,50,80,90,50,80,60,60,60,75 ], {
            type: 'line',
            width: '100%',
            height: '50',
            lineColor: '#fc4b6c',
            fillColor: '#fc4b6c',
            minSpotColor:'#fc4b6c',
            maxSpotColor: '#fc4b6c',
            highlightLineColor: 'rgba(0, 0, 0, 0.2)',
            highlightSpotColor: '#fc4b6c'
        });

});

</script>