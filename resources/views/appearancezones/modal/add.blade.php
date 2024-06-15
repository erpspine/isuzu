 <!-- sample modal content -->
 <div id="myModal" class="modal fade" tabindex="-1" role="dialog"
 aria-labelledby="myModalLabel" aria-hidden="true">
 <div class="modal-dialog">
     <div class="modal-content">
         <div class="modal-header">
             <h4 class="modal-title" id="myModalLabel">Create Zones</h4>
             <button type="button" class="close" data-dismiss="modal"
                 aria-hidden="true">×</button>
         </div>
         {{ Form::open(['route' => 'appearance-zones.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-zones'])}}
         <div class="modal-body">
            <!--
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="inputname" class="control-label col-form-label">Zone Type</label>
                        {!! Form::select('zone_type', ['Interio-Exterior Trim'=>'Interio-Exterior Trim','ABCD'=>'ABCD'],  null, ['placeholder' => 'Select Zone Type', 'class' => 'form-control ']); !!}   


                    </div>
                </div>
             
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="inputname" class="control-label col-form-label">Zone Type</label>
                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'name','required'=>'required','autocomplete'=>'off']) }}    


                    </div>
                </div>
             
            </div>-->

            <div class="row">
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="inputname" class="control-label col-form-label">Template Position</label>
                        {!! Form::select('template_type', ['Water-Leaks-Notes'=>'Water-Leaks-Notes','Static-Notes'=>'Static-Notes'],  null, ['placeholder' => 'Select Zone Type', 'class' => 'form-control ']); !!}   


                    </div>
                </div>
             
            </div>
           
            
            <div class="row">
             
                <div class="col-sm-12 col-md-12">
                    <div class="form-group">
                        <label for="inputlname" class="control-label col-form-label">Description</label>
                        {{ Form::textarea('note', null, ['cols'=>'80','id' => 'testedit', 'rows' => '10','data-sample'=>'1','data-sample-short']) }}    


                 
                    </textarea>
                    </div>
                </div>
            </div>


          
            
         </div>
         <div class="modal-footer">
             <button type="button" class="btn btn-light"
                 data-dismiss="modal">Close</button>
                 {{ Form::submit('Save changes', ['class' => 'btn btn-primary','id'=>'submit-data']) }}


         </div>
         {{ Form::close() }}
     </div><!-- /.modal-content -->
 </div><!-- /.modal-dialog -->
</div><!-- /.modal -->