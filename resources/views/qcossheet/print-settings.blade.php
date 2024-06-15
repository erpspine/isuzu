<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>Print QCOS</title>
   
</head>
<body>
<button class="btn btn-success" onclick="window.print()">Print</button>
<div id="preview_body">
    @include('qcossheet.print')
</div>

 <style>

    @media print{@page {size: landscape}}
    @media print{
        .content-wrapper{
          border-left: none !important; /*fix border issue on invoice*/
        }
        .label-border-outer{
            border: none !important;
        }
        .label-border-internal{
            border: none !important;
        }
        .sticker-border{
            border: none !important;
        }
        #preview_box{
            padding-left: 0px !important;
        }
        #toast-container{
            display: none !important;
        }
        .tooltip{
            display: none !important;
        }
        .btn{
            display: none !important;
        }
    }

    .chartjs-size-monitor,
.chartjs-size-monitor-shrink,
.chartjs-size-monitor-expand,
.chartjs-size-monitor-expand > div {
   position: fixed !important; 
}

    </style>
</body>
</html>