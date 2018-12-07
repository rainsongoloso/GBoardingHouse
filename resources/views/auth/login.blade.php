
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-md-3 m-auto">
            <a href="/"><img class="rounded mx-auto d-block" src="{{ asset('images/logo.png') }}" alt="Card image cap"></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-5 m-auto">
            <div class="card">
                <div class="card-header">
                    <strong>Login</strong>
                </div>
                <div class="card-body">
                    <div>@include('success')</div>
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}"">
                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username"><strong>Username</strong></label>
                            <input id="username" type="text" class="form-control" name="username" placeholder="Enter username" value="{{ old('username') }}" autofocus=""> 
                            @if($errors->has('username'))
                            <span class="help-block">
                                <strong><span class="text-danger">{{ $errors->first('username') }}</span></strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                           
                                    <label for="password"><strong>Password</strong></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Enter Password"> 
                                    @if($errors->has('password'))
                                    <span class="help-block">
                                        <strong><span class="text-danger">{{ $errors->first('password') }}</span></strong>
                                    </span>
                                    @endif
                        </div>

                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-sign-in-alt"></i> Login</button>
                        <div class="form-group text-center">
                        <a class="btn btn-link" href="{{ route('password.request') }}"><span class="text-md"></span>
                            Forgot your password?
                        </a> 

                        </div>
                        <div class="form-group text-center"> 
                        Dont have an account?</span><a href="{{ route('register') }}"> Sign Up</a>
                        </div>
                    </form>
                </div>
                 
            </div>
            
            
        
        </div>
    </div>
</div>
<br>
@endsection
