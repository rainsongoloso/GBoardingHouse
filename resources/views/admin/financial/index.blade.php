@extends('admin.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-3">Tenants Bills</h1>
    <hr>
    <div class="row">
        <div class="col-md-3">
            @include('success')
            <form action="/billing/financial_table" method="get" id="search-users-form">
                <div class="form-group">
                    <label for="occupant">Tenant bills</label>
                    <select class="custom-select" id="occupant" name="occupant" required>
                        <option value="0">Choose any...</option>
                        @foreach($occupants as $occupant)
                        <option value="{{$occupant->id}}">{{$occupant->id}} - {{$occupant->user->full_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary search-btn">Search</button>
                </div>
            </form>
        </div>
    </div>
    @yield('table')
    <hr>
</div>  


@endsection

