
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="inputname" class="control-label col-form-label">Vehicle Type</label>
                {!! Form::select('vehicle_type', ['CV' => 'CV', 'LCV' => 'LCV'], null, [
                    'placeholder' => 'Select  Type',
                    'class' => 'form-control ',
                ]) !!}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="title" class="control-label col-form-label">Title</label>
                {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="audit_time" class="control-label col-form-label">Audit Time</label>
                {{ Form::text('audit_time', null, ['class' => 'form-control', 'placeholder' => 'Audit Time', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="position" class="control-label col-form-label">Position</label>
                {{ Form::text('position', null, ['class' => 'form-control', 'placeholder' => 'Position', 'required' => 'required', 'autocomplete' => 'off']) }}
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-12">
            <div class="form-group">
                <label for="inputlname" class="control-label col-form-label">Description</label>
                {{ Form::textarea('description', null, ['cols' => '80', 'id' => 'testedit', 'rows' => '10', 'data-sample' => '1', 'data-sample-short']) }}
                </textarea>
            </div>
        </div>
    </div>



