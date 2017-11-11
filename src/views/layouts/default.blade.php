<!DOCTYPE html>
<html lang="en">
<head>

	<title>Jellyfish</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ mix('css/jelly_default.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('apple-touch-icon.png')}}" rel="apple-touch-icon">
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="robots" content="noindex, nofollow" />
</head>
<body>
<nav class="navbar navbar-default">
	<div class="container">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">JellyFish</a>
		</div>

		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			<ul class="nav navbar-nav">
				<li{{in_array(request()->route()->getName(),['dashboard'])?' class=active':null}}><a href="#">Dashboard</a></li>
				<li{{in_array(request()->route()->getName(),['jelly-media'])?' class=active':null}}><a href="{{route('jelly-media')}}">Media</a></li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Modules <span class="caret"></span></a>
					<ul class="dropdown-menu">
						@foreach((new \Pinkwhale\Jellyfish\Models\Types)->all() as $type)
							<li><a href="{{route('jelly-modules',[$type->type])}}">{{$type->title}}</a></li>
						@endforeach
					</ul>
				</li>
			</ul>
			<ul class="nav navbar-nav navbar-right">

				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">{{JellyAuth::user()->name}} <span class="caret"></span></a>
					<ul class="dropdown-menu">
						@if(JellyAuth::IsAdmin())
						<li role="separator" class="divider"></li>
						<li><a href="{{route('jelly-admin-types')}}"><b>Admin - </b>Modules</a></li>
						@endif
						<li role="separator" class="divider"></li>
						<li><a href="{{route('jelly-logout')}}">Uitloggen</a></li>
					</ul>
				</li>
			</ul>
		</div><!-- /.navbar-collapse -->
	</div><!-- /.container-fluid -->
</nav>

@if($__env->yieldContent('toolbar'))
<section id="toolbar">
	<div class="container">
		@yield('toolbar')
		<ul id="buttons" class="pull-right">
			@yield('buttons')
		</ul>
	</div>
</section>
@endif

<section id="content">
	@yield('content')
</section>

<div class="col-xs-12 text-center">
	<br><small>{{exec('git describe --tags --abbrev=0')}}</small>
</div>
<script src="{{ mix('js/jelly_default.js') }}"></script>

@if(session()->has('message'))
	<script type="text/javascript">
		swal("{{session('message')['message']}}","", "{{session('message')['state']}}");
	</script>
@endif


</body>
</html>
