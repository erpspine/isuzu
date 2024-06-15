@php
$usersmaster=[];
if(isset($qcosemail)){
    $usersmaster=$users;

}
    
@endphp

<div class="form-group row">
    <label for="rate" class="col-sm-4 text-right control-label col-form-label">Source<span
            class="text-danger">*</span></label>
    <div class="col-sm-8">
        {!! Form::select('source', ['System Users' => 'System Users', 'App Users' => 'App Users'], null, [
            'placeholder' => 'Select Source',
            'class' => 'form-control custom-select','id'=>'source',
        ]) !!}
    </div>
</div>
<div class="form-group row">
    <label for="rate" class="col-sm-4 text-right control-label col-form-label"> Select User<span
            class="text-danger">*</span></label>
    <div class="col-sm-8">
        {!! Form::select('user_id',  $usersmaster, null, [
            'placeholder' => 'Select User',
            'class' => 'form-control custom-select select2','id'=>'user_id',
        ]) !!}
    </div>
</div>
<div class="form-group row">
    <label for="name" class="col-sm-4 text-right control-label col-form-label">Name<span
            class="text-danger">*</span> </label>
    <div class="col-sm-8">
        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name','id'=>'name', 'required' => 'required', 'autocomplete' => 'off', 'readonly']) }}
    </div>
</div>
<div class="form-group row">
    <label for="email" class="col-sm-4 text-right control-label col-form-label">Email<span
            class="text-danger">*</span>
    </label>
    <div class="col-sm-8">
        {{ Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email','id'=>'email', 'required' => 'required', 'autocomplete' => 'off', 'readonly']) }}
    </div>
</div>
