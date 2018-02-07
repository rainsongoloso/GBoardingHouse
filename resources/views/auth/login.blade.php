<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="https://fonts.googleapis.com/css?family=Catamaran:900" rel="stylesheet">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="/css/loginForm.css" rel="stylesheet">
    <title>Login</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
<div class="container">
    <div class="row mt-4">
        <div class="col-md-8 text-center m-auto p-4 mt-5"><h1>Goloso Boarding house Login</h1></div>
    </div>

    <div class="row mt-3">
        <div class="col-md-5 col-md-offset-2 m-auto">
            <div class="card bg-light">

                <div class="card-header"><h4>Login<h4></div>

                <div class="card-body">
                @include('success')
                    <form method="POST" action="{{ route('login') }}">

                        {{ csrf_field() }}

                        <div class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
                            <label for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                               @if ($errors->has('username'))
                                   <div class="alert alert-danger mt-1">
                                    {{ $errors->first('username') }}
                                   </div>
                               @endif
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password">Password</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                            @if ($errors->has('password'))
                                <div class="alert alert-danger mt-1">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </div>
                            @endif
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-5">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card-footer bg-transparent">
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fa fa-sign-in"></i> Login
                                    </button>
                                </div>

                                    <div class="form-group col-md-5 ml-3">
                                        <a class="btn btn-link" href="{{ route('password.request') }}">
                                            Forgot Your Password?
                                        </a>
                                    </div>  
                                </div>
                            </div>

                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap.bundle.min.js')}}"></script> 
 
</body>
</html>
