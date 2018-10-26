@include('jf::partials.copyright')
<!DOCTYPE html>
<html lang="nl">
<head>

	<title>{{config('jf.title_browser')}}</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link href="{{ asset('vendor/jellyfish/css/jelly_default.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('apple-touch-icon.png')}}" rel="apple-touch-icon">
	<meta name="apple-mobile-web-app-status-bar-style" content="black"/>
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="robots" content="noindex, nofollow" />
</head>
<body>
	<nav class="navbar navbar-default">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="#">{{config('jf.title')}}</a>
			</div>
			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav">
					<li{{in_array(request()->route()->getName(),['jelly-dashboard'])?' class=active':null}}><a href="{{route('jelly-dashboard')}}">Dashboard</a></li>
					<li{{in_array(request()->route()->getName(),['jelly-translations','jelly-translation-create','jelly-translation'])?' class=active':null}}><a href="{{route('jelly-translations')}}">Vertalingen</a></li>
					<li{{in_array(request()->route()->getName(),['jelly-media'])?' class=active':null}}><a href="{{route('jelly-media')}}">Media</a></li>
					<li{{in_array(request()->route()->getName(),['jelly-forms'])?' class=active':null}}><a href="{{route('jelly-forms')}}">Formulieren</a></li>


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
								<li><a href="{{route('jelly-admin-users')}}"><b>Admin - </b>Beheer gebruikers</a></li>
							<li><a href="{{route('jelly-admin-types')}}"><b>Admin - </b>Modules</a></li>
							<li><a href="{{route('jelly-admin-preferences')}}"><b>Admin - </b>Instellingen</a></li>
							@endif
							<li role="separator" class="divider"></li>
							<li><a href="{{route('jelly-logout')}}">Uitloggen</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
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
	<script src="{{ asset('vendor/jellyfish/js/jelly_default.js') }}"></script>
	@if(session()->has('message'))
	<script type="text/javascript">
		swal("{{session('message')['message']}}","", "{{session('message')['state']}}");
	</script>
	@endif
	<footer class="col-xs-12 text-center" style="color:#666; font-size:11px;"><br>
		<a href="{{url(config('jf.footer_url'))}}" style="color:#919191" target="_blank"><small>{{config('jf.footer_company')}}</small></a>
	</footer>

	@yield('js')
</body>
</html>
