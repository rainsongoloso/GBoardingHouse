<form action="/reservations/{{$reservation->id}}/storeEditReservation" method="POST" id="edit-form">

	{{csrf_field()}}

    <div class="form-group">
      <div class="text-center"> 
      <h2>{{$reservation->user->id}} - {{$reservation->user->firstname}} {{$reservation->user->lastname}}</h2>
      </div>

		<label for="room">Rooms</label>
		<select class="custom-select" id="room" name="room_id" required>
        @foreach($rooms as $room)
        <option value="{{$room->id}}">Room No.: {{$room->room_no}} Rate: {{$room->room_rate}} Type: {{$room->type}}</option>
        @endforeach
		</select>
    
    <label for="start_date">Check in</label>
    <input id="start_date" type="date" name="start_date" class="form-control" value = "{{$reservation->check_in}}" min="{{$reservation->check_in}}" required>
        <span class="help-text text-danger"></span>

    <label for="check_out">Check out</label>
    <input id="check_out" type="date" name="check_out" class="form-control" value = "{{$reservation->check_out}}" min="{{$reservation->check_out}}" required>
        <span class="help-text text-danger"></span>    

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