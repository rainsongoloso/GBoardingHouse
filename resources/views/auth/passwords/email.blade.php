@extends('layouts.app')

@section('content')
<div class="container">
        <div class="row">
        <div class="col-md-4"></div>
        <div class="col-md-4 col-md-offset-2">

            <div class="card">
                <div class="card-header"><strong>Resert Password</strong></div>
              <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email"><strong>E-Mail Address</strong></label>
                            
                            <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                            @if($errors->has('email'))
                                <span class="help-block">
                                    <strong><span class="text-danger">{{ $errors->first('email') }}</span></strong>
                                </span>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-primary">
                        Send Password Reset Link
                        </button>
                    </form>
              </div>
            </div>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@endsection
