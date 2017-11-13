@extends('jf::layouts.default')


@section('toolbar')
	<h1>Vertalingen per pagina.</h1>
@endsection

@section('buttons')
	@if(JellyAuth::IsAdmin())
	<li><a class="btn btn-default btn-sm" href="{{route('jelly-translation-create',['new'])}}"><i class="fa fa-plus fa-fw" aria-hidden="true"></i><span class="hidden-xs">Maak een nieuwe pagina</span></a></li>
	@endif
@endsection

@section('content')

	<div class="container">

		<div class="panel panel-default">
			<div class="panel-heading">
				Kies eerst een pagina om de vertalingen te bewerken.
			</div>
			<table class="table table-bordered table-striped table-con2densed">
				<thead>
					<tr>
						<td>#</td>
						<td>Titel van pagina</td>
						<td>Key</td>
						<td>Laatste update</td>
						<td align="right"></td>
					</tr>
				</thead>
				<tbody>
					@if(count($pages) == 0)
					<tr><td align="center" colspan="5"><small>Er zijn nog geen pagina's aangemaakt.</small></td></tr>
					@endif

					@foreach($pages??[] as $page)
					<tr class="middle">
						<td>{{$page->id}}</td>
						<td>{{$page->title}}</td>
						<td>{{$page->key}}</td>
						<td>{{Carbon::parse($page->updated_at)->format('d-m-Y H:i')}}</td>
						<td align="right">
							<a href="{{route('jelly-translation',[$page->id])}}" class="btn btn-default btn-sm"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Beheer vertalingen</a>
							@if(JellyAuth::IsAdmin())
							<form action="{{route('jelly-translation-remove',[$page->id])}}" method="post" style="display:inline">
								{{csrf_field()}}
								<button class="btn btn-danger btn-sm" onclick="return confirm('Verwijderen, incl. alle vertalingen?')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
							</form>
							@endif
						</td>
					</tr>
					@endforeach

				</tbody>
			</table>
		</div>
	</div>
@endsection