                        <div class="form-group row">
                            <label for="ename" class="col-sm-4 text-right control-label col-form-label">SHOP USED<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('shop_id', $shops, null, [
                                    'placeholder' => 'Select Shop',
                                    'class' => 'form-control custom-select select2',
                                    'style' => 'height: 36px;width: 100%;',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="tool_id" class="col-sm-4 text-right control-label col-form-label">TOOL ID<span
                                    class="text-danger">*</span> </label>
                            <div class="col-sm-8">
                                {{ Form::text('tool_id', null, ['class' => 'form-control', 'placeholder' => 'TOOL ID', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sku" class="col-sm-4 text-right control-label col-form-label">SKU NUMBER
                                     </label>
                            <div class="col-sm-8">
                                {{ Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'SKU NUMBER', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="serial_number" class="col-sm-4 text-right control-label col-form-label">SERIAL NUMBER
                                     </label>
                            <div class="col-sm-8">
                                {{ Form::text('serial_number', null, ['class' => 'form-control', 'placeholder' => 'SERIAL NUMBER', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pname" class="col-sm-4 text-right control-label col-form-label">TOOL
                                MODEL<span class="text-danger">*</span> </label>
                            <div class="col-sm-8">
                                {{ Form::text('tool_model', null, ['class' => 'form-control', 'placeholder' => 'TOOL MODEL', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rate" class="col-sm-4 text-right control-label col-form-label">TOOL
                                TYPE<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('tool_type', ['CLICK WRENCH' => 'CLICK WRENCH', 'PULSE TOOL' => 'PULSE TOOL'], null, [
                                    'placeholder' => 'Select Type',
                                    'class' => 'form-control custom-select',
                                ]) !!}


                               
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rate" class="col-sm-4 text-right control-label col-form-label">LAST
                                CALIBRATION DATE</label>
                            <div class="col-sm-8">
                                {{ Form::text('last_calibration_date', null, ['class' => 'form-control', 'data-toggle' => 'datepicker', 'placeholder' => 'Date', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="days_to_next_calibrarion" class="col-sm-4 text-right control-label col-form-label">DAYS TO NEXT CALIBRATION
                                <span class="text-danger">*</span> </label>
                            <div class="col-sm-8">
                                {{ Form::number('days_to_next_calibrarion', null, ['class' => 'form-control', 'placeholder' => 'ENTER DAYS', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="rate" class="col-sm-4 text-right control-label col-form-label">NEXT
                                CALIBRATION DATE</label>
                            <div class="col-sm-8">
                                {{ Form::text('next_calibration_date', null, ['class' => 'form-control', 'data-toggle' => 'datepicker', 'placeholder' => 'Date', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="rate" class="col-sm-4 text-right control-label col-form-label">TOOL STATUS
                                (OK/NOK/DAMAGED)<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('status', ['OK' => 'OK', 'NOK' => 'NOK', 'DAMAGED' => 'DAMAGED'], null, [
                                    'placeholder' => 'Select Status',
                                    'class' => 'form-control custom-select',
                                ]) !!}
                            </div>
                        </div>
