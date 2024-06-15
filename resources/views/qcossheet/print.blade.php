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
</head>
<body>
 
                                    
    
        <div style="width:100%">
            <div style="width: 69%;float: left;">
        <table  width="100%"class="items"  width="100%" style="font-size: 9pt; border-collapse: collapse;margin-top:8px; " cellpadding="8"   >
            <thead>
        <tr>
        <td width="32%">
            <img src="{{url('upload/logo/logo.jpg')}}" style="width:90px" />
            
        </td>
        <td width="67%" colspan="2" class="headerData" ><h2>DAILY QCOS MONITORING SHEET </h2></td>

            </tr>

            <tr >
                <td style="text-align: left;">Date: &nbsp;&nbsp;<span class="red">{{ dateFormat($date_from) }}   &nbsp;&nbsp;To&nbsp;  {{ dateFormat($date_to)  }}</span></td>
                <td style="text-align: left;" >DEPARTMENT/SHOP: &nbsp;&nbsp;<span class="red">{{ $shop }} </span> </td>
                <td style="text-align: left;" >MODEL: &nbsp;&nbsp;<span class="red">{{ $model }}</span></td>

            </tr>
            <tr>
                <td style="text-align: left;">UPC: &nbsp;&nbsp;<span class="red">{{ $joint_details->upc }}</span></td>
                <td style="text-align: left;">Sheet Number: &nbsp;&nbsp;<span class="red">{{ $joint_details->sheet_no }}</span></td>
                <td style="text-align: left;" >TEAM LEADER: &nbsp;&nbsp;<span class="red">{{ $team_leader }}</span></td>
                

            </tr>
            <tr>
                <td style="text-align: left;">Line/Area/Team:&nbsp;&nbsp; <span class="red">{{ $joint_details->station_used }} </span></td>
                <td style="text-align: left;">Operation Description: <span class="red">{{ $joint_details->part_name_joint_id }} </span></td>
                <td style="text-align: left;" >KCDS CODE: &nbsp;&nbsp;<span class="red">{{ $joint_details->kcds_code }}</span></td>
               
                

            </tr>
            <tr>
                <td style="text-align: left;">
                    Tool Type: <span class="red">&nbsp;&nbsp;&nbsp;&nbsp;{{ $joint_details->tool->tool_type }}</span><br/><hr/>
                    Sample Size: &nbsp;&nbsp;<span class="red">{{ $joint_details->sample_size }}</span>
                

                </td>
                <td style="text-align: left;" >
                  
                    Monitoring Tool No: &nbsp;&nbsp;&nbsp;<span class="red">{{ $joint_details->tool->tool_id }}</span> 
                          
                          
              
                    


                    
                </td>
                <td style="text-align: left;" >
                    Production Tool No: <span class="red">&nbsp;&nbsp;</span>
                  
                 
                   
            


            
        </td>
               
                

            </tr>
        </thead>

        </table>
      
    </div>


    <div style="width: 30%;float: left;">
        <table  width="100%"class="items"  width="100%" style="font-size: 9pt; border-collapse: collapse;margin-top:8px; " cellpadding="8"   >
            <thead>
                
            <tr>
                <td colspan="2"><img src="{{asset('upload/qcos/'.$joint_details->image_one);}}" style="height:200px" />  </td>
            </tr>
         
            </thead>
        </table>
     
    </div>

    </div>

 
               
          


        
     
    <div style="width:100%;">
        <div style="width: 100%;float: left;">
            <div style="height:350px;" >
              
               
                    <canvas id="line-chart" data-height="300"></canvas>
               
            </div>

            <table class="items" width="100%" style="font-size: 9pt; border-collapse: collapse;margin-top:8px; " cellpadding="8">
     
<tbody>
    <tr class="dotted display " >
        <td style="font-size:7pt" width="13%">Date</td>
        @foreach ($records  as $row)
        <td style="font-size:7pt" width="2%">{{ $production_days[$row->qcos_ref] }}</td>
            
        @endforeach
  </tr>
  <tr class="dotted display " >
    <td style="font-size:7pt" width="13%">Production Audit result</td>
    @foreach ($records  as $row)
    <td style="font-size:7pt" width="2%">{{ isset($production_plot[$row->qcos_ref]) ? $production_plot[$row->qcos_ref] : "" }}  </td>
        
    @endforeach
