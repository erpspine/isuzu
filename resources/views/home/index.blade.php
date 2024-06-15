@extends('layouts.app')

@section('content')
<div class="row page-titles">

</div>
<!-- ============================================================== -->
<!-- End Bread crumb and right sidebar toggle -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- Container fluid  -->
<!-- ============================================================== -->
<div class="container-fluid">

<div class="card-columns widget-app-columns">
   
    <!-- People Card  -->
    <div id="people"  class="card">
        <button  id="peopespinner" class="btn btn-primary" type="button" disabled>
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Loading...
          </button>

    </div>
     
        
        <!-- People Card  -->
        <div id="quality"  class="card">

           
                <button id="qualityspinner" class="btn btn-primary" type="button" disabled>
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    Loading...
                  </button>
          
           

        </div>
          <!-- People Card  -->
      
        <div id="responsiveness"  class="card">

      
            <button  id="responsivenessspinner" class="btn btn-primary" type="button" disabled>
                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                Loading...
              </button>

        
       

      </div>
            

                  



                   

<!-- Row -->
</div>
<div id="attendance" class="row">
    <button id="attendancespinner" class="btn btn-primary" type="button" disabled>
        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
        Loading...
      </button>

</div>

@endsection
@section('after-styles')
    {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
@section('after-scripts')
{{ Html::script('assets/libs/gaugeJS/dist/gauge.min.js') }}
{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}

{!! Toastr::message() !!}

<script type="text/javascript">


$.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
	});
    //people
	$.ajax({
        type: "GET",
        url: "{{ url('loadpeopledashboard')}}",
        dataType: "html",
        success: function (data) {
          
			$("#people").html(data);
            $("#peopespinner").hide();
            
			
        },
    });

        //quality
	$.ajax({
        type: "GET",
        url: "{{ url('loadqualitydashboard')}}",
        dataType: "html",
        success: function (data) {
         
			$("#quality").html(data);
            $("#qualityspinner").hide();
            
			
        },
    });

          //responsivvness
	$.ajax({
        type: "GET",
        url: "{{ url('loadresponsivenessdashboard')}}",
        dataType: "html",
        success: function (data) {
         
			$("#responsiveness").html(data);
            $("#responsivenessspinner").hide();
			
        },
    });

          //attendance
	$.ajax({
        type: "GET",
        url: "{{ url('loadattendancedashboard')}}",
        dataType: "html",
        success: function (data) {
         
			$("#attendance").html(data);
            $("#attendancespinner").hide();
            
			
        },
    });

    

</script>

@endsection

