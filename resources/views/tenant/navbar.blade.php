<nav class="navbar navbar-expand-sm mb-5 navbar-dark bg-primary">
    <a href="/client" class="navbar-brand">Tenant</a>
    <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a href="/client" class="nav-link">Dashboard</a>
            </li>
            <li class="nav-item">
                <a href="/tenant/financial" class="nav-link">View Bills</a>
            </li>
<!--              <li class="nav-item">
                <a href="/tenant/reservation" class="nav-link">Reservations</a>
            </li>
 -->        </ul>
    </div>

    <ul class="navbar-nav m-auto">
        <li class="nav-item dropdown mr-3">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-user"></i> @if(Auth::check()) Welcome {{Auth::user()->username}} @endif
            </a>

            <div class="dropdown-menu">
                <a href="/tenant/account" class="dropdown-item">
                    <i class="fa fa-home"></i> Account
                </a>

                <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>
            </div>
        </li>
    </ul>
</nav>