</tr>
<tr class="dotted display" >
  <td style="font-size:7pt" width="13%">#VIN/Serial</td>
  @foreach ($records  as $row)
  <td style="font-size:7pt" width="2%">{{ isset($production_vin[$row->qcos_ref]) ? $production_vin[$row->qcos_ref] : "" }}  </td>
  
  @endforeach
  </tr>
  <tr class="dotted display quality" >
    <td style="font-size:7pt" width="13%">Quality Monitor Result</td>
    @foreach ($records  as $row)
    <td style="font-size:7pt" width="2%">{{ isset($quality_plot[$row->qcos_ref]) ? $quality_plot[$row->qcos_ref] : "" }}       </td>
    
    @endforeach
    </tr>
    <tr class="dotted display quality" >
      <td style="font-size:7pt" width="13%">VIN/Serial</td>
      @foreach ($records  as $row)
      <td style="font-size:7pt" width="2%">{{ isset($quality_vin[$row->qcos_ref]) ? $quality_vin[$row->qcos_ref] : "" }}</td>
      
      @endforeach
      </tr>




  
 
   



    </tbody>
    
    </table>
    </div>

    </div>
    <!---End report top----->
    <div style="width:100%;">
    <div style="width: 15%;float: left;margin-top:8px;margin-left:2px;font-size:6pt">
        <p>
            <strong>UCL</strong>-UPPER CONTROL LIMIT<br>
            <strong> LCL</strong>-LOWER CONTROL LIMIT<br>
            <strong>USL</strong>-UPPER SPECIFICATION LIMIT<br>
            <strong>LSL</strong>-LOWER SPECIFICATION LIMIT<br>
           

        </p>
       
      
    </div>
    <div style="width: 39%;float: left;margin-top:8px;margin-right:7px;font-size:6pt">
        <span style="text-decoration: underline;font-weight:bold"> INSTRUCTIONS</span>
        <p>*The Production Team Leader takes  readings and inputs the values into the TTMS module in PQCS .Sample size - as per TTMS data Sheet. </p>
        <p>*The Quality Operations takes a reading and writes the values down.  and inputs the values into the TTMS module in PQCS .Sample size - as per TTMS data Sheet.</p>
        <p>*If a measurement is outside the specification (USL to LSL the system will generate two actions : recalibration of the Prodution Torque Tool and Containment and send notifications to all Torque Stakeholders.</p>
    </div>

    <div style="width: 41%;float: left;margin-top:8px;font-size:6pt">
        <span style="text-decoration: underline;font-weight:bold"> Signs of Instability</span>
        <p><b>ESCALATION PROCESS</b> Must be instituted on detection of any point outside the specification limits.(usl to lsl)
        </p>
        <span style="text-decoration: underline;font-weight:bold"> Team Leader Responsibility</span>
        <p><b>Inform GL</b>, and take tool to maintenance workshop for <b>resetting to achieve spec at the joint</b>. Perform containment and update the Action Center in PQCS to resolve and close the action. <span style="color:red;">This trend chart and action plan should be printed and dispyayed on the TTMS board by TL for each model every month.</span>  
        </p>
        <span style="text-decoration: underline;font-weight:bold"> Tool Technician</span>
        <p>Adjust the tool to specification (Refer to Torque spec) and update the Action Center in PQCS to resolve and close the action.
        </p>

    </div>
   
    
     

</div>



    <!---End progressive summary----->



        
     
       
        
        
        
        
        
        </div>

 {{ Html::script('assets/libs/chart.js/dist/Chart.min.js') }} 

      
 <script type="text/javascript">

  new Chart(document.getElementById("line-chart"), {
      type: 'line',
      data: {
      labels: {!! json_encode($production_days_plot)!!},
      datasets: [{ 
        data: {!! json_encode($usl)!!},
        label: "USL {{ $joint_details->upper_specification_limit }}",
        borderColor: "#ff6384",
        fill: false
        }, { 
        data: {!! json_encode($ucl)!!},
        label: "UCL {{ $joint_details->upper_control_limit }}",
        borderColor: "#FFFF00",
        fill: false
        }, { 
        data: {!! json_encode($mean)!!},
        label: "MEAN {{ $joint_details->mean_toque }}",
        borderColor: "#07b107",
        fill: false
        }, { 
        data: {!! json_encode($lcl)!!},
        label: "LCL {{ $joint_details->lower_control_limit }}",
        borderColor: "#FFFF00",
        fill: false
        }, { 
        data: {!! json_encode($lsu)!!},
        label: "LSL {{ $joint_details->lower_specification_limit }}",
        borderColor: "#ff6384",
        fill: false
        },
            { 
        data: {!! json_encode($production)!!},
        label: "Production",
        borderColor: "#000000",
        fill: false
        },
            { 
        data: {!! json_encode($quality)!!},
        label: "Quality",
        borderColor: "#FF8C00",
        fill: false
        }
      ]
      },
      options: {
          responsive: true,
      maintainAspectRatio: false,
      title: {
        display: true,
        text: 'TREND CHART - QCOS'
      }
      }
    }); 
         </script>







</body>
</html>