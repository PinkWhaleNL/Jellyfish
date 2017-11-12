@include('jf::partials.copyright')
<!DOCTYPE html>
<html lang="nl">
<head>

	<title>Even inloggen a.u.b.</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('vendor/jellyfish/css/jelly_auth.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('apple-touch-icon.png')}}" rel="apple-touch-icon">
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="robots" content="noindex, nofollow" />
</head>
<body>

<div class="container">
	<div class="row">
		<div class="wrapper col-md-6 col-md-offset-3">
			<div class="row">
				<div class="right col-md-12">
					<h1>Login</h1>
					<form action="" method="post">
						{{csrf_field()}}
						<label>USERNAME</label>
						<input type="text" name="username" class="form-control" value=""/>
						<br>
						<label>PASSWORD</label>
						<input type="password" name="password" class="form-control" value=""/>
						<br>
						<input type="submit" value="Go!" class="btn btn-primary"/>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@yield('content')

<div class="col-xs-12 text-center">
	<br><small>{{exec('git describe --tags --abbrev=0')}}</small>
</div>
<script src="{{ asset('vendor/jellyfish/js/jelly_auth.js') }}"></script>

</body>
</html>
