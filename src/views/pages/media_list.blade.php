@extends('jf::layouts.default')

@section('toolbar')
	<h1>Mediabeheer</h1>
@endsection

@section('buttons')
	<li><a class="btn btn-default btn-sm" href="{{route('jelly-media',['new'])}}"><i class="fa fa-upload fa-fw" aria-hidden="true"></i><span class="hidden-xs">Upload</span></a></li>
@endsection

@section('content')
	<div class="container">

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
					<tr>
						<td>test</td>
						<td>test</td>
						<td>test</td>
						<td>test</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
@endsection