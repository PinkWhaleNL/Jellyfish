@extends('jf::layouts.default')

@section('toolbar')
	<h1>Alle gebruikers</h1>
@endsection

@section('buttons')
	<li><a class="btn btn-default btn-sm" href="{{route('jelly-admin-user',['new'])}}"><i class="fa fa-plus fa-fw" aria-hidden="true"></i><span class="hidden-xs">Nieuwe gebruiker</span></a></li>
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
						<td>Naam</td>
						<td>Email</td>
						<td>Laatst geupdate</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@foreach($users as $user)
					<tr>
						<td>{{$user->id}}</td>
						<td>
							{{$user->name}}
							@if($user->rank == 'admin')
							<label class="label label-warning">Administrator</label>
							@endif
						</td>
						<td>{{$user->email}}</td>
						<td>{{Carbon::parse($user->updated_at)->format('d-m-Y H:i')}}</td>
						<td align="right">
							<a class="btn btn-default btn-xs" href="{{route('jelly-admin-user',[$user->id])}}">Aanpassen</a>
							<form action="{{route('jelly-admin-user-delete',[$user->id])}}" method="post" style="display:inline">
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