@extends('frontend.app')

@section('content')
<div class="container mt-5">
<h1 class="text-center">Bed Spacers Rooms</h1>

<hr>
<div class="row ">
@if(count($bsRooms)>0)
@foreach($bsRooms as $room)
    @if($room->current_capacity < $room->max_capacity)
        <div class="col-md-4 mt-5">
            <div class="card">
                <img class="card-img-top" src="/images/room_image/{{$room->room_image}}" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title">Room: {{$room->room_no}}</h4>
                    <p class="card-text">{{$room->description}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Current Capacity: {{$room->current_capacity}}</li>
                    <li class="list-group-item">Max Capacity: {{$room->max_capacity}}</li>
                    <li class="list-group-item">Price: {{number_format($room->roomRate(),2)}}</li>
                </ul>
                <div class="card-body">
                    <a href="/online/{{$room->id}}/reservationForm" class="btn btn-dark btn-md">Reserve</a>
                </div>
            </div>
        </div>
    @endif
@endforeach	
</div>
<hr>
@else
	@if(Auth::check())
		@if(Auth::user()->role == 'Admin')
		 <a href="/manage-rooms" class="btn btn-dark btn-lg btn-block">Add Room</a>
	@endif
	@else
		<h1>No Available Rooms</h1>
	@endif
@endif
</div>
@endsection
