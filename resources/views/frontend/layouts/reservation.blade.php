@extends('frontend.app')

@section('content')
<div class="container mt-5">
  @include('success')
  <h1 class="text-center">Reserve A Room</h1>
  <hr>
  <p style="font-family:Verdana; font-size: 18px" class="text-center">Making a reservation at any Goloso Boarding House is easy and takes just a couple of minutes.</p>
 
  <p style="font-family:Verdana; font-size: 18px" class="text-center">
	All you have to do is select a Room type. If there is no availability showing, please contact the boarding house directly as they may be able to assist. We look forward to welcoming you soon.
	Females only.
  </p>
 
 <div class="row mt-5">
 
<div class="col-md-6">
	<!-- <div class="col-md-4 mt-3"> -->
<a href="/online/reservation/bedspacer" class="btn  btn-dark btn-lg btn-block mb-5">Bed Spacer</a>
</div>

<div class="col-md-6">  
<a href="/online/reservation/private" class="btn btn-dark btn-lg btn-block">Private</a>
    </div>   
</div>
<hr>
</div>
       
</div>
@endsection

