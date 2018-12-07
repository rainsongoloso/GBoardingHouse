@extends('admin.process-billing-payment.index')

@section('payments')
<div class="col-md-3">
@if(count($occupant->financials) > 0)
    
    <div class="card">
        <div class="card-header">
            Total Balance
        </div>
        <ul class="list-group list-group-flush">
            @if($balance >= 0)
                <li class="list-group-item"> <div class="alert alert-dismissible alert-success">No balance</div></li>
            @else
            
                <li class="list-group-item">
                    <div class="alert alert-dismissible alert-danger">{{number_format(abs($balance),2)}}
                    </div>
                </li>
            
            @endif
        </ul>
    </div>
    

    @else
    <div class="card" >
        <div class="card-header">
            Payment
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item"><strong>Id:</strong> {{$occupant->id}}</li> 

            <li class="list-group-item"><strong>Room:</strong><br>{{$occupant->room->room_no}} {{$occupant->room->type}} - {{number_format($occupant->room->roomRate(),2)}} </li>

            @if(count($occuAvail) > 0)
            <li class="list-group-item"><strong>Amenities:</strong><br>
                @foreach($occuAvail as $occu)
                    {{$occu->amen_name}} - {{$occu->rate}}<br>
                @endforeach  
            @else
            <li class="list-group-item"><strong>Amenities:</strong><br>None
            @endif

            <li class="list-group-item"><strong>Amenity total price:</strong> {{$occupantA}}

            <li class="list-group-item"><strong>Total:</strong> {{number_format($total = $occupant->room->roomRate() + $occupantA,2)}}</li>    
            
        </ul>
    </div>
@endif
</div>

<div class="col-md-5">
    <form action="/process/{{$occupant->id}}/payTenant" method="POST" id="pay-form">
        {{csrf_field()}}
        <label for="payment_for">Payment For</label>
        <input id="payment_for" type="date" min="2018-1-1" name="payment_for" class="form-control">

        <label for="remarks">Remarks</label>
        <select class="custom-select" id="remarks" name="remarks">
            <option value="Rent">Rent</option>
            <option value="Advance Payment">Advance Payment</option>
            <option value="Deposit">Deposit</option>
        </select>
       
        <label for="ammount">Amount</label>
        <input id="ammount" type="numeric" name="ammount" class="form-control">
        
        <div class="modal-footer">
        <button class="btn btn-primary pay-btn">pay</button>
        </div>
    </form>
</div>
@if($balance < 0)
@endif
@endsection

