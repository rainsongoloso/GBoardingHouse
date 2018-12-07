@extends('frontend.app')

@section('content')
<section id="body" class="py-2">
	<div class="container-fluid">
		<div class="row py-5">
			<div class="col text-center text-black">
				<h1 class="text-center">Galleries</h1>
				<hr style="background-color: white;">				
			</div>
		</div>

		<div class="row">
			<div class="col-md-6 mb-4 text-center">
				<div class="card bg-dark text-white">
				  <img class="card-img" src="{{ asset('images/g-1.jpg')}}" alt="Card image">
				  <div class="card-img-overlay">
				  	<div class="card-body">
				    <!-- <h4 class="card-title">Bed Spacer</h4> -->
				    <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
				    <!-- <a href="#" class="btn btn-dark">Show More</a> -->
					</div>
				  </div>
				</div>
			</div>

			<div class="col-md-6 mb-4 text-center text-white">
				<div class="card bg-dark text-white">
				  <img class="card-img" src="{{ asset('images/g-2.jpg')}}" alt="Card image">
				  <div class="card-img-overlay">
				  	<div class="card-body">
				    <!-- <h4 class="card-title">Private</h4> -->
				    <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
				   <!--  <a href="#" class="btn btn-dark">Show More</a> -->
				    </div>
				  </div>
				</div>
			</div>

			<div class="col-md-6 mb-4 text-center text-white">
				<div class="card bg-dark text-white">
				  <img class="card-img" src="{{ asset('images/g-3.jpg')}}" alt="Card image">
				  <div class="card-img-overlay">
				    <!-- <h4 class="card-title">Services</h4> -->
				   <!--  <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
				    <!-- <a href="#" class="btn btn-dark">Show More</a> -->
				  </div>
				</div>
			</div>

			<div class="col-md-6 mb-4 text-center text-white">
				<div class="card bg-dark text-white">
				  <img class="card-img" src="{{ asset('images/g-4.jpg')}}" alt="Card image">
				  <div class="card-img-overlay">
				   <!--  <h4 class="card-title">Enviroment</h4> -->
				    <!-- <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p> -->
				    <!-- <a href="#" class="btn btn-dark">Show More</a> -->
				  </div>
				</div>
			</div>
		</div>
		<hr>
	</div>

</section>
@endsection