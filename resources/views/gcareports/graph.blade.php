<html>
    <body>
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        
    <div id="basic-bar" style="height:500px;"></div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>                          
{{ Html::script('assets/libs/echarts/dist/echarts-en.min.js') }}

<script>
    $(function() {
    "use strict";
    // ------------------------------
    // Basic bar chart
    // ------------------------------
    // based on prepared DOM, initialize echarts instance
        var myChart = echarts.init(document.getElementById('basic-bar'));
       

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
                        data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],

                    },
                    {
                        name:'Absenteeism',
                        type:'bar',
                        data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],

                    },
                    {
                        name:'Efficiency',
                        type:'bar',
                        data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],

                    }
                ]
            };
        // use configuration item and data specified to show chart
        myChart.setOption(option);
        var chartDataURL  = myChart.getDataURL({
            type: 'png', // You can also use 'jpeg' or other image formats
            pixelRatio: 2, // Adjust as needed for resolution
            backgroundColor: '#fff' // Background color of the image
        });

        $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

        $.ajax({
    type: 'POST', // or 'GET' depending on your server-side handling
    url: '{{ route("postpdf") }}', // Replace with the server-side route where you handle saving
    data: { chartDataURL: chartDataURL },
    success: function(response) {
        console.log('Chart image saved successfully');
    },
    error: function(error) {
        console.error(error);
    }
});

       //------------------------------------------------------
       // Resize chart on menu width change and window resize
       //------------------------------------------------------
      
});


</script>
</body>
</html>