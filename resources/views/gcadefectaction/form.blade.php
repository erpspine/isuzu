                        <div class="form-group row">
                            <label for="ename" class="col-sm-4 text-right control-label col-form-label">Shop<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('shop_id', $shops, null, [
                                    'placeholder' => 'Select Shop',
                                    'class' => 'form-control custom-select select2',
                                    'style' => 'height: 36px;width: 100%;','required'=>'required',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ename" class="col-sm-4 text-right control-label col-form-label">Category<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('gca_audit_report_category_id', $category, null, [
                                    'placeholder' => 'Select Category',
                                    'class' => 'form-control custom-select select2',
                                    'style' => 'height: 36px;width: 100%;','required'=>'required',
                                ]) !!}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="gca_manual_reference" class="col-sm-4 text-right control-label col-form-label">UPC/FNA/SHEET NO </label>
                            <div class="col-sm-8">
                                {{ Form::text('gca_manual_reference', null, ['class' => 'form-control', 'placeholder' => 'Sheet No', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="defect_count" class="col-sm-4 text-right control-label col-form-label">Count<span
                                class="text-danger">*</span>
                                     </label>
                            <div class="col-sm-8">
                                {{ Form::text('defect_count', null, ['class' => 'form-control', 'placeholder' => 'Defect Count','required'=>'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="weight" class="col-sm-4 text-right control-label col-form-label">Weight<span
                                class="text-danger">*</span>
                                     </label>
                            <div class="col-sm-8">
                                {{ Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'Weight', 'required'=>'required','autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="transducer_code" class="col-sm-4 text-right control-label col-form-label">Team Leader
                                     </label>
                            <div class="col-sm-8">
                                {{ Form::text('responsible_team_leader', null, ['class' => 'form-control', 'placeholder' => 'Responsible Team Leader', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="transducer_code" class="col-sm-4 text-right control-label col-form-label">Description<span
                                class="text-danger">*</span>
                                     </label>
                            <div class="col-sm-8">
                                {{ Form::text('defect', null, ['class' => 'form-control', 'placeholder' => 'Description','required'=>'required', 'autocomplete' => 'off']) }}
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ename" class="col-sm-4 text-right control-label col-form-label">Containment Status<span
                                    class="text-danger">*</span></label>
                            <div class="col-sm-8">
                                {!! Form::select('is_corrected', ['No'=>'Open','Yes'=>'Closed'], null, [
                                    'placeholder' => 'Select ',
                                    'class' => 'form-control custom-select select2',
                                    'style' => 'height: 36px;width: 100%;',
                                ]) !!}
                            </div>
                        </div>
         
                

                        
                   
               
