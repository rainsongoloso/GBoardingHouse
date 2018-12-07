@extends('client.app')

@section('content')
<div class="container">
    @if(count($userreserv)>0)
    <!-- @include('success') -->
    <div class="alert alert-info" role="alert">
      <h4 class="alert-heading"><strong>NOTE!</strong></h4>
      <p>Visit the <strong>Boarding House</strong> to pay your <strong>Reservation</strong>. If you cant pay <strong>after 1 week of your reservation date</strong> your reservation will be <strong>Canceled</strong></p>
    </div>
    @include('errors')
    <h2 class="mt-1 mb-2">Manage Reservation</h2> 
    <div class="row">
        <div class="col">
            <table class="table" id="clientTable">
                <thead class="text-white bg-dark">
                    <tr>
                        <th>Reservation Code</th>
                        <th>Status</th>
                        <th>Room</th>
                        <th>Room Type</th>
                        <th>Check in</th>
                        <th>Check out</th>
                        <th>Date Reserved</th>
                        @foreach($userreserv as $userreservs)
                          @if($userreservs->status != 'Cancel')
                              <th>Actions</th>
                          @else
                              <th>Message</th>
                          @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                  @foreach($userreserv as $userreservs)
                    <tr>
                        <td>{{$userreservs->id}}</td>
                        <td>{{$userreservs->status}}</td>
                        <td>{{$userreservs->room->room_no}}</td>
                        <td>{{$userreservs->room->type}}</td>
                        <td>{{\Carbon\Carbon::parse($userreservs->check_in)->toFormattedDateString()}}</td>
                        <td>{{\Carbon\Carbon::parse($userreservs->check_out)->toFormattedDateString()}}</td>
                        <td>{{\Carbon\Carbon::parse($userreservs->created_at)->toFormattedDateString()}}</td>
                        <td>
                            @if($userreservs->status != 'Cancel')
                                <a href="/client/{{$userreservs->id}}/reservationEdit" class="btn btn-success"><i class="fa fa-pencil-square-o"></i></a>

                                <button class="btn btn-warning cancel-data-btn" data-id="{{$userreservs->id}}">
                                <i class="fa fa-remove"></i></a>
                                </button>
                            @else
                            Your Reservation has been Canceled 
                            @endif
                        </td>
                    </tr>
                  @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="container">
      <div class="alert alert-warning text-center" role="alert">
        <strong>No reservation!</strong> To use this account please  
        <a href="/online/reservation" class="alert-link"><h1>Reserve A Room.</h1></a>
      </div>
    </div>
    @endif
</div>
@endsection


@section('scripts')
<script type="text/javascript">
$(document).off('click','.cancel-data-btn').on('click','.cancel-data-btn', function(e){
          e.preventDefault();
          var that = this; 
          // alert("ID:  " + $(this).attr('Id'));
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
                      url:'/client/'+that.dataset.id+'/cancelReserv',
                      type: 'post',
                      data: { status : 'Cancel', _token : token},
                      success:function(result){
                        if(result.success)
                        {
                        swal({title: result.msg, icon: "success"}).then(function(){ 
                          location.reload(); 
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
