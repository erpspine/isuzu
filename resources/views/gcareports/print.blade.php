<html>
<head>

<style>
body {sans-serif;
	font-size: 9pt;
}
p {	margin: 0pt; }
table.items {
	border: 0.1mm solid #000000;
	
}
table{
	font-family: "font-family: sans-serif;
	font-size: 13pt;
	
}
td { vertical-align: top; }
.items td {
	border-left: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
table thead td { 
	text-align: center;
	border: 0.1mm solid #000000;
	font-variant: small-caps;
}
.items td.blanktotal {
	background-color: #EEEEEE;
	border: 0.1mm solid #000000;
	background-color: #FFFFFF;
	border: 0mm none #000000;
	border-top: 0.1mm solid #000000;
	border-right: 0.1mm solid #000000;
}
.items td.totals {
	text-align: right;
	border: 0.1mm solid #000000;
}
.items td.totalsy {
	
	border: 0.1mm solid #000000;
}

.items td.totalss {
	text-align: right;
	border: 0.1mm solid #000000;
	text-transform: uppercase;
}
.items td.cost {
	text-align: "." center;
	text-transform: uppercase;
}
.invoice-title h1 {
    font-size: 50px;
    font-weight: lighter;
    text-align: center;
    margin: 0;
    text-transform: uppercase;
    padding: 5px;
    letter-spacing: 2px;
}
.itemss{
	text-transform: uppercase;
	border: 0.1mm solid #000000;
}
.headerData
{
    text-align:center; 
    vertical-align:middle;
}
.dotted td 
{
    border-bottom: dotted 1px black;
   
}
.quality td {
	
	background-color: #D6EEEE;
}
.corrective td {
	
	background-color: #FFFFE0;
}
.header td{
	border-bottom: solid 1px black;
	
}
.display td 
{
    border-bottom: dotted 1px black;
     line-height:9px;
    
}
.displaytwo td 
{
    border-bottom: dotted 1px black;
     line-height:4px;
    
}
.center
{
    text-align:center; 
    vertical-align:middle;
}

.row {
  display: -ms-flexbox; /* IE10 */
  display: flex;
  -ms-flex-wrap: wrap; /* IE10 */
  flex-wrap: wrap;
  padding: 0 4px;
}

/* Create four equal columns that sits next to each other */
.column {
  -ms-flex: 25%; /* IE10 */
  flex: 25%;
  max-width: 25%;
  padding: 0 4px;
}

.column img {
  margin-top: 8px;
  vertical-align: middle;
  width: 100%;
}

/* Responsive layout - makes a two column-layout instead of four columns */
@media screen and (max-width: 800px) {
  .column {
    -ms-flex: 50%;
    flex: 50%;
    max-width: 50%;
  }
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
  .column {
    -ms-flex: 100%;
    flex: 100%;
    max-width: 100%;
  }
}
.red{
    color:red;
}
.centre {
	text-align: "." center;
	
}
</style>
{{ Html::style('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css') }}
</head>
<body>


    
    <div class="row">
        <div class="col-12 ">
            <div class="card mt-2">
                <div class="card-header bg-primary  text-dark">{{ $title }}
                 
                
             </div>
            
    
                <div class="card-body">
    
          
                   
                    <div class="table-responsive sticky-table ">
                        <table class="table table-striped table-bordered" >
                            <thead>
                                <tr>
                                    <th rowspan="2"> Sample Size</th>
                                    <th colspan="3">DPV</th>
                                    <th colspan="3">WDPV</th>
                                </tr>
                                <tr>
                                    
                                    <th>Target</th>
                                    <th >Actual</th>
                                    <th >Status</th>
                                    <th>Target</th>
                                    <th >Actual</th>
                                    <th >Status</th>
                                </tr>
                            </thead>
                            <tbody>
                               <tr class="table-primary">
                                <td>{{ $sample_size }}</td>
                                <td>{{ $dpv_target }}</td>
                                <td>{{ $dpv }}</td>
                                <td>{{ $dpvtatus }}</td>
                                <td>{{ $wdpv_target }}</td>
                                <td>{{ $wdpv }}</td>
                                <td>{{ $wdpvtatus }}</td>
    
                               </tr>
                            </tbody>
                           
                        
    
    
    
                        
                        </table>
                    </div>
    
    
    
             
                </div>
            </div>
    
    
    
    
    
            <div class="card mt-2">
                <div class="card-header bg-primary  text-dark">REPORT BY CATEGORY</div>
    
    
                <div class="card-body">
    
     
                   
                    <div class="table-responsive sticky-table ">
                        <table class="table table-striped table-bordered" >
                            <thead>
                                <tr>
                                    <th>Total Vehicle Audited</th>
                                    <th>DPV</th>
                                    <th>WDPV</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $totaldpv=0;
                                    $totalwdpv=0;
                                @endphp
                                @foreach ($categories as $category )
                                @php
                                    $dpv=0;
                                    $wdpv=0;
                                    if($category->answers_sum_defect_count>0 && $sample_size>0){
                                        $dpv=$category->answers_sum_defect_count/$sample_size;
                                        $wdpv= @$category->answers->first()->total_price/$sample_size;
                                    }
                                    $totaldpv+=$dpv;
                                    $totalwdpv+=$wdpv;
                                @endphp
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $dpv }}</td>
                                    <td>{{ $wdpv }}</td>
        
                                   </tr>
                                    
                                @endforeach
                             
                            </tbody>
                        
                                <tr class="table-primary">
                                    <td>Total</td>
                                    <td>{{  $totaldpv }}</td>
                                    <td>{{  $totalwdpv }}</td>
                                </tr>
                            
                           
                        
    
    
    
                        
                        </table>
                    </div>
    
    
    
                   
                </div>
            </div>
    
    
    
    
            <div class="card page-break-before ">
                <div class="card-header bg-primary  text-dark">GRAPHICAL REPORT BY CATEGORY</div>
    
    
                <div class="card-body">
    
     
                   
                    <div id="basic-bar" style="height:400px;"></div>
    
    
    
                   
                </div>
            </div>
        </div>
    </div>
 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>                          
    
    {{ Html::script('https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js') }}

    {{ Html::script('assets/libs/echarts/dist/echarts-en.min.js') }}
