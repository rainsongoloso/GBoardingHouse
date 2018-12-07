@extends('frontend.app')

@section('content')
<div class="container">
	<h1 class="text-center mt-5">Rooms</h1>
    <div class="row">
      @foreach( $rooms as $room)
        <div class="col-md-4 mt-3">
            <div class="card">
                <img class="card-img-top" src="/images/room_image/{{$room->room_image}}" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title">Room: {{$room->room_no}}</h4>
                    <p class="card-text">{{$room->description}}</p>
                </div>
                <ul class="list-group list-group-flush">
                	@if($room->type == 'Private')
                	<li class="list-group-item">Type: <span class="text-info"><strong>{{$room->type}}</strong></span></li>
                	@else
                	<li class="list-group-item">Type: <span class="text-success"><strong>{{$room->type}}</strong></span></li>
                	@endif
                    
                    <li class="list-group-item">Capacity: {{$room->max_capacity}}</li>

                    @if($room->type == 'Private')
                    <li class="list-group-item">Price: {{number_format($room->rate,2)}}</li>
                    @else
                    <li class="list-group-item">Price: {{number_format($room->roomRate(),2)}}/head</li>
                    @endif
                </ul>
            </div>
        </div>
        @endforeach
    </div>
</div>
<br>	
@endsection