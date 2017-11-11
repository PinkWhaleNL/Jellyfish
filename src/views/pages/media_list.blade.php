@extends('jf::layouts.default')

@section('toolbar')
	<h1>Mediabeheer</h1>
@endsection

@section('buttons')
	<li><a class="btn btn-default btn-sm" href="{{route('jelly-media-show',['new'])}}"><i class="fa fa-upload fa-fw" aria-hidden="true"></i><span class="hidden-xs">Upload</span></a></li>
@endsection

@section('content')
	<div class="container">

		@if(session()->has('message'))
			<p class="alert alert-success">
				{{session('message')}}
			</p>
		@endif

		<div class="panel panel-default">
			<div class="panel-heading">
				All documents inside {{$data->title??null}}.
			</div>
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
					 	<td>test</td>
					 	<td>test</td>
					 	<td>test</td>
					 	<td>test</td>
					</tr>
				</thead>
				<tbody>
					@foreach($list??[] as $item)
					<tr>
						<td>{{$item->id}}</td>
						<td>{{$item->title}}</td>
						<td>{{$item->updated_at}}</td>
						<td>
							<a href="#">Titel aanpassen</a>
							<a href="#">Verwijderen</a>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection