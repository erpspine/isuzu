@extends('layouts.app')
@section('title','Mark Attendance')
@section('content')
<div class="row page-titles">
    <div class="col-md-5 col-12 align-self-center">
        <h3 class="text-themecolor mb-0">Attendance</h3>
        <ol class="breadcrumb mb-0 p-0 bg-transparent">
            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
            <li class="breadcrumb-item active">Attendance</li>
        </ol>
    </div>
</div>
<div class="col-sm-8 col-md-12">
<div class="card">
    <div class="card-header">
        <h4 class="card-title">Mark Staff Attendance</h4>
    </div>

    <div class="card-body">

        {{ Form::open(['route' => 'markattencance', 'method' => 'GET'])}}
        
        <div class="p-3 bg-white mb-3 rounded-pill align-items-center">

            <ul class="nav nav-pills">
                    @if (Auth()->User()->superAdmin == 1)
                  
                        <li class="nav-item" style="width: 30%;">
                            <div class='input-group ml-5'>
                                {{Form::select('shop', $shops, null, array('class'=>'form-control select2', 'placeholder'=>'Please select ...', 'required'=>'required',
                                'style'=>'width: 80%;'))}}
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class='input-group ml-5'>
                                <input type='text' name="mdate" class="form-control singledate" />

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="ti-calendar"></span>
                                    </span>
                                </div>
                            </div>
                         </li>
                         <li class="nav-item ml-auto">
                             <button class="nav-link btn-danger rounded-pill d-flex align-items-center px-3 mr-5" style="background-color:#da251c; ">
                           <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Proceed to Record</span></button>
                         </li>
                    @else
                @if (Auth()->User()->section == "ALL")
               
                        <li class="nav-item" style="width: 30%;">
                            <div class='input-group ml-5'>
                                {{Form::select('shop', $shops, null, array('class'=>'form-control select2', 'placeholder'=>'Please select ...', 'required'=>'required',
                                'style'=>'width: 80%;'))}}
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class='input-group ml-5'>
                                <input type='text' name="mdate" class="form-control singledate" />

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="ti-calendar"></span>
                                    </span>
                                </div>
                            </div>
                         </li>
                         <li class="nav-item ml-auto">
                             <button class="nav-link btn-danger rounded-pill d-flex align-items-center px-3 mr-5" style="background-color:#da251c; ">
                           <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Proceed to Record</span></button>
                         </li>
                @elseif(Auth()->User()->section > 0)
                        <li class="nav-item" style="width: 30%;">
                            <div class="form-group ml-5" style="font-size: 18px;">
                                <input type="hidden" name="shop" value="{{Auth()->User()->section}}">
                                {!! Form::label('name', 'Section:*') !!}
                                {!! Form::label('name', \App\Models\shop\Shop::where('id','=',Auth()->User()->section)->value('report_name'), ['class' => 'font-weight-bold']); !!}
                            </div>
                        </li>
                        <li class="nav-item">
                            <div class='input-group ml-5'>
                                <input type='text' name="mdate" class="form-control singledate" />

                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <span class="ti-calendar"></span>
                                    </span>
                                </div>
                            </div>
                         </li>
                         <li class="nav-item ml-auto">
                             <button class="nav-link btn-danger rounded-pill d-flex align-items-center px-3 mr-5" style="background-color:#da251c; ">
                           <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Proceed to Record</span></button>
                         </li>
                @else
                        <div class="form-group ml-5" style="font-size: 18px;">
                            <label class="text-danger">Sorry, No section allocated for the user!</label>
                            <h5 class="text-danger">Contact Admin for allocation.</h5>
                        </div>
                        @endif
                    @endif


           </ul>
        @if(shop() == "noshop")
        <div class="ml-5 mr-5">
            <h3>Today's Attendance</h3> 
            
            <div id="today"></div>

        </div>

        <div class="mt-5 ml-5 mr-5">
            <h3>Yesterdays's Attendance</h3>
            <div id="yesterday"></div>
            

        </div>
    
          
        @else
            @if(count($unlogged) > 0)
                <div class="ml-5 mr-5 mb-3">
                <h3>Unlogged Attendance & OT</h3>
                  @foreach ($unlogged as $log )
                    <span class="mb-2 badge badge-danger">{{dateFormat($log)}}</span>
                    @endforeach
            </div>
            @endif

            @if(count($saveds) > 0)
            <div class="ml-5 mr-5 mb-3">
            <h3>Pending Submission</h3>
                    @for ($i = 0; $i < count($saveds); $i++)
                    <span class="mb-2 badge badge-primary">{{$saveds[$i]}}</span>
                    @endfor
            </div>
           @endif
            @if(count($reviews) > 0)
            <div class="ml-5 mr-5">
            <h3>Pending Review</h3>
                @for ($i = 0; $i < count($reviews); $i++)
                <span class="mb-2 badge badge-success">{{$reviews[$i]}}</span>
                @endfor
            </div>
           @endif

        @endif

        </div>

           {{ Form::close() }}
    </div>
</div>
</div>

     <!-- Individual column searching (select inputs) -->



     @endsection
     @section('after-styles')
     {{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
      {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}

 @endsection

 @section('after-scripts')
  {{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
 {{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
 {{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
 {{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
         {!! Toastr::message() !!}


 <script type="text/javascript">
     $(".select2").select2();
     $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
	});
    //today
	$.ajax({
        type: "GET",
        url: "{{ url('today_attendance_view')}}",
        dataType: "html",
        success: function (data) {
          
			$("#today").html(data);
           
            
			
        },
    });
//yesterday
    $.ajax({
        type: "GET",
        url: "{{ url('yesterday_attendance_view')}}",
        dataType: "html",
        success: function (data) {
          
			$("#yesterday").html(data);
           
            
			
        },
    });


    
 </script>
 @endsection


