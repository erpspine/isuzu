<html>

<head>
    <style>
        body {
            Century Gothic", CenturyGothic, AppleGothic, sans-serif;
font-size: 9pt;
        }

        p {
            margin: 0pt;
        }

        table.items {
            border: 0.1mm solid #000000;
        }

        table {
            font-family: "Century Gothic", CenturyGothic, AppleGothic, sans-serif;
            font-size: 13pt;
        }

        td {
            vertical-align: top;
        }

        .items td {
            border-left: 0.1mm solid #000000;
            border-right: 0.1mm solid #000000;
        }

        table thead td {
            background-color: #EEEEEE;
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

        .headings {
            font-size: 19pt;
        }

        .items td.totalss {
            text-align: right;
            border: 0.1mm solid #000000;
            text-transform: uppercase;
        }

        .items td.cost {
            text-align: "."center;
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

        .itemss {
            text-transform: uppercase;
            border: 0.1mm solid #000000;
        }

        .headerData {
            text-align: center;
            vertical-align: middle;
            text-transform: uppercase;
        }

        .dotted td {
            border-bottom: 0.1mm solid #000000;
        }

        .mycolor td {
            color: #000000;
        }

        table.print-friendly tr td,
        table.print-friendly tr th {
            page-break-inside: auto !important;
        }
        .weight {
            background-color: #ffc000;
        }
        .sum {
            background-color: #92d050;
        }
        .sumrow {
            background-color: #d9d9d9;
        }
        .wdpv{
            background-color: #c5d9f1;
            
        }
        .footertotal{
            background-color: #ffff00;
            

        }
        
        
        
    </style>
</head>

<body>
    <htmlpagefooter name="myfooter">
        <div style="border-top: 1px solid #000000; font-size: 8pt; text-align: center; padding-top: 3mm;width:100%">
            <div style="float:left; width:33% ">
                Printed By: Duncan Osur
            </div>
            <div style="float:left; width:33% ">
                Printed On: {{ date('d/m/Y') }}
            </div>
            <div style="float:left;width:33% ">
                Page {PAGENO} of {nb}
            </div>
        </div>
    </htmlpagefooter>
    <sethtmlpagefooter name="myfooter" value="on" />
    <table width="100%" style="font-size: 11pt;color:#000000;">
        <tr>
            <td width="20%">
            </td>
            <td width="60%" class="headerData">
                <h2>Isuzu East Africa Ltd</h2><br>P.O. Box 30527 Nairobi GPO, 00100 Kenya <br>Tel: 0800 724 724<br>
                <strong style="color:#000000;text-decoration:underline;">{{ $vehicletype }} GCA RAW DATA REPORT SAMPLE SIZE   <br /> DATE: {{ $range }}</strong>
            <td>
            <td width="15%">
            </td>
        </tr>
    </table>
        <table class="items" width="100%" style="font-size: 10pt; font-weight: bold; border-collapse: collapse; "
            cellpadding="8">
            <thead>
                <tr class="mycolor">
                    <td colspan="2">Day</td>
                    @foreach ( $dates as $date)
                    <td colspan="2">{{ $date['date_formated'] }}</td>
                        
                    @endforeach
                    
                    <td colspan="2">SUM</td>
               
                </tr>
                <tr class="mycolor">
                    <td>Category</td>
                    <td class="weight">W</td>
                    @foreach ( $dates as $date)
                    <td>DPV</td>
                    <td>WDPV</td>
                        
                    @endforeach
                    
                    <td>WDPV</td>
                    <td>DPV</td>
               
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $cat)
                @foreach ( $weighteddefects as $weight )
                <tr class="dotted">
         
                    <td >{{  $cat->name }}</td>
                    <td class="weight">{{  $weight->factor }}</td>
                    @php
                        $total=0;

                    @endphp
                    
                    @foreach ( $dates as $date)
                    <td>{{ $master[$date['date_db']][$cat->id][$weight->factor] }}</td>
                    <td class="wdpv">{{ $master[$date['date_db']][$cat->id][$weight->factor]*$weight->factor }}</td>
                    @endforeach
                    <td>{{ $masterperdatecount[$cat->id][$weight->factor]*$weight->factor }}</td>
                    <td>{{ $masterperdatecount[$cat->id][$weight->factor] }} </td>
                
                    
                </tr>
              
                @endforeach
                <tr class="dotted">
                    <td colspan="2" class="sum">Sum</td>
                    @foreach ( $dates as $date)
                    <td class="sumrow">{{ $mastercategorycount[$date['date_db']][$cat->id] }}</td>
                    <td class="sumrow">{{ $mastercategory[$date['date_db']][$cat->id] }}</td>
                    @endforeach
                    <td class="sum">{{ $masterwdpv[$cat->id] }}  </td>
                    <td class="weight">{{  $masterdpvcount[$cat->id]  }} </td>


                </tr>
            @endforeach 

            <tr class="dotted">
                <td colspan="2" class="sum" >Total</td>
                @foreach ( $dates as $date)
                <td class="footertotal">{{ $masterdpvtotal[$date['date_db']] }}    </td>
                <td class="footertotal">{{ $masterdatetotal[$date['date_db']] }}  </td>
                @endforeach
            </tr>
                
            </tbody>
        </table>





  
 
  
</body>

</html>
