@extends('tenant.app')

@section('content')
	<div class="container">
		<div class="row">
			<div class="col">
				<h2 class="mb-4 text-center">Manage Account</h2>

				@include('success')
				@include('errors')

				<form method="POST" data-parsley-validate="" action="{{ url('/client/editAccount') }}" id="add-users-form">

    {{csrf_field()}}

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname">Firstname</label>
            <input id="firstname" type="text" name="firstname" class="form-control" placeholder="First name" value="{{$user->firstname}}" required="">
            
        </div>

        <div class="form-group col-md-6">
            <label for="lastname">Lastname</label>
            <input id="lastname" type="text" name="lastname" class="form-control" placeholder="Last name" value="{{$user->lastname}}" required="">
            
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="street_ad">Street address</label>
            <input id="street_ad" type="text" name="street_ad" class="form-control" placeholder="Street address" value="{{$user->street_ad}}" required="">
            
        </div>

        <div class="form-group col-md-4">
            <label for="city">City</label>
            <input id="city" type="text" name="city" class="form-control" placeholder="City" value="{{$user->city}}" required="">
            
        </div>

        <div class="form-group col-md-3">
            <label for="province">Province</label>
            <input id="province" type="text" name="province" class="form-control" placeholder="Province" value="{{$user->province}}" required="">
            
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="contact_no">Contact No.</label>
            <input id="contact_no" type="text" name="contact_no" class="form-control" placeholder="Contact Number" value="{{$user->contact_no}}" required="">
            
        </div>

        <div class="form-group col-md-3">
            <label for="dob">Date of Birth</label>
            <input id="dob" type="date" name="dob" class="form-control" min="1987-01-01" value="{{$user->dob}}"  required="">
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="email">E-mail address</label>
            <input id="email" type="email" name="email" class="form-control" placeholder="E-mail address" value="{{$user->email}}" required="">
            
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-4">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" class="form-control" placeholder="Username" value="{{$user->username}}" required="">
            
        </div>

        <div class="form-group col-md-4">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" placeholder="Password">
            
        </div>

        <div class="form-group col-md-4">
            <label for="password_confirmation">Password confirmation</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="Password confirmation">
            
        </div>
    </div>

    <div class="modal-footer">
        <a href="/client" class="btn btn-secondary">Cancel</a>
        <button class="btn btn-primary add-btn">Update</button>
    </div>
</form> 
			</div>
		</div>
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
    $('#dob').attr('max', maxDate);
});
</script>
@endsection