<form action="/reservations/storeReservation" method="POST" id="reservation-form">

	{{csrf_field()}}

    <div class="form-group">
        <label for="users">User Client</label>
        <select class="custom-select form-control" id="users" name="user_id" required>
        @foreach($users as $user)
			   <option value="{{$user->id}}">{{$user->id}} - {{$user->firstname}} {{$user->lastname}}</option>
		    @endforeach
		</select>

		<label for="room">Rooms</label>
		<select class="custom-select form-control" id="room" name="room_id" required>
		@foreach($rooms as $room)
			<option value="{{$room->id}}">Room No.: {{$room->room_no}} Rate: {{$room->rate}} Status: {{$room->status}} Type: {{$room->type}}</option>
		@endforeach
		</select>
	     
      <label for="checkin">Check In</label>
      <input type="text" id="checkin" class="form-control" name="start_date">

      <label for="checkout">Check Out</label>
      <input type="text" id="checkout" class="form-control" name="check_out">

		<!-- <label for="start_date">Check in</label>
		<input id="start_date" type="date" name="start_date" class="form-control" required>
        <span class="help-text text-danger"></span>

    <label for="check_out">Check out</label>
    <input id="check_out" type="date" name="check_out" class="form-control" required>
        <span class="help-text text-danger"></span>     -->
    
	</div>

  <div class="modal-footer"> 
    <button class="btn btn-secondary" type="submit" data-dismiss="modal">Cancel</button>
    <button class="btn btn-dark add-btn" type="submit">Reserve</button>
  </div>
</form>


	

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

$("#checkin").datepicker({ minViewMode: 0, startDate: "+3d", format: "DD, MM dd yyyy", startView: 1, clearBtn: true, }).on('changeDate', 
  function(ev){
   startDate: ev.date.setMonth(ev.date.getMonth() + 1), 
$("#checkout").datepicker('setStartDate',ev.date);});
$("#checkout").datepicker({format:"DD, MM dd yyyy"});  

// $(function(){
//     var dtToday = new Date();

//     var month = dtToday.getMonth() + 1;
//     var day = dtToday.getDate();
//     var year = dtToday.getFullYear();

//     if(month < 10)
//         month = '0' + month.toString();
//     if(day < 10)
//         day = '0' + day.toString();

//     var maxDate = year + '-' + month + '-' + day;    
//     $('#start_date').attr('min', maxDate);
// }); 

// $(function(){
//     var dtToday = new Date();

//     var month = dtToday.getMonth() + 1;
//     var day = dtToday.getDate();
//     var year = dtToday.getFullYear();

//     if(month < 10)
//         month = '0' + month.toString();
//     if(day < 10)
//         day = '0' + day.toString();

//     var maxDate = year + '-' + month + '-' + day;    
//     $('#check_out').attr('min', maxDate);
// }); 
</script>