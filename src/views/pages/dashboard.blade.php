@extends('jf::layouts.default')

@section('toolbar')
	<h1>Dashboard</h1>
@endsection

@section('content')
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-body">
				Binnenkort meer op dit scherm..<br>
				<br>
				<b>Ga naar;</b><br>
				&bull; <a href="{{route('jelly-media')}}">Mediabeheer</a><br>
				@foreach((new \Pinkwhale\Jellyfish\Models\Types)->all() as $type)
					&bull; <a href="{{route('jelly-modules',[$type->type])}}"><u>[Module]</u> - {{$type->title}}</a><br>
				@endforeach
			</div>
		</div>
	</div>
@endsection