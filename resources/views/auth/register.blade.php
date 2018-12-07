@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-2">
        <div class="col-md-3 m-auto">
            <a href="/"><img class="rounded mx-auto d-block" src="{{ asset('images/logo.png') }}" alt="Card image cap"></a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-7 m-auto">
            <div class="card">
                <div class="card-header">
                    <strong>Sign up</strong>
                </div>
                <div class="card-body">
                    @include('success')
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="firstname"><strong>First name</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter first name" maxlength="25" required="" value="{{ old('firstname') }}" autofocus="">
                                @if($errors->has('firstname'))
                                <span class="help-block">
                                        <strong><span class="text-danger">{{ $errors->first('firstname') }}</span></strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-6">
                                <label for="lastname"><strong>Last name</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter last name" maxlength="25" required="" value="{{ old('lastname') }}">
                                @if($errors->has('lastname'))
                                <span class="help-block">
                                        <strong><span class="text-danger">{{ $errors->first('lastname') }}</span></strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"><strong>Email address</strong><span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter email address" value="{{ old('email') }}" required=""> 
                            @if($errors->has('email'))
                            <span class="help-block">
                                    <strong><span class="text-danger">{{ $errors->first('email') }}</span></strong>
                            </span>
                            @endif

                        </div>

                        <div class="form-group {{ $errors->has('contact_no') ? ' has-error' : '' }}">
                            <label for="contact_no"><strong>Contact Number</strong><span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="contact_no" id="contact_no" placeholder="+63" required="" value="{{ old('contact_no') }}">
                            @if($errors->has('contact_no'))
                            <span class="help-block">
                                    <strong><span class="text-danger">{{ $errors->first('contact_no') }}</span></strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="dob"><strong>Date of birth</strong><span class="text-danger">*</span></label>
                            <input type="date" class="form-control" min="1970-01-01" max="2004-12-30" id="dob" name="dob" required="" value="{{ old('dob') }}">
                            @if($errors->has('dob'))
                            <span class="help-block">
                                    <strong><span class="text-danger">{{ $errors->first('dob') }}</span></strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="street_ad"><strong>Street Address</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="street_ad" name="street_ad" placeholder="1234 Main St" maxlength="50" required="" value="{{ old('street_ad') }}">
                                @if($errors->has('street_ad'))
                                <span class="help-block">
                                        <strong><span class="text-danger">{{ $errors->first('street_ad') }}</span></strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="city"><strong>City/Town</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="city" name="city" placeholder="city" maxlength="25" required="" value="{{ old('city') }}">
                                @if($errors->has('city'))
                                <span class="help-block">
                                        <strong><span class="text-danger">{{ $errors->first('city') }}</span></strong>
                                </span>
                                @endif
                            </div>

                            <div class="form-group col-md-3">
                                <label for="province"><strong>Province</strong><span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="province" name="province" placeholder="province" maxlength="25" required="" value="{{ old('province') }}">
                                @if($errors->has('province'))
                                <span class="help-block">
                                        <strong><span class="text-danger">{{ $errors->first('province') }}</span></strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="username"><strong>Username</strong></label>
                            <input id="username" type="text" class="form-control" name="username" placeholder="Enter username" required=""> 
                            @if($errors->has('username'))
                            <span class="help-block">
                                    <strong><span class="text-danger">{{ $errors->first('username') }}</span></strong>
                            </span>
                            @endif
                        </div>

                        <div class="form-group">
                            <div class="form-row">
                                <div class="col-md-6">
                                    <label for="exampleInputPassword1"><strong>Password</strong></label>
                                    <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Enter password" required=""> 
                                    @if($errors->has('password'))
                                    <span class="help-block">
                                            <strong><span class="text-danger">{{ $errors->first('password') }}</span></strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="col-md-6">
                                    <label for="confirmpassword"><strong>Password confirmation</strong></label>
                                    <input type="password" class="form-control" name="password_confirmation" id="confirmationpassword" placeholder="Enter password confirmation" required="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-info btn-block"><i class="fas fa-sign-in-alt"></i> Sign up</button>
                        </div>

                        <div class="form-group text-center">
                            <span class="text-center ">Already have an account?</span><a href="{{ route('login') }}"> Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>
@endsection
