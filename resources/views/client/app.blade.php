<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Catamaran:900" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
        @include('css-links')
        <!-- <link href="/css/design.css" rel="stylesheet"> -->
        <!-- <link href="/css/custom.css" rel="stylesheet"> -->

        <title>Goloso Boarding House</title>

</head>
<body>
    
    @include('client.navbar')

        @yield('content')

    @include('admin.layouts.footer')

    @include('js-links')

        @yield('scripts')
</body>
</html>
