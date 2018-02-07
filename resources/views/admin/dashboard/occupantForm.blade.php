<form action="/admin/storeAssign" method="POST" id="assign-client-form">
  {{csrf_field()}}

	<div class="form-group">
		<label for="status">Clients</label>
		<select class="custom-select" id="status" name="user_id">
      <option selected>Select user...</option>
			@foreach($users as $user)
			<option value="{{$user->id}}">{{$user->id}} - {{$user->full_name}}</option>
			@endforeach
		</select> 
	
		<label for="status">Room</label>
		<select class="custom-select" id="status" name="room_id">
      <option selected>Select room...</option>
			@foreach($rooms as $room)
			<option value="{{$room->id}}">{{$room->room_no}} - {{$room->type}} - {{number_format($room->rate,2)}}</option>
			@endforeach
		</select> 

    <label for="status">Amenities</label>
    <select class="custom-select" id="status" name="amenities_id">
       <option selected>Select amenity...</option>
      @foreach($amenities as $amenity)
      <option value="{{$amenity->id}}">{{$amenity->amen_name}} - {{number_format($amenity->rate,2)}}</option>
      @endforeach
    </select> 
    
  </div>
	<div class="modal-footer">
		<button class="btn btn-primary add-btn">Submit</button>
		<button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
	</div>
</form>

<script type="text/javascript">
	
$(function(){
        $(document).off('click','.add-btn').on('click','.add-btn', function(e){
            e.preventDefault();
            var $form = $('#assign-client-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#assign-client-form").serialize(), 
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
                /*$("#usersInactiveDatatable").DataTable().ajax.url( '/manage-users/inactiveUserDatatable' ).load();*/
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