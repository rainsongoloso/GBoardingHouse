@extends('tenant.app')

@section('content')
@if(count($occupant)>0)
<div class="container">
	<div class="row">
		<div class="col-md-4">
			<div class="card" style="width: 15rem;">
                <div class="card-header">
                    <strong>Monthly payment</strong>
                </div>
                <ul class="list-group list-group-flush">

                	<li class="list-group-item">User Id: {{$occupant->user->id}} Occupant Id: {{$occupant->id}}</li>

                    <li class="list-group-item">Name: {{$occupant->user->full_name}}</li>

                    <li class="list-group-item">Room type: {{$occupant->room->type}}</li>

                    <li class="list-group-item">Price: {{number_format($occupant->room->roomRate(),2)}}</li>

                    @if($occupant->isNull())
                    <li class="list-group-item">Amenity availed: {{$occupant->amenity->amen_name}}</li>

                    <li class="list-group-item">Price: {{number_format($occupant->amenity->rate,2)}}</li>

                    @else
                    <li class="list-group-item">Amenity availed: None</li>

                    <li class="list-group-item">Price: None</li>
                    @endif
                </ul>
            </div>
            <hr> 
            @if($occupant->isNull())
            <h4>
                Total: <strong>{{number_format($occupant->amenity->rate + $occupant->room->roomRate(),2)}}</strong>
            </h4> 
            @else
            <h4>
                Total: <strong>{{number_format($occupant->room->roomRate(),2)}}</strong>
            </h4> 
            @endif
		</div>
		<div class="col-md-8">
			<table class="table table-responsive">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">Month</th>
			      <th scope="col">Status</th>
			      <th scope="col">Remarks</th>
			      <th scope="col">Debit</th>
			      <th scope="col">Credit</th>
			      <th scope="col">Balance</th>
			    </tr>
			  </thead>
			  <tbody>
			  @if(count($financials)>0)
				@foreach($financials as $financial)
			    <tr>
			      <td>{{$financial->payForFormat()}}</td>
			      <td>{{$financial->status}}</td>
			      <td>{{$financial->remarks}}</td>
			      <td>{{$financial->debit}}</td>
			      <td>{{$financial->credit}}</td>
			      <td>{{number_format($financial->balance(),2)}}</td>
			    </tr>
			    @endforeach
			  @else
			  	No Bills
			  @endif
			  </tbody>
			</table>
			<strong>Total balance: {{$balance}}</strong>
		</div>
	</div>
</div>
@else
	<h2 class="text-center">You are not yet a Occupant. please contact the boarding house to Check in</h2>
@endif
@endsection