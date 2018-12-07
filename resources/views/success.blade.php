@if(Session::has('message'))
	<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('message') }}
	</div> 
@elseif(Session::has('validate'))
	<div class="alert alert-danger  alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ Session::get('validate') }}
	</div>
@elseif(session('status'))
	<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
    {{ session('status') }}
	</div>
@elseif(session('reserv'))
	<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	{{ session('reserv') }}
	</div>
@elseif(session('warning'))
	<div class="alert alert-warning alert-dismissible" role="alert">
	<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	{{ session('warning') }}
	</div>
@elseif(Session::has('note'))
<div class="alert alert-info" role="alert">
  <h4 class="alert-heading">Note!</h4>
  <p>{{ session('note') }}</p>
</div>
@endif

