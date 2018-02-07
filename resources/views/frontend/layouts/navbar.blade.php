<nav class="navbar navbar-expand-lg navbar-default">
  <div class="container">
    <a href="/" class="navbar-brand"">Goloso Boarding House</a>
    <button class="navbar-toggler" data-toggle="collapse" data-target="#navNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navNavbar">

      <ul class="navbar-nav ml-auto" >

      <li class="nav-item active">
      <a href="/online/reservation" class="nav-link">Reserve A Room</a>
      </li>

      <li class="nav-item active">
      <a href="/galleries" class="nav-link">View Gallery</a>
      </li>
<!-- 
      <li class="nav-item active">
      <a href="" class="nav-link">Services</a>
      </li> -->

      <li class="nav-item active">
      <a href="/contactus" class="nav-link">Contact Us</a>
      </li>

      @guest
      <li class="nav-item active">
      <a href="{{ url('/login')}}" class="nav-link">Login</a>
      </li>
      </ul>
      @else     
      <div class="dropdown">
      <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
      @if(Auth::check())
        Welcome {{Auth::user()->username}}
      @endif
      </a>
        <div class="dropdown-menu">
      @if(Auth::user()->role == 'Admin')
        <a href="/admin" class="dropdown-item">Manage</a>
      @elseif(Auth::user()->role == 'Tenant')
        <a href="/client" class="dropdown-item">Home</a>
        <a href="/home" class="dropdown-item">Account</a>
      @else
        <a href="/client" class="dropdown-item">Manage Reservation</a>
      @endif
      <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
      Logout
      </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        {{ csrf_field() }}
        </form>
      </div> 
      </div>
      @endguest
    </div>
  </div>
</nav>
