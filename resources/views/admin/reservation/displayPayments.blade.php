<form action="/reservations/{{$reservation->id}}/payResevation" method="POST" >
    {{csrf_field()}}


<!-- <div class="form-group">
    <label for="remarks">Remarks:</label>
    <select class="custom-select" id="remarks" name="remarks" required>
        <option selected>Choose remarks...</option>
        <option value="Advance payment">Advance payment</option>
        <option value="Deposit">Deposit</option>
    </select>
    <span class="help-text text-danger"></span>
</div>

<div class="form-group">
    <label for="payFor">Payment For:</label>
    <input id="payFor" type="date" name="payFor" class="form-control" required="">
    <span class="help-text text-danger"></span> -->

    <h2>{{$getRoomRate}}</h2>

    <label for="amount">Amount</label>
    <input id="amount" type="numeric" name="amountPay" class="form-control" required>
    <span class="help-text text-danger"></span>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success">Settle</button>
</div>
</form>