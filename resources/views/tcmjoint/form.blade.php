                        <div class="form-group row">
                            <label for="tcm_id" class="col-sm-4 text-right control-label col-form-label">MONITORING TOOL<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('tcm_id', $tecms,null, [
                                    'placeholder' => 'Select Tool ID',
                                    'class' => 'form-control custom-select select2',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="production_tool" class="col-sm-4 text-right control-label col-form-label">PRODUCTION TOOL<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('production_tool', $tecms,null, [
                                    'placeholder' => 'Select Tool ID',
                                    'class' => 'form-control custom-select select2',
                                ]) !!}
                            </div>
                        </div>
                        @php
                            $model=null;
                            if(isset($tcmjoint)){
                                $model=$models_select;

                            }
                         
                        @endphp
                        <div class="form-group row">
                            <label for="model_id" class="col-sm-4 text-right control-label col-form-label">Vehicle Model<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('model_id[]', $models, $model, [
                                    'class' => 'form-control custom-select select2',
                                    'multiple' => 'multiple',
                                ]) !!}
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="team_leader_id" class="col-sm-4 text-right control-label col-form-label">Team Leader<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('team_leader_id', $team_leaders, null, [
                                    'class' => 'form-control custom-select select2','placeholder'=>'Select Team Leader','required'
                                   
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="shop_id" class="col-sm-4 text-right control-label col-form-label">Shop <span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('shop_id', $shops, null, [
                                    'class' => 'form-control custom-select select2','placeholder'=>'Select Shop','required'
                                   
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="date" class="col-sm-4 text-right control-label col-form-label">PART NAME/JOINT
                                ID<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('part_name_joint_id', null, ['class' => 'form-control', 'placeholder' => 'PART NAME/JOINT ID', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="station_used" class="col-sm-4 text-right control-label col-form-label">STATION
                                USED<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('station_used', null, ['class' => 'form-control', 'placeholder' => 'STATION USED', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="upc" class="col-sm-4 text-right control-label col-form-label">UPC<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('upc', null, ['class' => 'form-control', 'placeholder' => 'UPC', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sheet_no" class="col-sm-4 text-right control-label col-form-label">SHEET
                                NUMBER<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('sheet_no', null, ['class' => 'form-control', 'placeholder' => 'SHEET NUMBER', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="mean_toque" class="col-sm-4 text-right control-label col-form-label">MEAN TORQUE
                                (Nm)<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('mean_toque', null, ['class' => 'form-control', 'placeholder' => 'MEAN TORQUE (Nm)', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="upper_control_limit" class="col-sm-4 text-right control-label col-form-label">UPPER CONTROL
                                LIMIT (Nm)<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('upper_control_limit', null, ['class' => 'form-control', 'placeholder' => 'UPPER CONTROL LIMIT (Nm)', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lower_control_limit" class="col-sm-4 text-right control-label col-form-label">LOWER CONTROL
                                LIMIT (Nm)<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('lower_control_limit', null, ['class' => 'form-control', 'placeholder' => 'LOWER CONTROL LIMIT (Nm)', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="upper_control_limit" class="col-sm-4 text-right control-label col-form-label">UPPER SPECIFICATION
                                LIMIT (Nm)<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('upper_specification_limit', null, ['class' => 'form-control', 'placeholder' => 'UPPER SPECIFICATION LIMIT (Nm)', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="lower_control_limit" class="col-sm-4 text-right control-label col-form-label">LOWER SPECIFICATION
                                LIMIT (Nm)<span class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {{ Form::text('lower_specification_limit', null, ['class' => 'form-control', 'placeholder' => 'LOWER SPECIFICATION LIMIT (Nm)', 'required' => 'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="kcds_code" class="col-sm-4 text-right control-label col-form-label">KCDS CODE <span class="text-danger">*</span> </label>
                            <div class="col-sm-8">
                                {!! Form::select('kcds_code', ['PS1' => 'PS1', 'PF1' => 'PF1', 'PS2' => 'PS2','PF2' => 'PF2'], null, [
                                    'placeholder' => 'KCDS  CODE',
                                    'class' => 'form-control custom-select',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="sample_size" class="col-sm-4 text-right control-label col-form-label">SAMPLE SIZE<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('sample_size', ['100%'=>'100%','1/6'=>'1/6','1/12'=>'1/12','1/15'=>'1/15'],null, [
                                    'placeholder' => 'Select Sample Size',
                                    'class' => 'form-control custom-select ',
                                ]) !!}
                            </div>
                        </div>


                
                        <div class="form-group row">
                            <label for="lower_control_limit" class="col-sm-4 text-right control-label col-form-label">IMAGE ONE</label>
                            <div class="col-sm-8">
                                {{ Form::file('image_one', ['class' => 'form-control','accept'=>'image/png, image/gif, image/jpeg']) }}
                            </div>
                        </div>
                   
                    
