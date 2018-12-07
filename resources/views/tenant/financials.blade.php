@extends('tenant.app')

@section('content')
@if(count($occupant)>0)
<div class="container">
	<div class="row mb-5">
		<div class="col">
			<h1 class="text-center">Tenant Ledger</h1>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4">
			<div class="card" style="width: 15rem;">
                <div class="card-header">
                    <strong>Monthly payment</strong>
                </div>
                <ul class="list-group list-group-flush">

                	<li class="list-group-item"><strong>User Id:</strong> {{$occupant->user->id}} <strong>Occupant Id:</strong> {{$occupant->id}}</li>

                    <li class="list-group-item"><strong>Name:</strong> {{$occupant->user->full_name}}</li>

                    <li class="list-group-item"><strong>Room type:</strong> {{$occupant->room->type}}</li>

                    <li class="list-group-item"><strong>Price:</strong> {{number_format($occupant->room->roomRate(),2)}}</li>

                    
                    <li class="list-group-item"><strong>Amenities availed:</strong><br> @foreach($occupantA as $occup)
                    	{{$occup->amen_name}} - {{$occup->rate}}
                    	@endforeach
                    </li>

                    <li class="list-group-item"><strong>Total Amenities Price:</strong> {{$occupantASum}}</li>
                    
                </ul>
            </div>
            <br> 
            <h4>
                Total monthly due: <strong>{{number_format($occupantASum + $occupant->room->roomRate(),2)}}</strong>
            </h4> 
		</div>
		<div class="col-md-8">
			<table class="table table-responsive">
			  <thead class="thead-dark">
			    <tr>
			      <th scope="col">Trans date</th>
			      <th scope="col">Status</th>
			      <th scope="col">Remarks</th>
			      <th scope="col">Debit</th>
			      <th scope="col">Credit</th>
			      <!-- <th scope="col">Balance</th> -->
			    </tr>
			  </thead>
			  <tbody>
			  @if(count($financials)>0)
				@foreach($financials as $financial)
			    <tr>
			      <td>{{\Carbon\Carbon::parse($financial->created_at)->toFormattedDateString()}}</td>
			      <td>{{$financial->status}}</td>
			      <td>{{$financial->remarks}}</td>
			      <td>{{$financial->debit}}</td>
			      <td>{{$financial->credit}}</td>
			      <!-- <td>{{number_format($financial->balance(),2)}}</td> -->
			    </tr>
			    @endforeach
			  @else
			  	No Bills
			  @endif
			  </tbody>
			</table>
			@if(number_format($balance,2) < 0 )
			<div class="row">
            <div class="col-md-4">
            <div class="alert alert-danger" role="alert">
            	<strong>Total balance: {{number_format(abs($balance),2)}}</strong>
           	</div>
           	</div>
       		</div>
			
			@else
			<strong>Total balance: {{number_format($balance,2)}}</strong>
			@endif
		</div>
	</div>
</div>
@else
	<h2 class="text-center">You are not yet a Occupant. please contact the boarding house to Check in</h2>
@endif
@endsection