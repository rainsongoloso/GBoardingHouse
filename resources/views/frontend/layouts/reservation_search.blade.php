@extends('frontend.app')

@section('content')
<div class="container">
    <div class="row">@include('errors')</div>
<div class="mt-5">
    <form data-parsley-validate="" action="/online/reserv" method="GET">
    {{ csrf_field() }}
    <div class="form-group">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="checkin">Check In<span class="text-danger">*</span></label>
                    <input type="text" id="checkin" class="form-control" name="start_date" value="{{$changeFormat}}">
                </div>
                <div class="col-md-6">
                    <label for="checkout">Check Out<span class="text-danger">*</span></label>
                    <input type="text" id="checkout" class="form-control" name="check_out" value="{{$changeFormat2}}">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-warning btn-md">Search</button>
        </div>

</form>
</div>

<div class="h1 text-center">Available rooms</div>
    <div class="row">
        @foreach($searchRoom as $room)

        <div class="col-md-4 mt-5">
            <div class="card">
                <img class="card-img-top" src="/images/room_image/{{$room->room_image}}" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title">Room: {{$room->room_no}}</h4>
                    <p class="card-text">{{$room->description}}</p>
                </div>
                <ul class="list-group list-group-flush">
                    @if($room->type == 'Bed Spacer')
                    <li class="list-group-item">Type: <span class="text-primary"><strong>{{$room->type}}</strong></span></li>
                    @else
                    <li class="list-group-item">Type: <span class="text-info"><strong>{{$room->type}}</strong></span></li>
                    @endif @if($room->type == 'Bed Spacer')
                    <li class="list-group-item">Current Capacity: {{$room->current_capacity}}</li>
                    <li class="list-group-item">Max Capacity: {{$room->max_capacity}}</li>
                    @else
                    <li class="list-group-item">Max Capacity: {{$room->max_capacity}}</li>
                    @endif @if($room->type == 'Bed Spacer')
                    <li class="list-group-item">Price: {{number_format($room->rate/$room->max_capacity,2)}}</li>
                    @else
                    <li class="list-group-item">Price: {{number_format($room->rate,2)}}</li>
                    @endif
                </ul>
                <div class="card-body">
                    <!-- <form method="post" action=""></form> -->
                    <a href="/online/{{$room->id}}/{{$changeFormat}}/{{$changeFormat2}}" class="btn btn-dark btn-md">Reserve</a>
                    <!-- <a href="/online/{{$room->id}}/reserved" class="btn btn-dark btn-md">Reserve</a> -->
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<br>
@endsection

@section('scripts')
<script type="text/javascript">
// $('#datepicker').datepicker({
//     format: "DD, MM dd yyyy",
//     startDate: "+3d",
//     startView: 1,
//     orientation: "bottom auto",
//     clearBtn: true,
// });

$("#checkin").datepicker({ minViewMode: 0, startDate: "+3d", format: "DD, MM dd yyyy", startView: 1, clearBtn: true, }).on('changeDate', 
  function(ev){
   startDate: ev.date.setMonth(ev.date.getMonth() + 1), 
$("#checkout").datepicker('setStartDate',ev.date);});
$("#checkout").datepicker({format:"DD, MM dd yyyy"});
</script>
@endsection