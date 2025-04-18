


<div class="form-group row">
    <label for="rate" class="col-sm-4 text-right control-label col-form-label">
        Image One<span
        class="text-danger">*</span> </label>
        <div class="col-sm-8">
    <div class="custom-file">
        {{ Form::file('image_one', ['class' => 'custom-file-input', 'accept'=>'image/png, image/gif, image/jpeg']) }}
        <label class="custom-file-label" for="coin">Choose file</label>
    </div>
</div>
</div>
<div class="form-group row">
    <label for="image_two" class="col-sm-4 text-right control-label col-form-label">
        Image Two<span
        class="text-danger">*</span> </label>
        <div class="col-sm-8">
    <div class="custom-file">
        {{ Form::file('image_two', ['class' => 'custom-file-input', 'accept'=>'image/png, image/gif, image/jpeg']) }}
        <label class="custom-file-label" for="coin">Choose file</label>
    </div>
</div>
</div>
<div class="form-group row">
    <label for="image_three" class="col-sm-4 text-right control-label col-form-label">
        Image Three<span
        class="text-danger">*</span> </label>
        <div class="col-sm-8">
    <div class="custom-file">
        {{ Form::file('image_three', ['class' => 'custom-file-input', 'accept'=>'image/png, image/gif, image/jpeg']) }}
        <label class="custom-file-label" for="coin">Choose file</label>
    </div>
</div>
</div>
<div class="row">
    <!-- Invoice repeater -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Details</h4>
            </div>
            <div class="card-body">
                @if (isset($cvzone))
                

                <div class="zones-repeater">
                   
                   
                    <div data-repeater-list="zones">
                        @foreach ( $cvzone->zoneitems as $item)
                        <div data-repeater-item>
                            <div class="row d-flex align-items-end">
                                <div class="col-md-2 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="itemname">Zone</label>
                                        {{ Form::hidden('id', $item->id, ['class' => 'form-control', 'required' => 'required', 'autocomplete' => 'off']) }}
                                        {{ Form::text('zone', $item->zone, ['class' => 'form-control', 'placeholder' => 'Zone', 'required' => 'required', 'autocomplete' => 'off']) }}

                  
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="itemname">Defination</label>
                                        {{ Form::textarea('defination',  $item->defination, ['class' => 'form-control', 'placeholder' => 'Defination', 'required' => 'required', 'rows' => '4']) }}

                  
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="itemcost">Applicable Portion</label>
                                        {{ Form::textarea('applicable_portion',  $item->applicable_portion, ['class' => 'form-control', 'placeholder' => 'Applicable Portion', 'required' => 'required', 'autocomplete' => 'off', 'rows' => '4']) }}

                              
                                    </div>
                                </div>

                           

                             

                              
                            </div>
                            <hr />
                            @endforeach
                        </div>
                    </div>
                        
                  
                   
                
                </div>

                    
                @else

                <div class="zones-repeater">
                    <div data-repeater-list="zones">
                        <div data-repeater-item>
                            <div class="row d-flex align-items-end">
                                <div class="col-md-2 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="itemname">Zone</label>
                                        {{ Form::text('zone', null, ['class' => 'form-control', 'placeholder' => 'Zone', 'required' => 'required', 'autocomplete' => 'off']) }}

                  
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="itemname">Defination</label>
                                        {{ Form::text('defination', null, ['class' => 'form-control', 'placeholder' => 'Defination', 'required' => 'required', 'autocomplete' => 'off']) }}

                  
                                    </div>
                                </div>

                                <div class="col-md-4 col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="itemcost">Applicable Portion</label>
                                        {{ Form::text('applicable_portion', null, ['class' => 'form-control', 'placeholder' => 'Applicable Portion', 'required' => 'required', 'autocomplete' => 'off']) }}

                              
                                    </div>
                                </div>

                           

                             

                                <div class="col-md-2 col-12 mb-50">
                                    <div class="mb-1">
                                        <button class="btn btn-outline-danger text-nowrap px-1" data-repeater-delete type="button">
                                            <i data-feather="x" class="me-25"></i>
                                            <span>Delete</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <hr />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button class="btn btn-icon btn-primary" type="button" data-repeater-create>
                                <i data-feather="plus" class="me-25"></i>
                                <span>Add New</span>
                            </button>
                        </div>
                    </div>


                    
                </div>
                    
                @endif
              
                    
               
            </div>
        </div>
    </div>
    <!-- /Invoice repeater -->
</div>

<div class="row">
    <!-- Invoice repeater -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Note</h4>
            </div>
            <div class="card-body">
                <div class="form-group row">
              
                    <div class="col-sm-12">
                        {{ Form::textarea('note', null, ['cols'=>'120','id' => 'testedit', 'rows' => '20','data-sample'=>'1','data-sample-short']) }}  
                    </div>
                </div>
              
                    
               
            </div>
        </div>
    </div>
    <!-- /Invoice repeater -->
</div>





