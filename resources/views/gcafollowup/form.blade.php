                     <div class="form-group row">
                         <label for="pname" class="col-sm-3 text-right control-label col-form-label">Note</label>
                         <div class="col-sm-9">
                             {{ Form::textarea('note', null, ['class' => 'form-control', 'placeholder' => 'Enter Note', 'required' => 'required', 'autocomplete' => 'off']) }}
                         </div>
                     </div>
