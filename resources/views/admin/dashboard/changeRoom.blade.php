<form action="/admin/{{$occupant->id}}/roomChanged" method="POST" id="add-rooms-form" ><!-- id="assign-client-form" -->

  {{csrf_field()}}

	<div class="form-group"> 
	
		<label for="status">Room</label>
		<select class="custom-select" id="status" name="room_id">
			@foreach($rooms as $room)
			<option value="{{$room->id}}" selected>{{$room->room_no}} - {{$room->type}}</option>
			@endforeach
		</select>

    	<input type="hidden" name="user_id" value="{{$occupant->user_id}}">
  </div>
  
	<div class="modal-footer">
    <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button class="btn btn-success add-btn">Update</button><!-- add-btn -->
	</div>
</form>

<script type="text/javascript">
$(function(){
        $(document).off('click','.add-btn').on('click','.add-btn', function(e){
            e.preventDefault();
            var $form = $('#add-rooms-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#add-rooms-form").serialize(), 
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