

<div class="form-group row">
    <label for="rate" class="col-sm-4 text-right control-label col-form-label">
        Select Stage<span
        class="text-danger">*</span> </label>
        <div class="col-sm-8">
    <div class="custom-file">
        {!! Form::select('template_type', ['Appearance'=>'Appearance','Specification'=>'Specification','Static'=>'Static','Measurement'=>'Measurement','Water-Leaks-Notes'=>'Water-Leaks-Notes','Running'=>'Running'],  null, ['placeholder' => 'Select Stage', 'class' => 'form-control custom-select ']); !!}   
    </div>
</div>
</div>
<div class="form-group row">
    <label for="rate" class="col-sm-4 text-right control-label col-form-label">
        Image One </label>
        <div class="col-sm-8">
    <div class="custom-file">
        {{ Form::file('image_one', ['class' => 'custom-file-input', 'accept'=>'image/png, image/gif, image/jpeg']) }}
        <label class="custom-file-label" for="coin">Choose file</label>
    </div>
</div>
</div>
<div class="form-group row">
    <label for="image_two" class="col-sm-4 text-right control-label col-form-label">
        Image Two</label>
        <div class="col-sm-8">
    <div class="custom-file">
        {{ Form::file('image_two', ['class' => 'custom-file-input', 'accept'=>'image/png, image/gif, image/jpeg']) }}
        <label class="custom-file-label" for="coin">Choose file</label>
    </div>
</div>
</div>
<div class="form-group row">
    <label for="image_three" class="col-sm-4 text-right control-label col-form-label">
        Image Three </label>
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