<script>
      
    $(function() {
        "use strict";
    var myChart = echarts.init(document.getElementById('basic-bar'));
    var months = {!!  $catjson !!};
    var dpv = {{ $dpvjson }};
    var wdpv = {{ $wdpvjson }};
    var dpvTarget = {{ $dpv_target }}; // Adjust this value as needed
    var wdpvTarget = {{ $wdpv_target }}; // Adjust this value as needed
       // specify chart configuration item and data
       var option = {
    
        
         
    
                    // Setup grid
                    grid: {
                        left: '1%',
                        right: '2%',
                        bottom: '3%',
                        containLabel: true
                    },
    
                       // Add markLine for WDPV target
       
    
            // Add markLine for WDPV target
     
    
                    // Add Tooltip
                    tooltip : {
                        trigger: 'axis'
                    },
    
                    legend: {
                        data:['DPV','WDPV']
                    },
                    toolbox: {
                        show : true,
                        feature : {
    
                            magicType : {show: true, type: ['line', 'bar']},
                            restore : {show: true},
                            saveAsImage : {show: true}
                        }
                    },
                    color: ["#A6E0F7", "#1176F7"],
                    calculable : true,
                    xAxis: [
            {
                type: 'category',
                data: months,
                axisLabel: {
                    interval: 0,
                    rotate: 45,
                    textStyle: {
                        color: '#333'
                    }
                }
            }
        ],
                    yAxis : [
                        {
                            type : 'value'
                        }
                    ],
                    series : [
                        {
                            name:'DPV',
                            type:'bar',
                            data:dpv, //[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                            markLine: {
                symbol: 'none',
                data: [{
                    yAxis: dpvTarget,
                    name: 'DPV Target'
                }],
                lineStyle: {
                    normal: {
                        color: '#A6E0F7', // Color for the DPV target line
                        type: 'solid',
                        width: 2
                    }
                }
            },
    
                        },
                        {
                            name:'WDPV',
                            type:'bar',
                            data:wdpv, //[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                            markLine: {
                symbol: 'none',
                data: [{
                    yAxis: wdpvTarget,
                    name: 'WDPV Target'
                }],
                lineStyle: {
                    normal: {
                        color: '#1176F7', // Color for the WDPV target line
                        type: 'solid',
                        width: 2
                    }
                }
            },
    
                        }
                      
                    ]
                };
            // use configuration item and data specified to show chart
            myChart.setOption(option);     
    
            $(function () {
    
    // Resize chart on menu width change and window resize
    $(window).on('resize', resize);
    $(".sidebartoggler").on('click', resize);
    
    // Resize function
    function resize() {
        setTimeout(function() {
    
            // Resize chart
            myChart.resize();
           // stackedChart.resize();
            //stackedbarcolumnChart.resize();
            //barbasicChart.resize();
        }, 200);
    }
    });
    });
    </script>






</body>
</html>