<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-5">
		<a href="{{ url('admin')}}" class="navbar-brand">Admin</a>
		<button class="navbar-toggler" data-toggle="collapse" data-target="#navbarNav">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav">
				<li class="nav-item">
					<a href="{{ url('admin')}}" class="nav-link">Dashboard</a>
				</li>

				<div class="nav-item">
					<div class="dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>Manage</a>
						<div class="dropdown-menu">
							<a href="/reservations/index" class="dropdown-item"><i class="fa fa-book"></i> Reservations</a>
							<a href="/manage-rooms" class="dropdown-item"><i class="fa fa-bed"></i> Rooms details</a>
							<a href="/manage-amenities" class="dropdown-item"><i class="fa fa-rss"></i> Amenities</a>
							<a href="/manage-users" class="dropdown-item"><i class="fa fa-group"></i> Users</a>
						</div>	
					</div>
				</div>

				<!-- <li class="nav-item">
					<div class="dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Process</a>
							<div class="dropdown-menu">
								<a href="#" class="dropdown-item"><i class="fa fa-credit-card"></i> Process Billings</a>
								<a href="#" class="dropdown-item"><i class="fa fa-id-card"></i> Payments</a>
							</div>
					</div>	
				</li> -->

				<li class="nav-item">
					<a href="/process/billing" class="nav-link">Payments</a>
				</li>

				<li class="nav-item">
					<a href="/billing/index" class="nav-link">Billings</a>
				</li>
			
				<li class="nav-item">
					<div class="dropdown">
						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><span class="caret"></span>Generate Reports</a>
						<div class="dropdown-menu">
							<a href="/reports/monthly" class="dropdown-item">Monthly</a>
							<a href="/reports/occupancy" class="dropdown-item">Occupants</a>
						</div>	
					</div>
					
				</li>

			</ul>
		</div>	 

		<ul class="navbar-nav m-auto">
			<li class="nav-item dropdown mr-3">
				<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-user"></i> 
						@if(Auth::check())
							Welcome {{Auth::user()->username}}
						@endif
				</a>

				<div class="dropdown-menu">

					<a href="/" class="dropdown-item">
						<i class="fa fa-home"></i>
						Home 
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