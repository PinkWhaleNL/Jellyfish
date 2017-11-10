@extends('jf::layouts.default')

@section('content')

	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				Test123
				<a href="{{route('jelly-admin-type',['new'])}}" class="btn btn-primary btn-xs pull-right">Add</a>
			</div>
			<div class="panel-body">
				<p>
					Beheer.
				</p>
			</div>
			<table class="table">
				<thead>
					<tr>
						<td>ID</td>
						<td>Type</td>
						<td>Title</td>
						<td>Rows</td>
						<td>Action</td>
					</tr>
				</thead>
				<tbody>
					@foreach($types as $type)
					<tr>
						<td>{{$type->id}}</td>
						<td>{{$type->type}}</td>
						<td>{{$type->title}}</td>
						<td>0</td>
						<td>
							<a href="{{route('jelly-admin-type',[$type->id])}}">Edit</a> |
							<form action="{{route('jelly-admin-type-delete',[$type->id])}}" method="post">
								{{csrf_field()}}
								<button type="submit" class="btn btn-danger btn-xs" title="Delete this type" onclick='return confirm("Confirm delete?")'>Verwijder</button>
							</form>

						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection