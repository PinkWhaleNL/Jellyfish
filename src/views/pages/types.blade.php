@extends('jf::layouts.default')

@section('content')


	<div class="container">
		<div class="col-xs-12 text-right">
			<a class="btn btn-primary btn-xs" href="{{route('jelly-module',[$data->type,'new'])}}">Create new document.</a><br><br>
		</div>
	</div>
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