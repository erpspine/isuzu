
@extends('layouts.app')
@section('title','DRL Report')

@section('content')


    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">DIRECT RUN LOSS REPORTxx</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">Drl Report</li>
            </ol>
        </div>

        <div class="col-md-7 col-12 align-self-center d-none d-md-block">
            <div class="d-flex mt-2 justify-content-end">
                {{$heading}}
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
       

{{ Form::open(['route' => 'filterdailydrl', 'role' => 'form', 'method' => 'post'])}}
        <div class="row">

           
            


            <div class="col-lg-3 mb-2">
                <div class="row">
                    <div class="col-md-4">
                        <input name="period" value="today"  class="material-inputs date_type " type="radio" id="date_1" {{ (decrypt_data($period) == 'today') ? 'checked' : ''  }} />
                        <label for="date_1">Today</label>
                    </div>
                    <div class="col-md-4">
                        <input name="period" value="month_to_date" class="material-inputs date_type" type="radio" id="date_2" {{ (decrypt_data($period) == 'month_to_date') ? 'checked' : ''  }} />
                        <label for="date_2">MTD</label>
                    </div>
                  
                
                   
                </div>
            </div>
        
            <div class="col-lg-3 mb-4">

                <div class="row">
                    <div class="col-md-4">
                        <input name="section" value="plant"  class="material-inputs" type="radio" id="radio_1" {{ (decrypt_data($section) == 'plant') ? 'checked' : ''  }}  />
                        <label for="radio_1">Plant</label>
                    </div>
                    <div class="col-md-4">
                        <input name="section" value="cv" class="material-inputs" type="radio" id="radio_2" {{ (decrypt_data($section) == 'cv') ? 'checked' : ''  }} />
                        <label for="radio_2">CV</label>
                    </div>
                    <div class="col-md-4">
                        <input name="section" value="lcv" type="radio" class="with-gap material-inputs" id="radio_3" {{ (decrypt_data($section) == 'lcv') ? 'checked' : ''  }} />
                        <label for="radio_3">LCV</label>
                    </div>
                 
                
                   
                </div>


             
            </div>

            <div class="col-lg-6  mb-6">
                <div class="row ">

                    <div class="col-12" id="today_date">
                       
                      
                        <div class="row">
                        <div class="col-4">
                        <div class="form-group">
                          
                            <input class="form-control from_custom_date" type="text" id="today"
                                required="" name="daily_date" value="{{$datepicker_day}}"  data-toggle="datepicker" autocomplete="off"  >
                        </div>
                        </div>
                
                
                
                
                       
                    <div class="col-4">
                        <button type="submit" class="btn btn-success ">Filter By Date</button>
                    </div>
                </div>
                </div>

                <div class="col-12" id="month_date">
                   
                    <div class="row">
                    <div class="col-4">
                    <div class="form-group">
                    
                        <input class="form-control from_custom_date" type="text" id="datepicker"
                            required="" name="month_date" value="{{$datepicker_month}}"  data-toggle="datepicker" autocomplete="off"  >
                    </div>
                    </div>
       
       
       
       
                   
                <div class="col-4">
                    <button type="submit" class="btn btn-success">Filter By Month</button>
                </div>
            </div>
               
            </div>
        
        </div>

  
            </div>
        
        
       

            
         
        </div>

        {{ Form::close() }}
  
    <!-- Individual column searching (select inputs) -->


    <div class="row">
        <div class="col-12">
            <div class="card">


                <div class="card-body ">
                   
                    <div  class="table-responsive sticky-table ">
                        <table  class="table table-striped table-bordered" >
                            <thead>

                                   <tr class="sticky-header">
                                    <th class="sticky-cell" colspan = "{{(count($shops)*2)+1}}" > {{$heading}}</th>
                                
                                </tr>

                              <tr class="sticky-header">
                                    <th class="sticky-cell"  rowspan = "2" >Models&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </th>
                                      @foreach ($shops as $item)
                                    <th class="sticky-cell" colspan = "2">{{$item->shop_name}}</th>
                                    @endforeach
                                   
                                </tr>

                                <tr class="sticky-header" >
                                    @foreach ($shops as $item)
                                    <th class="sticky-cell"  style="background-color: {{$item->color_code}}" >Units</th>
                                    <th class="sticky-cell" style="background-color: {{$item->color_code}}" >Defects</th>
                                    @endforeach
                                    
                                    
                                 
                                </tr>

                              

                            </thead>

                            <tbody>

                            @php
                              
                            @endphp
                                @if(count($vehicles) > 0)
                           
                                @foreach($vehicles as $vehicle)
                                    <tr >
                                        <td  class="sticky-cell">
                                            {{$vehicle->model->model_name}} LOT {{$vehicle->lot_no}}
                                        </td class="sticky-cell">
                                        @foreach ($shops as $shop)
                                     
                                          <td style="background-color: {{$shop->color_code}}">{{$drl_arr[$vehicle->model_id][$vehicle->lot_no][$shop->id]['units']}}</td>
                                           <td style="background-color: {{$shop->color_code}}">{{$drl_arr[$vehicle->model_id][$vehicle->lot_no][$shop->id]['defects']}}</td>
                                    @endforeach
                                      
                                       
                                        
                                    </tr>
                                @endforeach
                                @endif
                             </tbody>

                             <tfoot>

                        
                        
                            <tr class="table-primary">
                                <th><strong>TOTAL</strong></th>
                                 @foreach ($shops as $item)
                             
                    <th  >{{ $totals_pershop[$item->id]['offlineunit'] }}</th>
                    <th  >{{ $totals_pershop[$item->id]['total_defects'] }} </th>
                   
                    @endforeach

                            </tr>


                            <tr class="table-warning">
                                <th><strong>ACTUAL  SCORE</strong></th>
                                 @foreach ($shops as $item)

                               



                            
                    <th class=" text-center text-white  {{ ($totals_pershop[$item->id]['drl_pershop'] < $totals_pershop[$item->id]['target']) ? 'bg-ok' : 'bg-nok'}}"  colspan="2"  >{{  $totals_pershop[$item->id]['drl_pershop'] }} </th>
                   
                    @endforeach
                            </tr>

                            <tr class="table-success">
                                <th ><strong>TARGET</strong></th>
                                 @foreach ($shops as $item)


                                
                    <th class=" text-center" colspan="2" >{{  $totals_pershop[$item->id]['target'] }}</th>
                 
                    @endforeach
                            </tr>

                            <tr >

                                <th  class="text-white {{ ($plant_drl <  $plant_target) ? 'bg-ok' : 'bg-nok'}}"   colspan = "{{(count($shops))-9}}" >PLANT DRL : <strong >{{ $plant_drl }}</strong></th>

                                <th colspan = "{{(count($shops))+10}}" >PLANT TARGET : <strong>{{ $plant_target }} </strong></th>
                     

                   </tr>

                </tfoot>
                        
                        </table>

                        @php
                          //  print_r($totalunits);
                        @endphp
                 
                    </div>
                </div>
            </div>
        </div>
    </div>


 


                            

