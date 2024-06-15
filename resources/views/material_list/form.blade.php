<div class="form-group row">
    <label for="pna_case" class="col-sm-4 text-right control-label col-form-label">Model </label>
    <div class="col-sm-8">
        {!! Form::select('material_distribution_model_id', $models, null, [
            'placeholder' => 'Select Model',
            'class' => 'form-control custom-select select2',
            'style' => 'height: 36px;width: 100%;',
            'required',
        ]) !!}
    </div>
</div>
<div class="form-group row">
    <label for="pna_case" class="col-sm-4 text-right control-label col-form-label">Case </label>
    <div class="col-sm-8">
        {{ Form::text('pna_case', null, ['class' => 'form-control', 'placeholder' => 'Case', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="Box" class="col-sm-4 text-right control-label col-form-label">Box
    </label>
    <div class="col-sm-8">
        {{ Form::text('Box', null, ['class' => 'form-control', 'placeholder' => 'Box', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="partnumber" class="col-sm-4 text-right control-label col-form-label">Partnumber
        <span class="text-danger">*</span> </label>
    <div class="col-sm-8">
        {{ Form::text('partnumber', null, ['class' => 'form-control', 'placeholder' => 'Partnumber', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="Description" class="col-sm-4 text-right control-label col-form-label">Description
        <span class="text-danger">*</span> </label>
    <div class="col-sm-8">
        {{ Form::text('Description', null, ['class' => 'form-control', 'placeholder' => 'Description', 'required' => 'required', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="upc" class="col-sm-4 text-right control-label col-form-label">Upc
    </label>
    <div class="col-sm-8">
        {{ Form::text('upc', null, ['class' => 'form-control', 'placeholder' => 'Upc', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="FNA" class="col-sm-4 text-right control-label col-form-label">FNA
    </label>
    <div class="col-sm-8">
        {{ Form::text('FNA', null, ['class' => 'form-control', 'placeholder' => 'FNA', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="qty_lot" class="col-sm-4 text-right control-label col-form-label">Qty/lot
    </label>
    <div class="col-sm-8">
        {{ Form::text('qty_lot', null, ['class' => 'form-control', 'placeholder' => 'Qty/lot', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC1" class="col-sm-4 text-right control-label col-form-label">LOC1
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC1', null, ['class' => 'form-control', 'placeholder' => 'LOC1', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY1" class="col-sm-4 text-right control-label col-form-label">QTY1
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY1', null, ['class' => 'form-control', 'placeholder' => 'QTY1', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC2" class="col-sm-4 text-right control-label col-form-label">LOC2
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC2', null, ['class' => 'form-control', 'placeholder' => 'LOC2', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY2" class="col-sm-4 text-right control-label col-form-label">QTY2
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY2', null, ['class' => 'form-control', 'placeholder' => 'QTY2', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC3" class="col-sm-4 text-right control-label col-form-label">LOC3
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC3', null, ['class' => 'form-control', 'placeholder' => 'LOC3', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY3" class="col-sm-4 text-right control-label col-form-label">QTY3
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY3', null, ['class' => 'form-control', 'placeholder' => 'QTY3', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC4" class="col-sm-4 text-right control-label col-form-label">LOC4
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC4', null, ['class' => 'form-control', 'placeholder' => 'LOC4', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY4" class="col-sm-4 text-right control-label col-form-label">QTY4
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY4', null, ['class' => 'form-control', 'placeholder' => 'QTY4', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC5" class="col-sm-4 text-right control-label col-form-label">LOC5
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC5', null, ['class' => 'form-control', 'placeholder' => 'LOC5', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY5" class="col-sm-4 text-right control-label col-form-label">QTY5
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY5', null, ['class' => 'form-control', 'placeholder' => 'QTY5', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC6" class="col-sm-4 text-right control-label col-form-label">LOC6
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC6', null, ['class' => 'form-control', 'placeholder' => 'LOC6', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY6" class="col-sm-4 text-right control-label col-form-label">QTY6
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY6', null, ['class' => 'form-control', 'placeholder' => 'QTY6', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC7" class="col-sm-4 text-right control-label col-form-label">LOC7
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC7', null, ['class' => 'form-control', 'placeholder' => 'LOC7', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY7" class="col-sm-4 text-right control-label col-form-label">QTY7
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY7', null, ['class' => 'form-control', 'placeholder' => 'QTY7', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC8" class="col-sm-4 text-right control-label col-form-label">LOC8
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC8', null, ['class' => 'form-control', 'placeholder' => 'LOC8', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY8" class="col-sm-4 text-right control-label col-form-label">QTY8
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY8', null, ['class' => 'form-control', 'placeholder' => 'QTY8', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC9" class="col-sm-4 text-right control-label col-form-label">LOC9
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC9', null, ['class' => 'form-control', 'placeholder' => 'LOC9', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY9" class="col-sm-4 text-right control-label col-form-label">QTY9
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY9', null, ['class' => 'form-control', 'placeholder' => 'QTY9', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC10" class="col-sm-4 text-right control-label col-form-label">LOC10
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC10', null, ['class' => 'form-control', 'placeholder' => 'LOC10', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY10" class="col-sm-4 text-right control-label col-form-label">QTY10
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY10', null, ['class' => 'form-control', 'placeholder' => 'QTY10', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC11" class="col-sm-4 text-right control-label col-form-label">LOC11
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC11', null, ['class' => 'form-control', 'placeholder' => 'LOC11', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY11" class="col-sm-4 text-right control-label col-form-label">QTY11
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY11', null, ['class' => 'form-control', 'placeholder' => 'QTY11', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="LOC12" class="col-sm-4 text-right control-label col-form-label">LOC12
    </label>
    <div class="col-sm-8">
        {{ Form::text('LOC12', null, ['class' => 'form-control', 'placeholder' => 'LOC12', 'autocomplete' => 'off']) }}
    </div>
</div>
<div class="form-group row">
    <label for="QTY12" class="col-sm-4 text-right control-label col-form-label">QTY12
    </label>
    <div class="col-sm-8">
        {{ Form::text('QTY12', null, ['class' => 'form-control', 'placeholder' => 'QTY12', 'autocomplete' => 'off']) }}
    </div>
</div>
