@extends('admin.app')

@section('content')
<div class="container-fluid">
    
  <h1 class="text-center">Manage Users</h1>
<hr>        
</div>

<div class="container-fluid mt-4">
 <div class="row mt-2">
    <div class="col-md-2 m-auto">
      <a href="#" class="btn btn-primary btn-block add-data-btn" data-toggle="modal" data-target="#addUserModal">
        <i class="fa fa-plus"></i> Add User
      </a>
    </div>
  </div>

  <div class="col-md-12">         
    <div class="table-responsive "> 
        <table class="table table-bordered table-striped table-hover" id="usersDatatable">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Address</th>
              <th>Date of Birth</th>
              <th>Contact No.</th>
              <th>E-mail</th>
              <th>Username</th>
              <th>Status</th>
              <th>Role</th>
              <th>Verified</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</div>

<br>
<div class="container-fluid">
  <div class="row">
      <div class="col-md-5 ml-5 mt-3">
        <h2>Inactive Users</h2>
      </div>
  </div>
</div>
<br>

 <div class="col-md-12">         
    <div class="table-responsive"> 
        <table class="table table-bordered table-striped table-hover" id="usersInactiveDatatable">
          <thead class="thead-light">
            <tr>
              <th>Id</th>
              <th>Name</th>
              <th>Address</th>
              <th>Date of Birth</th>
              <th>Contact No.</th>
              <th>E-mail</th>
              <th>Username</th>
              <th>Status</th>
              <th>Role</th>
              <th>Verified</th>
              <th>Actions</th>
            </tr>
          </thead>
        </table>
    </div>
  </div>
</div>

<div class="modal fade" id="addUsersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title">Add User</h5>
              <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div> 
        </div>
    </div>
</div>
<hr>
<!-- MODAL -->
<div class="modal fade" id="editUsersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Edit User</h5>
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div> 
        </div>
    </div>
</div>

<div class="modal fade" id="editInactiveUsersModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Edit User</h5>
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div> 
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script type="text/javascript">
    $(function() {
        $('#usersDatatable').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax:{
                "url":'/manage-users/getUsersDatatable',
                "type": "GET"
            },
            columns: [
                {data: 'id',            name: 'id'},
                {data: 'name',          name: 'name'},
                {data: 'address',       name: 'address'},
                {data: 'dob',           name: 'dob'},
                {data: 'contact_no',    name: 'contact_no'},
                {data: 'email',         name: 'email'},
                {data: 'username',      name: 'username'},
                {data: 'status',        name: 'status'},
                {data: 'role',          name: 'role'},
                {data: 'verified',      name: 'verified'},
                {data: 'action' ,       name: 'action', orderable: false, searchable: false}
            ],
        });

$(function() {
        $('#usersInactiveDatatable').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax:{
                "url":'/manage-users/inactiveUserDatatable',
                "type": "GET"
            },
            columns: [
                {data: 'id',            name: 'id'},
                {data: 'name',          name: 'name'},
                {data: 'address',       name: 'address'},
                {data: 'dob',           name: 'dob'},
                {data: 'contact_no',    name: 'contact_no'},
                {data: 'email',         name: 'email'},
                {data: 'username',      name: 'username'},
                {data: 'status',        name: 'status'},
                {data: 'role',          name: 'role'},
                {data: 'verified',          name: 'verified'},
                {data: 'action' ,       name: 'action', orderable: false, searchable: false}
            ]
        })
      });

    //Call the add button modal
    $(document).off('click','.add-data-btn').on('click','.add-data-btn', function(e){
          e.preventDefault();
          var that = this;  
          $("#addUsersModal").modal();            
          $("#addUsersModal .modal-body").load('/manage-users/create');
        });

    //Call the edit button modal
    $(document).off('click','.edit-data-btn').on('click','.edit-data-btn', function(e){
          e.preventDefault();
          var that = this;  
            $("#editUsersModal").modal();            
          $("#editUsersModal .modal-body").load('/manage-users/'+that.dataset.id+'/edit', function(res){
          });
        });

    //Call the delete button modal
    $(document).off('click','.delete-data-btn').on('click','.delete-data-btn', function(e){
          e.preventDefault();
          var that = this; 
                bootbox.confirm({
                  title: "Confirm Delete Data?",
                  className: "del-bootbox",
                  message: "Are you sure you want to delete record?",
                  buttons: {
                      confirm: {
                          label: 'Yes',
                          className: 'btn-success'
                      },
                      cancel: {
                          label: 'No',
                          className: 'btn-danger'
                      }
                  },
                  callback: function (result) {
                     if(result){
                      var token = '{{csrf_token()}}'; 
                      $.ajax({
                      url:'/manage-users/'+that.dataset.id,
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        /*$("#usersDatatable").DataTable().ajax.url( '/manage-users/getUsersDatatable' ).load();*/
                        $("#usersInactiveDatatable").DataTable().ajax.url( '/manage-users/inactiveUserDatatable' ).load();
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
                      }
                      }); 
                     }
                  }
              });
        });

    //set Active user
    $(document).off('click','.setActive-data-btn').on('click','.setActive-data-btn', function(e){
          e.preventDefault();
          var id = $(this).attr('id');
          var that = this; 
                bootbox.confirm({
                  title: "Confirm Activate User?",
                  className: "del-bootbox",
                  message: "Are you sure you want to activate this User?",
                  buttons: {
                      confirm: {
                          label: 'Yes',
                          className: 'btn-success'
                      },
                      cancel: {
                          label: 'No',
                          className: 'btn-danger'
                      }
                  },
                  callback: function (result) {
                     if(result){
                      var token = '{{csrf_token()}}'; 
                      $.ajax({
                      url:'/manage-users/'+that.dataset.id+'/setActive',
                      type: 'post',
                      data:{status : 'Active', _token : token},
                      success:function(result){
                        $("#usersDatatable").DataTable().ajax.url( '/manage-users/getUsersDatatable' ).load();
                        $("#usersInactiveDatatable").DataTable().ajax.url( '/manage-users/inactiveUserDatatable' ).load();
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
                      }
                      }); 
                     }
                  }
              });
        });
    });
</script>
@endsection
