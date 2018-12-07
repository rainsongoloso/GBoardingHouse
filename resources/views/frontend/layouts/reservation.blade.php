@extends('frontend.app')

@section('content')
<div class="container mt-5">
  @include('success')
  <h1 class="text-center">Reserve A Room</h1>
  <hr>
  <p style="font-family:Verdana; font-size: 18px" class="text-center">Making a reservation at any Goloso Boarding House is easy and takes just a couple of minutes.</p>
 
  <p style="font-family:Verdana; font-size: 18px" class="text-center">
	All you have to do is to fill up the check in and check out dates to check availability. If there is no availability showing, please contact the boarding house directly as they may be able to assist. We look forward to welcoming you soon. This is only for females.
  </p>
 
<form data-parsley-validate="" action="/online/reserv" method="GET">
    {{ csrf_field() }}
    <div class="form-group">
            <div class="form-row">
                <div class="col-md-6">
                    <label for="checkin">Check In<span class="text-danger">*</span></label>
                    <input type="text" id="checkin" class="form-control" name="start_date">
                </div>
                <div class="col-md-6">
                    <label for="checkout">Check Out<span class="text-danger">*</span></label>
                    <input type="text" id="checkout" class="form-control" name="check_out">
                </div>
            </div>
            <br>
            <button type="submit" class="btn btn-warning btn-md">Search</button>
        </div>

</form>
</div>
</div>

            
         
@endsection

@section('scripts')
<script type="text/javascript">

$("#checkin").datepicker({ minViewMode: 0, startDate: "+3d", format: "DD, MM dd yyyy", startView: 1, clearBtn: true, }).on('changeDate', 
  function(ev){
   startDate: ev.date.setMonth(ev.date.getMonth() + 1), 
$("#checkout").datepicker('setStartDate',ev.date);});
$("#checkout").datepicker({format:"DD, MM dd yyyy"}); 
</script>
@endsection

