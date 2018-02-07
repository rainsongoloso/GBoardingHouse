@extends('client.app')

@section('content')
<div class="container">
    @if(count($userreserv)>0)
    <h2 class="mt-5 mb-3">Manage Reservation</h2> 
    @include('success') 
    @include('errors')
    <div class="row">
        <div class="col">
            <table class="table">
                <thead class="text-white bg-dark">
                    <tr>
                        <th>Reservation Code</th>
                        <th>Status</th>
                        <th>Room</th>
                        <th>Room Type</th>
                        <th>Start Date</th>
                        @if($userreserv->status != 'Cancel')
                            <th>Actions</th>
                        @else
                            <th>Message</th>
                        @endif

                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>{{$userreserv->id}}</th>
                        <td>{{$userreserv->status}}</td>
                        <td>{{$userreserv->room->room_no}}</td>
                        <td>{{$userreserv->room->type}}</td>
                        <td>{{\Carbon\Carbon::parse($userreserv->start_date)->format('l jS \\of F Y')}}</td>
                        <td>
                            @if($userreserv->status != 'Cancel')
                                <a href="/client/{{$userreserv->id}}/reservationEdit" class="btn btn-success"><i class="fa fa-pencil-square-o"></i></a>

                                <a href="/reservations/{{$userreserv->id}}/cancel" class="btn btn-danger cancel-data-btn"><i class="fa fa-times-circle"></i></a> 
                            @else
                            Your Reservation is Canceled 
                            @endif
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="container mt-5">
        <h2 class="text-center">Nothing to manage.. to use this account please 
        reserve a room</h2>
        <a href="/online/reservation" class="btn btn-primary">Reserve Room</a>
    </div>
    @endif
</div>
@endsection


@section('scripts')
<script type="text/javascript">
$(document).off('click','.cancel-data-btn').on('click','.cancel-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          alert("ID:  " + $(this).attr('Id'));
                bootbox.confirm({
                  title: "Confirm Cancel data Data?",
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
                      url:'/reservations/'+that+'/cancel',
                      type: 'post',
                      data: { status : 'Cancel', _token : token},
                      success:function(result){
                        $("#cancelReservationDatatable").DataTable().ajax.url( '/reservations/cancelReservationDatatable' ).load();
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
