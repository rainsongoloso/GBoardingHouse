@extends('admin.financial.index')

@section('table')
<div class="container">
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card" style="width: 15rem;">
                <div class="card-header">
                    <strong>Monthly payment</strong>
                </div>
                <ul class="list-group list-group-flush">

                    <li class="list-group-item"><strong>Tenant:</strong> {{$financial->id }} - {{$financial->user->full_name}}</li>
                    
                    <li class="list-group-item"><strong>Room:</strong> {{$financial->room->room_no}}</li>

                    <li class="list-group-item"><strong>Room type:</strong> {{$financial->room->type}}</li>

                    <li class="list-group-item"><strong>Room Price:</strong> {{number_format($financial->room->roomRate(),2)}}</li>

                    <li class="list-group-item"><strong>Amenities availed:</strong><br> @foreach($occupantA as $occupant)
                        {{$occupant->amen_name}} - {{$occupant->rate}}<br>
                    @endforeach    
                    </li>

                    <li class="list-group-item"><strong>Total amenities price:</strong> {{$occupantT}} </li>

                </ul>
            </div>
            <hr> 
            <h4>
                Total monthly due: {{number_format( $financial->room->roomRate() + $occupantT,2)}}
            </h4> 
        </div>

        <div class="col-md-9">
            <table class="table table-striped">
                <thead class="bg-dark text-white">
                    <tr>
                        <th scope="col">Trans date</th>
                        <!-- <th scope="col">From</th>
                        <th scope="col">To</th> -->
                        <!-- <th scope="col">Payment for</th> -->
                        <th scope="col">Remarks</th>
                        <th scope="col">Status</th>
                        <th scope="col">Debit</th>
                        <th scope="col">Credit</th>
                        <!-- <th scope="col">Balance</th> -->
                    </tr>
                </thead>
                <tbody>
                    @foreach($occupanter as $occupante)
                    <tr>
                        <td>{{\Carbon\Carbon::parse($occupante->created_at)->format("F j Y")}}</td>
                        <!-- <td>{{\Carbon\Carbon::parse($occupante->payment_for)->format("F j Y")}}</td>   -->
                        <td>{{$occupante->remarks}}</td>
                        <td>{{$occupante->status}}</td>
                        <td class="text-right">{{$occupante->formatDebit()}}</td>
                        <td class="text-right">{{$occupante->formatCredit()}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
           @if(number_format($balance,2) < 0)
           <div class="row">
            <div class="col-md-4">
            <div class="alert alert-danger" role="alert">
                <strong>Total balance: {{number_format($balance,2)}}</strong>
            </div>
            </div>
           </div>
           @else
            <strong>Total balance: {{number_format($balance,2)}}</strong>
           @endif
        </div>
    </div>
</div>
@endsection