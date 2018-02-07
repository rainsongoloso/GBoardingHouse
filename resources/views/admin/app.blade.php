<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('css-links')
        <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
        <title>Admin</title>
    </head>
<body>
 
    @include('admin.layouts.navbar')

        @yield('content')
    
    @include('admin.layouts.footer')

        @include('js-links')

    @yield('scripts')
</body>
</html>