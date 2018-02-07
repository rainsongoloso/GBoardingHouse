<form action="/reservations/{{$reservation->id}}/payResevation" method="POST" id="payForm" >

    {{csrf_field()}}

   <h4>Reservation Id: {{$reservation->id}}</h4>
   <h4>User's name: {{$reservation->user->full_name}}</h4>
   <h4>Availed Room: {{$reservation->room->room_no}} </h4> 
   <h4>Type: {{$reservation->room->type}}</h4>
   <h4>Amount to be paid: {{number_format($reservation->room->roomRate(),2)}}</h4>

<div class="form-group">
    <label for="remarks">Remarks:</label>
    <select class="custom-select" id="remarks" name="remarks" required onchange="showfield(this.options[this.selectedIndex].value)" >
        <option selected>Choose remarks...</option>
        <option value="Advance payment">Advance payment</option>
        <option value="Deposit">Deposit</option>
    </select>
    <span class="help-text text-danger"></span>
</div>

<div id="message"></div>

<!-- <div class="form-group">
    <label for="payment_for">Payment For:</label>
    <input id="payment_for" type="date" name="payment_for" class="form-control" required="">
    <span class="help-text text-danger"></span>
</div> -->

<div class="form-group">
    <label for="amountPay">Amount</label>
    <input id="amountPay" type="numeric" name="amountPay" class="form-control" required>
    <span class="help-text text-danger"></span>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-info add-btn">Settle</button>
</div>

</form>

<script type="text/javascript">

    function showfield(name){
      if(name == "Deposit")
      {
        document.getElementById('message').innerHTML='<div class="alert alert-danger"> <label>Pay atleast 50% = {{number_format($reservation->room->roomRate()*.50,2)}}</label> </div>'
      }
      else
      {
        document.getElementById('message').innerHTML='';
      } 
    };

    $(function(){
        $(document).off('click','.add-btn').on('click','.add-btn', function(e){
            e.preventDefault();
            var $form = $('#payForm');
            var $url = $form.attr('action');
            $.ajax({
              type: 'POST',
              url: $url,
              data: $("#payForm").serialize(), 
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
                $("#reservationDatatable").DataTable().ajax.url( '/reservations/reservationDatatable' ).load();
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

