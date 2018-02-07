@extends('admin.process-billing-payment.index')

@section('payments')
<div class="col-md-2">
@if(count($occupant->financials) > 0)
    
    <div class="card" style="width: 10rem;">
        <div class="card-header">
            Total Balance
        </div>
        <ul class="list-group list-group-flush">
            @if($balance >= 0)
                <li class="list-group-item">No balance</li>
            @else
                <li class="list-group-item">{{number_format($balance,2)}}</li>
            @endif
        </ul>
    </div>
    

    @else
    <div class="card" style="width: 10rem;">
        <div class="card-header">
            Payment
        </div>
        <ul class="list-group list-group-flush">
            <li class="list-group-item">Room price: {{$occupant->room->roomRate()}}</li>
            @if($occupant->isNull())
            <li class="list-group-item">Total: {{number_format($total = $occupant->room->roomRate() + $occupant->amenity->rate)}}</li>
            @else
            <li class="list-group-item">Amenity price: none</li>
            @endif
        </ul>
    </div>
@endif
</div>

@if($balance < 0)
<div class="col-md-4">
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
@endif


@endsection

