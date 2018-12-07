@extends('frontend.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Reservation form</h1>
    <hr>
<div class="row"><div class="col-md-12">@include('errors')</div></div>
<div class="row mt-2">
@include('success')
<div class="col-md-6">
        <div class="card">
            <img class="card-img-top" src="/images/room_image/{{$room->room_image}}" alt="Card image cap">
            <div class="card-body">
                <h4 class="card-title">Room: {{$room->room_no}}</h4>
                <p class="card-text">{{$room->description}}</p>
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Current Capacity: {{$room->current_capacity}}</li>
                <li class="list-group-item">Max Capacity: {{$room->max_capacity}}</li>
                <li class="list-group-item">Price: {{number_format($room->roomRate(),2)}}/person</li>
            </ul>
        </div>
</div>

<div class="col-md-6">
<form id="submit-form" data-parsley-validate="" action="/online/{{$room->id}}/reserve" method="POST">
		
        {{ csrf_field() }}

        <div class="form-group">
            <div class="input-daterange" id="datepicker" data-provide="datepicker">
                <div class="form-row">
                    <div class="col-md-6">
                        <label for="startdate"><strong>Check In</strong><span class="text-danger">*</span></label>
                        <input id="startdate" type="text" class="input-sm form-control" name="start_date" placeholder="Check-in" value="{{$holdStarDate}}">
                    </div>
                    <div class="col-md-6">    
                        <label for="startdate"><strong>Check Out</strong><span class="text-danger">*</span></label>
                        <input type="text" class="input-sm form-control" name="check_out" placeholder="Check-out" value="{{$holdCheckOut}}">
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="firstname"><strong>First name</strong><span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" maxlength="25" required="">
            </div>

            <div class="form-group col-md-6">
                <label for="lastname"><strong>Last name</strong><span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" maxlength="25" required="">
            </div>
        </div>

        	<div class="form-group">
                <label for="contact_no"><strong>Contact Number</strong><span class="text-danger">*</span></label>
                <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="+63" data-parsley-type="number" maxlength="11" required="">
            </div>

            <div class="form-group">
                <label for="dob"><strong>Date of birth</strong><span class="text-danger">*</span></label>
                <input type="date" class="form-control" min="1970-01-01"  max="2004-12-30" id="dob" name="dob" required="">
            </div>

           <div class="form-row">
            <div class="form-group col-md-6">
                <label for="street_ad"><strong>Street Address</strong><span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="street_ad" name="street_ad" placeholder="1234 Main St" maxlength="50" required="">
            </div>

            <div class="form-group col-md-3">
                <label for="city"><strong>City/Town</strong><span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="city" name="city" placeholder="city" maxlength="25" required="">
            </div>

            <div class="form-group col-md-3">
                <label for="province"><strong>Province</strong><span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="province" name="province" placeholder="province" maxlength="25" required="">
            </div>
        </div>

        <a href="/online/reservation" class="btn btn-secondary">Back</a>
        <button type="submit" class="btn btn-dark">Submit</button>
    </form>
    </div>
</div>
<hr>
</div>

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

$(function () {
  $('#submit-form').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  .on('form:submit', function() {
    return true; 
  });
});

// $(function(){
//     var dtToday = new Date();

//     var month = dtToday.getMonth() + 1;
//     var day = dtToday.getDate();
//     var year = dtToday.getFullYear();

//     if(month < 12)
//         month = '0' + month.toString();
//     if(day < 12)
//         day = '0' + day.toString();

//     var maxDate = year + '-' + month + '-' + day;    
//     $('#dob').attr('max', maxDate);
// });
</script>
@endsection