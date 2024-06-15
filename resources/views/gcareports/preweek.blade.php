@section('title','Gca Pre-Week Report')
@extends('layouts.app')

@section('content')

    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="row page-titles">
        <div class="col-md-5 col-12 align-self-center">
            <h3 class="text-themecolor mb-0">PRE WEEK REPORT</h3>
            <ol class="breadcrumb mb-0 p-0 bg-transparent">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                <li class="breadcrumb-item active">PRE WEEK REPORT</li>
            </ol>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Container fluid  -->
    <!-- ============================================================== -->
    <div class="container-fluid">


    <!-- Individual column searching (select inputs) -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-cyan mb-2">
                    {{ Form::open(['route' => 'gcapreweek', 'class' => '', 'role' => 'form', 'method' => 'get', 'id' => 'create-report', 'files' => false]) }}


                                <div class="row">
                                    <div class="col-md-4">
                                        <div class='input-group'>
                                            {!! Form::select('vehicle_type', ['cv'=>'cv','lcv'=>'lcv'], null, [
                                                'placeholder' => 'Select Vehicle Type',
                                                'class' => 'form-control custom-select select2',
                                            ]) !!}


                                         
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class='input-group'>
                                            <input type='text' name="date" class="form-control singledate" />

                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <span class="ti-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                            <button class="nav-link btn-danger rounded-pill d-flex align-items-center px-3 mr-5" style="background-color:#da251c; ">
                                          <i class="icon-note m-1"></i><span class="d-none d-md-block font-14">Load Report</span></button>
                                    </div>
                                </div>
                       
                           {{ Form::close() }}
                    </div>



              
                  
                  
                  
                
                </div>
            </div>
        </div>
        @if (isset($date))
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        GCA Result Of the 4 Previous Work Weeks Period From <span class="text-success">{{ dateFormat($datefrom) }}</span> to <span class="text-success">{{ dateFormat($date) }}</span>
                      </div>
                   
                    <div class="card-body">
                        
                       
                        <div class="row">
                            <table class="table table-orange">
                                <thead>
                                    <tr class="table-light">
                                        <th >#</th>
                                        @foreach ($vehicletypes as $type )
                                        <th >{{ $type->vehicle_name }}</th>
                                        @endforeach
                                      <th></th>
                                      
                                       
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                    @foreach ($categories as $cat )
                                    <tr>
                                        <th>{{ $cat->name }}</th>
                                        @php
                                        $total=0;
                                       @endphp
                                        @foreach ($vehicletypes as $type )
                                        <td >{{ $master[$type->id][$cat->id] }}</td>
                                        @php
                                            $total+=$mastertotal[$type->id][$cat->id];
                                        @endphp
                                        @endforeach
                                        <td >{{ round($total/$gcatotal) }}</td>
                                    </tr>
                                    @endforeach
                                 
                                </tbody>
                                <tfoot>
                                    <tr class="table-light">
                                        <th>Total WDPV</th>
                                        @foreach ($vehicletypes as $type )
                                        <th >{{ $answertypetotal[$type->id]  }}</th>
                                        @endforeach
                                        <th>{{   round($typegrandtotal/$gcatotal) }}</th>

                                    </tr>
                                    <tr>
                                        <th># of Audited Cars</th>
                                        @foreach ($vehicletypes as $type )
                                        <th >{{ $answertypetotal[$type->id]  }}</th>
                                        @endforeach
                                        <th>{{   round($typegrandtotal/$gcatotal) }}</th>

                                    </tr>
                                    <tr>
                                        <th>DPV</th>
                                        @foreach ($vehicletypes as $type )
                                        <th >{{ $answertypetotal[$type->id]  }}</th>
                                        @endforeach
                                        <th>{{   round($typegrandtotal/$gcatotal) }}</th>

                                    </tr>
                                    <tr>
                                        <th># of Production</th>
                                        @foreach ($vehicletypes as $type )
                                        <th >{{ $typetotal[$type->id]  }}</th>
                                        @endforeach
                                        <th>{{   $gcatotal }}</th>

                                    </tr>
                                   

                                    

                                </tfoot>
                            </table>
                           
                     
                        </div>
    
                    </div>
                </div>
            </div>
        </div>
        @endif

    </div>

@endsection
@section('after-styles')
{{ Html::style('assets/libs/select2/dist/css/select2.min.css') }}
 {{ Html::style('assets/extra-libs/toastr/dist/build/toastr.min.css') }}
 {{ Html::style('assets/libs/select2/dist/css/select2-bootstrap.css') }}

@endsection

@section('after-scripts')
{{ Html::script('assets/extra-libs/toastr/dist/build/toastr.min.js') }}
{{ Html::script('assets/extra-libs/toastr/toastr-init.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.full.min.js') }}
{{ Html::script('assets/libs/select2/dist/js/select2.min.js') }}
{{ Html::script('dist/js/pages/contact/contact.js') }}
    {!! Toastr::message() !!}


<script type="text/javascript">
     $(".select2").select2({
                   theme: "bootstrap",
                   width: '100%',
                   dropdownAutoWidth: true,
                   allowClear: true,
               });

//$(".select2").select2();
</script>
@endsection

