@extends('admin.app') 

@section('content')
<div class="container-fluid">
<h1 class="text-center">Manage Rooms</h1>
<hr>
<div class="row ">
    <div class="col-md-2 m-auto">
        <a href="#" class="btn btn-warning btn-block add-data-btn" data-toggle="modal" data-target="#addRoomsModal">
            <i class="fa fa-plus"></i> Add Rooms</a>
    </div>
</div>


        <div class="table-responsive">
            <table class="table table-bordered table-striped" id='roomsDatatable'>
                <thead class="thead-light">
                    <tr>
                        <th>Room Id</th>
                        <th>Room No.</th>
                        <th>Status</th>
                        <th>Type</th>
                        <th>Description</th>
                        <th>Capacity</th>
                        <th>Rate</th>
                        <th>Created at</th>
                        <th>Last updated</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
   
<hr>
</div>  


<!-- MODAL -->
    <div class="modal fade" id="addRoomsModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-warning text-white">
                    <h5 class="modal-title">Add Rooms</h5>
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editRoomsModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Rooms</h5>
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignTenantModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Edit Rooms</h5>
                    <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="viewRoom">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-default">
                    <h5 class="modal-title">Image</h5>
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
        $('#roomsDatatable').DataTable({
            bProcessing: true,
            bServerSide: false,
            sServerMethod: "GET",
            ajax:{
                "url":'/manage-rooms/getRoomsDatatable',
                "type": "GET"
            },
             "columnDefs": [
            { className: "dt-right", "targets": [ 6 ] }    
            ],  
            columns: [
                {data: 'id',      	    name: 'id'},
                {data: 'room_no',     	name: 'room_no'},
                {data: 'status',      	name: 'status'},
                {data: 'type',       	  name: 'type'},
                {data: 'description',   name: 'description'},
                {data: 'capacity', 		  name: 'capacity'},
                {data: 'rates', render: $.fn.dataTable.render.number( ',', '.', 2, 'P' ),      	  name: 'rates'},
                {data: 'created',      name: 'created'},
                {data: 'updated',      name: 'updated'},
                {data: 'action' ,       name: 'action', orderable: false, searchable: false}
            ],
            
        });
     });

    //Call the add button modal
    $(document).off('click','.add-data-btn').on('click','.add-data-btn', function(e){
          e.preventDefault();
          var that = this;  
          $("#addRoomsModal").modal();            
          $("#addRoomsModal .modal-body").load('/manage-rooms/create');
        });

    //Call the edit button modal
    $(document).off('click','.edit-data-btn').on('click','.edit-data-btn', function(e){
          e.preventDefault();
          var that = this;  
            $("#editRoomsModal").modal();            
          	$("#editRoomsModal .modal-body").load('/manage-rooms/'+that.dataset.id+'/edit', function(res){
          });
        });

    //Call the view button modal
    $(document).off('click','.view-data-btn').on('click','.view-data-btn', function(e){
          e.preventDefault();
          var that = this;  
            $("#viewRoom").modal();            
            $("#viewRoom .modal-body").load('/manage-rooms/'+that.dataset.id, function(res){
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
                      url:'/manage-rooms/'+that.dataset.id,
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        $("#roomsDatatable").DataTable().ajax.url( '/manage-rooms/getRoomsDatatable' ).load();
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
</script>
@endsection