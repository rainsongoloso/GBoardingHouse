 <form method="POST" action="{{ url('manage-users') }}" id="add-users-form">

    {{csrf_field()}}

    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname">Firstname</label>
            <input id="firstname" type="text" name="firstname" class="form-control" placeholder="First name" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-6">
            <label for="lastname">Lastname</label>
            <input id="lastname" type="text" name="lastname" class="form-control" placeholder="Last name" required>
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="street_ad">Street address</label>
            <input id="street_ad" type="text" name="street_ad" class="form-control" placeholder="Street address" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="city">City/Town</label>
            <input id="city" type="text" name="city" class="form-control" placeholder="City" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-3">
            <label for="province">Province</label>
            <input id="province" type="text" name="province" class="form-control" placeholder="Province" required>
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="contact_no">Contact No.</label>
            <input id="contact_no" type="text" name="contact_no" class="form-control" placeholder="Contact Number" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-3">
            <label for="dob">Date of Birth</label>
            <input id="dob" type="date" name="dob" class="form-control" required min="1970-01-01" max="2004-12-30">
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="email">E-mail address</label>
            <input id="email" type="email" name="email" class="form-control" placeholder="E-mail address"required>
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" class="form-control" placeholder="Username"required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" placeholder="Password" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-3">
            <label for="role">Role</label>
            <select class="custom-select" id="role" name="role">
                <option value="Client">Client</option>
                <option value="Tenant">Tenant</option>
                <option value="Admin">Admin</option>
            </select>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button class="btn btn-primary add-btn">Submit</button>
    </div>
</form> 
<!-- <div class="form-row"> -->	
	

	<!-- div class="form-group col-md-2">
		<label for="status">Status</label>
		<select class="custom-select" id="status" name="status">
			<option value="Active" selected>Active</option>
			<option value="Inactive">Inactive</option>
		</select> 
	</div> -->
<!-- </div> -->
<!-- onchange="showfield(this.options[this.selectedIndex].value) -->
<!-- <div class="form-row text-right">
	<div class="form-group col-md-4">
		<div id="rooms"></div>
	</div>

	<div class="form-group col-md-4">
		<div id="amenities"></div>
	</div>
</div> -->					
<script type="text/javascript">

	/*function showfield(name){
	  if(name == "Tenant")
	  {
	  	document.getElementById('rooms').innerHTML='<label for="roomss">Rooms</label><select class="custom-select" name="room_id" id="roomss"> @foreach($rooms as $room)<option value="{{$room->id}}">{{$room->room_no}} - Rate: {{$room->rate}}</option>@endforeach'

	  	document.getElementById('amenities').innerHTML= '<label for="amenity">Amenities</label><select class="custom-select" id="amenity"> @foreach($amenity as $ament)<option value="{{$ament->amen_id}}">{{$ament->description}} - Rate: {{$ament->rate}}</option>@endforeach'
	  }
	  else
	  {
	  	document.getElementById('rooms').innerHTML='';
	  	document.getElementById('amenities').innerHTML='';
	  } 
	};*/

	$(function(){
        $(document).off('click','.add-btn').on('click','.add-btn', function(e){
            e.preventDefault();
            var $form = $('#add-users-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#add-users-form").serialize(), 
              success: function(result){
                if(result.success){
                  swal({
                      title: result.msg,
                      icon: "success"
                    });
                }else{
                  swal({
                      title: result.msg,
                      icon: "error"
                    });
                }
                $("#usersDatatable").DataTable().ajax.url( '/manage-users/getUsersDatatable' ).load();
                $("#usersInactiveDatatable").DataTable().ajax.url( '/manage-users/inactiveUserDatatable' ).load();
                $('.modal').modal('hide');
              },
              error: function(xhr,status,error){
                var response_object = JSON.parse(xhr.responseText); 
                associate_errors(response_object.errors, $form);
              }
            });
        });  
     });  
</script>