    <div class="form-group row">
        <label for="factor" class="col-sm-4 text-right control-label col-form-label">Vehicle Type</label>
        <div class="col-sm-8">
            {{ Form::select('vehicle_type', ['CV' => 'CV', 'LCV' => 'LCV'], null, ['class' => 'form-control', 'placeholder' => 'Select Vehicle Type', 'autocomplete' => 'off', 'required' => 'required']) }}
        </div>
    </div>
    <div class="form-group row">
        <label for="factor" class="col-sm-4 text-right control-label col-form-label">Weight</label>
        <div class="col-sm-8">
            {{ Form::text('factor', null, ['class' => 'form-control', 'placeholder' => 'Name', 'autocomplete' => 'off', 'required' => 'required']) }}
        </div>
    </div>
    <div class="form-group row">
        <label for="description" class="col-sm-4 text-right control-label col-form-label">Description</label>
        <div class="col-sm-8">
            {{ Form::text('description', null, ['class' => 'form-control', 'placeholder' => 'Description', 'autocomplete' => 'off']) }}
        </div>
    </div>
