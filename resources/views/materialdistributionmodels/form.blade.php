                      <div class="card-body">
                          <div class="row">
                              <div class="form-group col-md-12">
                                  <label>Category </label>
                                  {!! Form::select('unit_model_id', $models, null, [
                                      'placeholder' => 'Select Model Type',
                                      'class' => 'form-control form-control-line',
                                  ]) !!}
                              </div>
                          </div>
                          <div class="row">
                              <div class="form-group col-md-12">
                                  <label>Model Name </label>
                                  {!! Form::text('name', null, [
                                      'placeholder' => 'Enter Model Name',
                                      'class' => 'form-control form-control-line',
                                      'autocomplete' => 'off','required'
                                  ]) !!}
                              </div>
                          </div>
                      </div>
