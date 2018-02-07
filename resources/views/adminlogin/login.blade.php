<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Sign In</title>

	<link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>

	<div class="container">
			<div class="row mt-5 py-5">
				<div class="col-md-5 m-auto">
					<div class="card text-white bg-dark mb-3">
						<h4 class="card-header">Sign in</h4>
							<div class="card-body">
								<form action="adminlogined" method="POST">
								{{ csrf_field() }}

									<div class="form-group">
										<label for="username">Username</label>
										<input class="form-control" id="username" type="text" name="username" placeholder="Enter Username" required>
									</div>

									<div class="form-group">
										<label for="password">Password</label>
										<input class="form-control" id="password" type="password" name="password" placeholder="Password" required>
									</div>

									<button type="submit" class="btn btn-primary">Sign In</button>

								</form>
							</div>
						</div>
					</div>
				</div>
			</div>

	<script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/bootstrap.js') }}"></script>
</body>
</html>