@endsection
@section('after-styles')
{{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
   {{ Html::style('assets/libs/datepicker/datepicker.min.css') }}
      {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
    {{ Html::style('assets/libs/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}
    {{ Html::style('assets/libs/sweetalert2/dist/sweetalert2.min.css') }}
{{ Html::style('assets/libs/sticky/jquery.stickytable.css') }}

<style>
    .bg-ok{ 
        background-color:#61f213 !important;
    }
    .bg-nok{
        background-color:#da251c !important;

    }

    .datepicker{z-index:9999 !important}
</style>

@endsection



@section('after-scripts')


{{ Html::script('assets/libs/datepicker/datepicker.min.js') }}

{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/sweetalert2/dist/sweetalert2.all.min.js') }}
{{ Html::script('assets/libs/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}
{{ Html::script('assets/libs/sticky/jquery.stickytable.js') }}

  

<script type="text/javascript">



$('#daily-modal').on('shown.bs.modal', function () {
      
      $('[data-toggle="datepicker"]').datepicker({
       autoHide: true,
       format: 'dd-mm-yyyy',

       
   });
 $('.from_date').datepicker('setDate', 'today');
       
    });

$('#custom').on('shown.bs.modal', function () {
 
      $('[data-toggle="datepicker"]').datepicker({
       autoHide: true,
       format: 'dd-mm-yyyy',

       
   });
 $('.from_custom_date').datepicker('setDate', 'today');
  $('.to_custom__date').datepicker('setDate', 'today');
       
    });


    $(function(){


var today = new Date();
$("#datepicker").datepicker({
showDropdowns: true,
format: "MM yyyy",
viewMode: "years",
minViewMode: "months",
maxDate: today,
}).on('changeDate', function(e){
$(this).datepicker('hide');
});

$("#today").datepicker({
showDropdowns: true,
format: "dd-mm-yyyy",
viewMode: "days",
minViewMode: "days",
maxDate: today,
}).on('changeDate', function(e){
$(this).datepicker('hide');
})
$("#year_datepicker").datepicker({
showDropdowns: true,
format: "yyyy",
viewMode: "years",
minViewMode: "years",
maxDate: today,
}).on('changeDate', function(e){
$(this).datepicker('hide');
})




});



if ($('#date_1').is(":checked")){
    $('#today_date').show();
    $('#month_date').hide();
}

if ($('#date_2').is(":checked")){
    $('#today_date').hide();
    $('#month_date').show();
}






$('.date_type').on("change",function() {


var record= $('input[name="period"]:checked').val();

if(record=='today'){
    $('#today_date').show();
    $('#month_date').hide();

}else if(record=='month_to_date'){

    $('#today_date').hide();
    $('#month_date').show();
}


});




</script>
    @endsection