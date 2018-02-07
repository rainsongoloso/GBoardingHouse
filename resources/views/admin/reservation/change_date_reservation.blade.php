<form action="/reservations/{{$reservation->id}}/storeEditReservation" method="POST" id="edit-form">

	{{csrf_field()}}

    <div class="form-group">
      <div class="text-center"> 
      <h2>{{$reservation->user->id}} - {{$reservation->user->firstname}} {{$reservation->user->lastname}}</h2>
      </div>
      <!-- <select class="custom-select" id="users" name="user_id" required>
		  <option value="{{$reservation->user_id}}"> </option>
		</select> -->

		<label for="room">Rooms</label>
		<select class="custom-select" id="room" name="room_id" required>
        @foreach($rooms as $room)
        <option value="{{$room->id}}">Room No.: {{$room->room_no}} Rate: {{$room->room_rate}} Type: {{$room->type}}</option>
        @endforeach
		</select>
    
    <label for="start_date">Start Date</label>
    <input id="start_date" type="date" name="start_date" class="form-control" value = "{{$reservation->start_date}}" min="{{$reservation->start_date}}" required>
        <span class="help-text text-danger"></span>

	<!-- 	<label for="status">Status</label>
		<select class="custom-select" id="status" name="status" required>
			<option value="Active">Active</option>
			<option value="Settled">Settled</option>
			<option value="Canceled">Canceled</option>
		</select> -->
	
		
		
		<!-- <label for="advance">Advance Payment</label>
		<input id="advance" type="checkbox" name="advance" class="form-control">
         <span class="help-text text-danger"></span> -->
	
        <!-- <label for="nop">Number of persons</label>
        <input id="nop" type="text" min="0" name="number_of_persons" class="form-control" required>
        <span class="help-text text-danger"></span> -->
		
		<!-- <label for="status">Amenities</label>
		<select class="custom-select" id="amenities" name="amenities">

          @foreach($amenities as $amenity)
          <option value="{{$amenity->id}}">{{$amenity->name}} {{$amenity->rate}} {{$amenity->description}}</option>
          @endforeach  
		</select> -->
    
	</div>
	<div class="modal-footer"> 
		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
		<button class="btn btn-success edit-btn" type="submit">Update</button>
	</div>
</form>

<script type="text/javascript">
$(function(){
        $(document).off('click','.edit-btn').on('click','.edit-btn', function(e){
            e.preventDefault();
            var $form = $('#edit-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#edit-form").serialize(), 
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
                $("#reservationDatatable").DataTable().ajax.url( '/reservations/reservationDatatable' ).load();
                $('.modal').modal('hide');
                // $("#usersInactiveDatatable").DataTable().ajax.url( '/manage-users/inactiveUserDatatable' ).load();
                
              },
              error: function(xhr,status,error){
                var response_object = JSON.parse(xhr.responseText); 
                associate_errors(response_object.errors, $form);
              }
            });
        });  
     });

$(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    $('#start_date').attr('min', maxDate);
});

</script>