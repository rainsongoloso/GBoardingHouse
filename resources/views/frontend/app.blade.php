<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://fonts.googleapis.com/css?family=Catamaran:900" rel="stylesheet">
		<link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
		@include('css-links')
        <link href="/css/design.css" rel="stylesheet">
        <link href="/css/custom.css" rel="stylesheet">
		
        <title>Goloso Boarding House</title>
		
		<style type="text/css">
		section{
  		  background-color: #FFF !important;
		}
       	.carousel-image-1{
		  background:url({{ asset('images/pic1.jpg') }});
		  background-size: cover;
		}
		.carousel-image-2{
		  background:url({{ asset('images/pic2.jpg') }});
		  background-size: cover;
		}
		.carousel-image-3{
		  background:url({{ asset('images/pic3.jpg') }});
		  background-size: cover;
		}
		.carousel-image-4{
		  background:url({{ asset('images/pic4.jpg') }});
		  background-size: cover;
		}
		</style>
</head>
<body>
	
    @include('frontend.layouts.navbar')

    	@yield('content')

	@include('frontend.layouts.botbar')
	
	@include('js-links')

		@yield('scripts')
</body>
</html>
