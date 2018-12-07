@extends('tenant.app')

@section('content')
<div class="container">
<div class="row">
	<div class="col">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Information</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Room</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
	<ul class="list-group list-group-flush">
		<li class="list-group-item">Name: {{$user->full_name}}</li>
		<li class="list-group-item">Address: {{$user->address()}}</li>
		<li class="list-group-item">Date of birth: {{$user->dob()}}</li>
		<li class="list-group-item">Email: {{$user->email}}</li>
		<li class="list-group-item">Contact number: {{$user->contact_no}}</li>
		
		</li>
	</ul>
</div>
  <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab"><ul class="list-group list-group-flush">
  	@if(count($user->occupant) >0)
		<li class="list-group-item">Occupant id: {{$user->occupant->id}}</li>
		<li class="list-group-item">Room no.: {{$user->occupant->room->room_no}}</li>
		<li class="list-group-item">Type: {{$user->occupant->room->type}}</li>
		<li class="list-group-item">Amenity availed:@foreach($occupantA as $occu)
			{{$occu->amen_name}}<br>
			@endforeach
		</li>
	@else
		You are not an occupant
	@endif
		</li>
	</ul></div>
</div>
	</div>
</div>
<br>
</div>
	
	
	
	
	
	
	
@endsection