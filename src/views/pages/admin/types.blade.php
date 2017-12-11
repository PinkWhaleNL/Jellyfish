@extends('jf::layouts.default')

@section('toolbar')
	<h1>Alle modules</h1>
@endsection

@section('buttons')
	<li><a class="btn btn-default btn-sm" href="{{route('jelly-admin-type',['new'])}}"><i class="fa fa-plus fa-fw" aria-hidden="true"></i><span class="hidden-xs">Create new Module.</span></a></li>
@endsection

@section('content')

	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading">
				Modules
			</div>
			<table class="table table-striped">
				<thead>
					<tr>
						<td>ID</td>
						<td>Sorteren</td>
						<td>Type</td>
						<td>Titel</td>
						<td align="center">Regels in DB</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($types as $type)
					<tr>
						<td>{{$type->id}}</td>
						<td>{{$type->sortable == true ? 'Ja' : 'Nee'}}</td>
						<td>{{$type->type}}</td>
						<td>{{$type->title}}</td>
						<td align="center">{{$type->rows()}}</td>
						<td align="right">
							<a class="btn btn-default btn-xs" href="{{route('jelly-admin-type',[$type->id])}}">Aanpassen</a>
							<form action="{{route('jelly-admin-type-delete',[$type->id])}}" method="post" style="display:inline">
								{{csrf_field()}}
								<button type="submit" class="btn btn-danger btn-xs" title="Delete this type" onclick='return confirm("Verwijderen, weet je het zeker? Dit verwijderd ook alle bijhorende content paginas")'>Verwijder</button>
							</form>

						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

@endsection