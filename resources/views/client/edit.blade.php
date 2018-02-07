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

                    <label for="startdate">Start Date</label>
                    <input type="date" class="form-control" id="startdate" name="start_date" value="{{$reservation->start_date}}" min="{{$format}}">
                </div>

                <div class="form-group">
                    <label for="rooms">Select list:</label>
                    <select class="form-control" id="rooms" name="room_id">
                        @foreach($rooms as $room) 
	                        @if($room->id === $reservation->room_id)
		                        <option value="{{$room->id}}" selected>{{$room->room_no}} {{$room->type}} Price: {{$room->roomRate()}}</option>
		                    @else
		                        <option value="{{$room->id}}">{{$room->room_no}} {{$room->type}} Price: {{$room->roomRate()}}</option>
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
@endsection

@section('scripts')
<script type="text/javascript">
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