@extends('admin.app')

@section('content')
<div class="container">
  <h1 class="text-center">Manage Reservations</h1>      
<hr>
    <div class="row mt-2 mb-3">
        <div class="col-md-2 m-auto">
            <a href="#" class="btn btn-dark btn-block add-data-btn" data-toggle="modal" data-target="#addReservationModal">
                <i class="fa fa-plus"></i> Add Reservation
            </a>
        </div>
    </div>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover" id="reservationDatatable">
                <thead class="thead-light">
                    <tr>
                        <th>Id</th>
                        <th>Client</th>
                        <th>Room No.</th>
                        <th>Room Type</th>
                        <th>Status</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Date Reserve</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
<hr>
</div>    
<!-- </div> -->
<div class="modal fade" id="addReservationModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title">Add Reservation</h5>
                <button class="close btn-sm" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editReservationModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Edit Reservation</h5>
                <button class="close" data-dismiss="modal"><i class="fa fa-close"></i></button>
            </div>
            <div class="modal-body">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="settleReservationModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Settle Reservation</h5>
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
//for Active Reservation
$(function() {
    $('#reservationDatatable').DataTable({

      "order": [[ 7, "dsc" ]],

        bProcessing: true,
        bServerSide: false,
        sServerMethod: "GET",
        ajax:{
            "url":'/reservations/reservationDatatable',
            "type": "GET"
        },
        columns: [
            {data: 'id',            name: 'id'},
            {data: 'user',          name: 'user'},
            {data: 'roomNo',        name: 'roomNo'},
            {data: 'roomType',      name: 'roomType'},
            {data: 'status',        name: 'status'},
            {data: 'startDate',     name: 'startDate'},
            {data: 'checkOut',      name: 'checkOut'},
            {data: 'dateReserv',    name: 'dateReserv'},
            {data: 'action',        name: 'action', orderable: false, searchable: false},
        ]
    });

//add reservation button
$(document).off('click','.add-data-btn').on('click','.add-data-btn', function(e){
          e.preventDefault();
          var that = this;  
          $("#addReservationModal").modal();            
          $("#addReservationModal .modal-body").load('/reservations/addResevation');
        });

});

//call Edit Modal
$(document).off('click','.edit-data-btn').on('click','.edit-data-btn', function(e){
          e.preventDefault();
          var that = this;  
            $("#editReservationModal").modal();            
          $("#editReservationModal .modal-body").load('/reservations/'+that.dataset.id+'/editReservation', function(res){
          });
        });

//call pay modal
$(document).off('click','.settle-data-btn-data-btn').on('click','.settle-data-btn', function(e){
          e.preventDefault();
          var that = this;  
            $("#settleReservationModal").modal();            
          $("#settleReservationModal .modal-body").load('/reservations/'+that.dataset.id+'/formPay', function(res){
          });
        });

//cancel
 $(document).off('click','.cancel-data-btn').on('click','.cancel-data-btn', function(e){
          e.preventDefault();
          var that = this; 
                bootbox.confirm({
                  title: "Confirm Cancel?",
                  className: "del-bootbox text-",
                  message: "Are you sure you want to cancel Reservation?",
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
                      url:'/reservations/'+that.dataset.id+'/cancel',
                      type: 'post',
                      data: { status : 'Cancel', _token : token},
                      success:function(result){
                        $("#cancelReservationDatatable").DataTable().ajax.url( '/reservations/cancelReservationDatatable' ).load();
                        $("#reservationDatatable").DataTable().ajax.url( '/reservations/reservationDatatable' ).load();
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

 $(document).off('click','.delete-data-btn').on('click','.delete-data-btn', function(e){
          e.preventDefault();
          var that = this; 
                bootbox.confirm({
                  title: "Confirm Delete Data?",
                  className: "del-bootbox",
                  message: "Are you sure you want to delete this record?",
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
                      url:'/reservations/'+that.dataset.id,
                      type: 'post',
                      data: {_method: 'delete', _token :token},
                      success:function(result){
                        $("#reservationDatatable").DataTable().ajax.url( '/reservations/reservationDatatable' ).load();
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