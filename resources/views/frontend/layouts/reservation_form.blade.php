@extends('frontend.app')

@section('content')
<div class="container mt-5">
    <h1 class="text-center">Reservation form</h1>
    <hr>
<div class="row">@include('errors')</div>
<div class="row mt-5">
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
<form id="submit-form" data-parsley-validate="" action="/online/{{$room->id}}/reserve" method="POST" class="mt-4">

		{{ csrf_field() }}

        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="firstname">First name</label>
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First name" maxlength="25" required="">
            </div>

            <div class="form-group col-md-4">
                <label for="lastname">Last name</label>
                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Last name" maxlength="25" required="">
            </div>

            <div class="form-group col-md-4">
                <label for="email_address">Email</label>
                <input type="email" class="form-control" id="email_address" name="email" placeholder="Email Address" data-parsley-trigger="change" required="">
            </div>
        </div>

        <!-- <div class="form-row"> -->
        	<div class="form-group">
                <label for="contact_no">Contact Number</label>
                <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="+63" data-parsley-type="number" maxlength="11" required="">
            </div>

            <div class="form-group">
                <label for="dob">Date of birth</label>
                <input type="date" class="form-control" min="1987-01-01" id="dob" name="dob" required="">
            </div>

            
        <!-- </div> -->

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="street_ad">Street Address</label>
                <input type="text" class="form-control" id="street_ad" name="street_ad" placeholder="1234 Main St" maxlength="50" required="">
            </div>

            <div class="form-group col-md-3">
                <label for="city">City/Town</label>
                <input type="text" class="form-control" id="city" name="city" placeholder="city" maxlength="25" required="">
            </div>

            <div class="form-group col-md-3">
                <label for="province">Province</label>
                <input type="text" class="form-control" id="province" name="province" placeholder="province" maxlength="25" required="">
            </div>
        </div>

            <div class="form-group ">
                <label for="startdate">Start date</label>
                <input type="date" class="form-control" id="startdate" name="start_date" required="" min="2018-01-01">
            </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Username" maxlength="25" required="">
            </div>

            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Password" maxlength="25" required="">
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
    $('#dob').attr('max', maxDate);
});
</script>
@endsection