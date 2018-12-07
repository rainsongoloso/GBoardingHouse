@extends('frontend.app')

@section('content')

<section id="showcase">
    
    <div id="myCarousel" class="carousel slide" data-ride="carousel">

        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
            <li data-target="#myCarousel" data-slide-to="3"></li>
        </ol>

        <div class="carousel-inner">

            <div class="carousel-item carousel-image-1 active">
                <div class="container">
                    <div class="carousel-caption d-none d-sm-block mb-5">
                        <h1 class="display-3">Reserve A Room</h1>
                        <p class="lead"></p>    
                        <a href="/online/reservation" class="btn btn-dark btn-lg">Reserve</a>                       
                    </div>
                </div>
            </div>

            <div class="carousel-item carousel-image-2">
                <div class="container">
                    <div class="carousel-caption d-none d-sm-block mb-5">
                        <h1 class="display-3">Gallery</h1>
                        <p class="lead"></p>    
                        <a href="/galleries" class="btn btn-dark btn-lg">View </a>                      
                    </div>
                </div>
            </div>

            <div class="carousel-item carousel-image-3">
                <div class="container">
                    <div class="carousel-caption d-none d-sm-block mb-5">
                        <h1 class="display-3">Login</h1>
                        <p class="lead"></p>    
                        <a href="/login" class="btn btn-dark btn-lg">Login</a>                  
                    </div>
                </div>
            </div>

            <div class="carousel-item carousel-image-4">
                <div class="container">
                    <div class="carousel-caption d-none d-sm-block  mb-5">
                        <h1 class="display-3">About Us</h1>
                        <p class="lead"></p>
                        <a href="contactus" class="btn btn-dark btn-lg">About Us</a>
                    </div>
                </div>
            </div>
            <a href="#myCarousel" data-slide="prev" class="carousel-control-prev">
                <span class="carousel-control-prev-icon"></span>
            </a>

            <a href="#myCarousel" data-slide="next" class="carousel-control-next">
                <span class="carousel-control-next-icon"></span>
            </a>
        </div>
    </div>

</section>

@endsection

