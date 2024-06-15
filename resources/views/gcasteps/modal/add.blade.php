 <!-- sample modal content -->
 <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content">
             <div class="modal-header">
                 <h4 class="modal-title" id="myModalLabel">Create Steps</h4>
                 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
             </div>
             {{ Form::open(['route' => 'gcasteps.store', 'class' => 'form-horizontal', 'role' => 'form', 'method' => 'post', 'id' => 'create-zones']) }}
            @include('gcasteps.modal.form')
             <div class="modal-footer">
                 <button type="button" class="btn btn-light" data-dismiss="modal">Close</button>
                 {{ Form::submit('Save changes', ['class' => 'btn btn-primary', 'id' => 'submit-data']) }}
             </div>
             {{ Form::close() }}
         </div><!-- /.modal-content -->
     </div><!-- /.modal-dialog -->
 </div><!-- /.modal -->
