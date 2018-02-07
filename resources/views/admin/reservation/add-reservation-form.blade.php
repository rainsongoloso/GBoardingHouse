<form action="/reservations/storeReservation" method="POST" id="reservation-form">

	{{csrf_field()}}

    <div class="form-group">
        <label for="users">User Client</label>
        <select class="custom-select" id="users" name="user_id" required>
        @foreach($users as $user)
			   <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
		    @endforeach
		</select>

		<label for="room">Rooms</label>
		<select class="custom-select" id="room" name="room_id" required>
		@foreach($rooms as $room)
			<option value="{{$room->id}}">Room No.: {{$room->room_no}} Rate: {{$room->rate}} Status: {{$room->status}} Type: {{$room->type}}</option>
		@endforeach
		</select>

		<!-- <label for="status">Status</label>
		<select class="custom-select" id="status" name="status" required>
			<option value="Active">Active</option>
			<option value="Settled">Settled</option>
			<option value="Cancel">Cancel</option>
		</select> -->
	
		<label for="start_date">Start Date</label>
		<input id="start_date" type="date" name="start_date" class="form-control" required>
        <span class="help-text text-danger"></span>
		<!-- class="form-control" -->
    
    <!-- <label for="advance">Advance Payment</label>
    <input id="advance" type="checkbox" name="advance" >
    <span class="help-text text-danger"></span>  -->
    
    <!-- <input type="numeric" name="advancePay"> -->
    <!-- onclick="myFunction()" -->
   <!--  <br>
		<label for="status">Amenities</label>
		<select class="custom-select" id="room" name="amenities">
			<option value="">Please choose..</option>
			@foreach($amenities as $amenity)
				<option value="{{$amenity->id}}">{{$amenity->name}} {{$amenity->rate}} {{$amenity->description}}</option>
			@endforeach
		</select> -->
    
	</div>

  <div class="modal-footer"> 
    <button class="btn btn-secondary" type="submit" data-dismiss="modal">Cancel</button>
    <button class="btn btn-dark add-btn" type="submit">Reserve</button>
  </div>
</form>
  <!-- <label for="nop">Number of persons</label>
        <input id="nop" type="text" min="0" name="number_of_persons" class="form-control" required>
        <span class="help-text text-danger"></span> -->

	

<script type="text/javascript">
	$(function(){
        $(document).off('click','.add-btn').on('click','.add-btn', function(e){
            e.preventDefault();
            var $form = $('#reservation-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#reservation-form").serialize(), 
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
                $("#cancelReservationDatatable").DataTable().ajax.url( '/reservations/cancelReservationDatatable' ).load();
              },
              error: function(xhr,status,error){
                var response_object = JSON.parse(xhr.responseText); 
                associate_errors(response_object.errors, $form);
              }
            });
        });  
     });  
</script>