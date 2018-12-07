<form action="/admin/{{$occupant->id}}/availed" method="POST" id="avail-users-form">

  {{csrf_field()}}
  <div class="form-group">
   {{Form::label('amenities','Amenities:',['class' => ' form-spacing-top'])}}
   {{Form::select('amenities[]', $amenities, null, ['class' => 'form-control js-example-basic-multiple', 'multiple' => 'multiple'])}}   
  </div>

 
    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary avail-btn">Avail/Change</button>
    </div>
</form>

<script type="text/javascript">
$(document).ready(function() {
    $('.js-example-basic-multiple').select2();
    $('.js-example-basic-multiple').select2().val({{json_encode($occupant->amenities->pluck('id'))}}).trigger('change');
});

$(function(){
        $(document).off('click','.avail-btn').on('click','.avail-btn', function(e){
            e.preventDefault();
            var $form = $('#avail-users-form'); 
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#avail-users-form").serialize(), 
              success: function(result){
                if(result.success){
                  swal({
                      title: result.msg,
                      icon: "success"
                    });
                }else{
                  swal({
                      title: result.msg,
                      icon: "error"
                    });
                }
                $("#occupantsDatatable").DataTable().ajax.url( '/admin/occupantsDatatable' ).load();
                $('.modal').modal('hide');
              },
              error: function(xhr,status,error){
                var response_object = JSON.parse(xhr.responseText); 
                associate_errors(response_object.errors, $form);
              }
            });
        });  
     });  
</script>