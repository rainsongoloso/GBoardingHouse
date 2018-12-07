@extends('client.app')

@section('content')
<div class="container">
    <div class="text-center mt-5">
        <h2>Edit Reservation</h2></div>
    <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">

            <form action="/client/{{$reservation->id}}/reseveEdit" method="POST" class="mt-4">

                {{ csrf_field() }}

                <div class="form-group">
                    <div class="input-daterange" id="datepicker" data-provide="datepicker">
                        <div class="form-row">
                            <div class="col-md-6">
                                <label for="checkin">Check In<span class="text-danger">*</span></label>
                                <input id="checkin" type="text" class="input-sm form-control" name="start_date" placeholder="Check-in" required="" value="{{$reservation->check_in}}">
                            </div>
                            <div class="col-md-6">
                                <label for="checkout">Check Out<span class="text-danger">*</span></label>
                                <input id="checkout" type="text" class="input-sm form-control" name="check_out" placeholder="Check-out" required="" value="{{$reservation->check_out}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="rooms">Select rooms:</label>
                    <select class="form-control" id="rooms" name="room_id">
                        @foreach($rooms as $room) 
	                        @if($room->id == $reservation->room_id)
		                        <option value="{{$room->id}}" selected="">{{$room->room_no}} {{$room->type}} Price: {{number_format($room->rate,2)}}</option>
		                    @else
                                @if($room->status == 'Occupied')
		                        <option value="{{$room->id}}">
                                    {{$room->room_no}} {{$room->type}}
                                    {{$room->status}} Capacity: {{$room->current_capacity .'/'. $room->max_capacity}} Price: {{number_format($room->rate,2)}}
                                </option>
                                @else
                                 <option value="{{$room->id}}">
                                    {{$room->room_no}} {{$room->type}} Price: {{number_format($room->rate,2)}}
                                </option>
                                @endif
	                        @endif 
	                    @endforeach
                    </select>
                </div>
                
				<a href="/client" class="btn btn-secondary">Cancel</a>
                <button class="btn btn-success">Update</button>
            </form>

        </div>
        <div class="col-md-3"></div>
    </div>
</div>
<br>
@endsection

@section('scripts')
<script type="text/javascript">

$('#datepicker').datepicker({
    format: "DD, MM dd yyyy",
    startDate: "+3d",
    startView: 1,
    orientation: "bottom auto",
    clearBtn: true,
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
    $('#startdate').attr('min', maxDate);
});
</script>
@endsection