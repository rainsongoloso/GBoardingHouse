<form action="/manage-users/{{$user->id}}" method="PATCH" id="edit-users-form">
    {{ csrf_field() }}
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname">Firstname</label>
            <input class="form-control" type="text" name="firstname" id="firstname" value="{{ $user->firstname }}" required>
            <span class="help-text text-danger"></span>
        </div>
        <div class="form-group col-md-6">
            <label for="lastname">Lastname</label>
            <input class="form-control" type="text" name="lastname" id="lastname" required value="{{ $user->lastname }}">
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="street_ad">Street address</label>
            <input id="street_ad" type="text" name="street_ad" class="form-control" value="{{ $user->street_ad }}" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="city">City</label>
            <input id="city" type="text" name="city" class="form-control" value="{{ $user->city }}" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-3">
            <label for="province">Province</label>
            <input id="province" type="text" name="province" class="form-control" value="{{ $user->province }}" required>
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="contact_no">Contact No.</label>
            <input id="contact_no" type="text" name="contact_no" class="form-control" value="{{ $user->contact_no }}" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-3">
            <label for="dob">Date of Birth</label>
            <input class="form-control" id="dob" type="date" name="dob" value="{{ $user->dob }}" required>
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-4">
            <label for="email">E-mail address</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-md-5">
            <label for="username">Username</label>
            <input id="username" type="text" name="username" class="form-control" required value="{{ $user->username }}">
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-2">
            <label for="role">Role</label>
            <select class="custom-select" id="role" name="role">
                <option value="Client" {{$user->role == 'Client' ? 'selected':''}}>Client</option>     
                <option value="Tenant" {{$user->role == 'Tenant' ? 'selected':''}}>Tenant</option>
                <option value="Admin" {{$user->role == 'Admin' ? 'selected':''}}>Admin</option>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="status">Status</label>
            <select class="custom-select" id="status" name="status">
                <option value="Active" {{$user->status == 'Active' ? 'selected':''}}>Active</option>
                <option value="Inactive" {{$user->status == 'Inactive' ? 'selected':''}}>Inactive</option>
            </select>
        </div>

        <div class="form-group col-md-5">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" class="form-control" placeholder="password">
            <span class="help-text text-danger"></span>
        </div>

        <div class="form-group col-md-5">
            <label for="password_confirmation">Password confirmation</label>
            <input id="password_confirmation" type="password" name="password_confirmation" class="form-control" placeholder="password confirmation" >
            <span class="help-text text-danger"></span>
        </div>
    </div>

    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <div class="btn btn-success update-btn">Update</div>
    </div>
</form>
				
<script type="text/javascript">
	$(function(){
        $(document).off('click','.update-btn').on('click','.update-btn', function(e){
            e.preventDefault();
            var $form = $('#edit-users-form');
            var $url = $form.attr('action');
            $.ajax({
              type: 'PATCH',
              url: $url,
              data: $("#edit-users-form").serialize(), 
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