@extends('frontend.app')

@section('content')
<section id="body" class="py-2" ">
	<div class="container-fluid">
		<div class="row py-5">
			<div class="col text-center text-black">
				<h1>Contact Us</h1>
				<hr style="background-color: grey;">				
			</div>
		</div>
<div class="row">
	  <div class="col-md-7">
        <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d3933.3854033456573!2d123.86626861400292!3d9.64807229969888!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sph!4v1516079263488" width="100%" height="90%" frameborder="1" style="border:0" allowfullscreen></iframe>
      </div>

		<form class="form-horizontal" action="/action_page.php">
  <div class="form-group">
    <label class="control-label col-sm-5" for="name">Name:</label>
    <div class="col-sm-101">
      <input type="name" class="form-control" id="name" placeholder="Enter name">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-5" for="email">Email:</label>
    <div class="col-sm-101"> 
      <input type="email" class="form-control" id="email" placeholder="Enter email">
    </div>
  </div>
  <div class="form-group">
    <label class="control-label col-sm-5" for="name">Mobile Number:</label>
    <div class="col-sm-101">
      <input type="name" class="form-control" id="name" placeholder="Enter name">
    </div>
  </div>
  <div class="form-group"> 
  	<label class="control-label col-sm-5" for="email">Inquiry:</label>
    <div class="col-sm-offset-2 col-sm-101">
      <div class="textarea">
        <textarea class="form-control" rows="5" id="comment"></textarea>
      </div>
    </div>
  </div>
  <div class="form-group"> 
    <div class="col-sm-offset-2 col-sm-101">
      <button type="submit" class="btn btn-default-center">Submit</button>
    </div>
  </div>
</form>
</div>
	</div>
  <hr>
</section>
@endsection