@extends('admin.app')

@section('content')
<div class="container">
<h1 class="text-center"> Process Payments </h1>
<hr>
@include('success')
    <div class="row mt-4">
        <div class="col-md-4 ">
        
            <form action="/process/tenant_payments" method="get" id="find-users-form">

                {{ csrf_field() }}

            <h4>Rental Payments</h4>
                <div class="form-group">
                    <select class="custom-select" id="occupant_id" name="occupant_id" required>
                        <option value="0">Please choose tenant..</option>
                        @if(count($occupants) > 0)
                            @foreach($occupants as $occupant)
                            <option value="{{$occupant->id}}"> {{$occupant->id}} -  {{$occupant->user->full_name}}</option>
                            @endforeach
                        @endif 
                    </select>
                    <span class="help-text text-danger"></span>
                </div>
                
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" onclick="myFunction()">Cancel</button>
                    <button type="submit"  class="btn btn-success find-btn" >Find</button>
                </div>
            </form>
        </div>
        @yield('payments')
</div>

 <div class="row mt-5">        
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table" id="paymentsDatatable">
                    <thead class="thead-light">
                        <tr>
                            <th>Id</th>
                            <th>Tenant</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Payment for</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th>Balance</th>
                            <th>Transaction date</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <hr>
</div>


@endsection

@section('scripts')
<script type="text/javascript">
$(function() {
    $('#paymentsDatatable').DataTable({
        bProcessing: true,
        bServerSide: false,
        sServerMethod: "GET",
        ajax:{
            "url":'/process/getProcessDatatable',
            "type": "GET",
        },

        "columnDefs": [
        { className: "dt-right", "targets": [ 5,6,7 ] }    
        ],

        columns: [
            {data: 'id',         name: 'id'},
            {data: 'occupant',   name: 'occupant'},
            {data: 'status',     name: 'status'},
            {data: 'remarks',     name: 'remarks'},    
            {data: 'monthPayment',  name: 'monthPayment'},
            {data: 'debit', render: $.fn.dataTable.render.number( ',', '.', 2, 'P' ),        name: 'debit'},
            {data: 'credit', render: $.fn.dataTable.render.number( ',', '.', 2, 'P' ),       name: 'credit'},
            {data: 'balance',render: $.fn.dataTable.render.number( ',', '.', 2, 'P' ),       name: 'balance'},
            {data: 'datepaid',       name: 'datepaid'},
            // {data: 'action',        name: 'action'},
        ]
    });
});

    $(function() {
        $(document).off('click', '.pay-btn').on('click', '.pay-btn', function(e) {
            e.preventDefault();
            var $form = $('#pay-form');
            var $url = $form.attr('action');
            $.ajax({
                type: 'POST',
                url: $url,
                data: $("#pay-form").serialize(),
                success: function(result) {
                    if (result.success) {
                        swal({
                            title: result.msg,
                            icon: "success"
                        }).then(function(){ 
                          location.reload(); 
                        });
                    } else {
                        swal({
                            title: result.msg,
                            icon: "error"
                        });
                    }
                    $("#paymentsDatatable").DataTable().ajax.url('/process/getProcessDatatable').load();
                    // $('.modal').modal('hide');
                },
                error: function(xhr, status, error) {
                    var response_object = JSON.parse(xhr.responseText);
                    associate_errors(response_object.errors, $form);
                }
            });
        });
    }); 


$(function(){
    var dtToday = new Date();

    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();

    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();

    var maxDate = year + '-' + month + '-' + day;    
    $('#payment_for').attr('min', maxDate);
});

</script>
@endsection