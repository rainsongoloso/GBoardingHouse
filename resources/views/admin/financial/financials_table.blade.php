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

                    <li class="list-group-item">Tenant: {{$financial->id }} - {{$financial->user->full_name}}</li>
                    
                    <li class="list-group-item">Room: {{$financial->room->room_no}}</li>

                    <li class="list-group-item">Room type: {{$financial->room->type}}</li>

                    <li class="list-group-item">Price: {{number_format($financial->room->roomRate(),2)}}</li>

                    @if($financial->isNull())
                    <li class="list-group-item">Amenity availed: {{$financial->amenity->amen_name}}</li>

                    <li class="list-group-item">Price: {{number_format($financial->amenity->rate,2)}}</li>
                    @else
                    <li class="list-group-item">Amenity availed: None</li>

                    <li class="list-group-item">Price: None</li>
                    @endif

                </ul>
            </div>
            <hr> 
            @if($financial->isNull())
            <h4>
                Total: {{number_format($financial->amenity->rate + $financial->room->roomRate(),2)}}
            </h4> 
            @else
            <h4>
                Total: {{number_format($financial->room->roomRate(),2)}}
            </h4> 
            @endif
        </div>

        <div class="col-md-9">
            <table class="table table-bordered table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Trans date</th>
                        <!-- <th scope="col">From</th>
                        <th scope="col">To</th> -->
                        <th scope="col">Remarks</th>
                        <th scope="col">Status</th>
                        <th scope="col">Debit</th>
                        <th scope="col">Credit</th>
                        <th scope="col">Balance</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($occupanter as $occupante)
                    <tr>
                        <!-- <td> -->
                        <!-- @if($occupante->occupant->user->reservation != null)
                        {{$occupante->occupant->user->reservation->formatdate()}}
                        @else -->
                        <!-- {{$occupante->created_at}} -->
                        <!-- {{$occupante->occupant->formatCreated()}} -->
                        <!-- @endif -->
                        <!-- </td> -->
                        <!-- <td>{{$occupante->payForFormat()}}</td> -->
                        <td>{{\Carbon\Carbon::parse($occupante->created_at)->format("F j Y")}}</td>
                        <td>{{$occupante->remarks}}</td>
                        <td>{{$occupante->status}}</td>
                        <td>{{$occupante->formatDebit()}}</td>
                        <td>{{$occupante->formatCredit()}}</td>
                        @if(number_format($occupante->balance(),2) < 0)
                        <td><p class="text-danger">{{number_format(ABS($occupante->balance()),2)}}</p></td>
                        @else
                        <td>{{number_format($occupante->balance(),2)}}</td>
                        @endif
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