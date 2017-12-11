@extends('jf::layouts.default')

@section('toolbar')
	<h1>Mediabeheer</h1>
@endsection

@section('buttons')
	<li><a class="btn btn-default btn-sm" href="{{route('jelly-media-show',['new'])}}"><i class="fa fa-upload fa-fw" aria-hidden="true"></i><span class="hidden-xs">Upload</span></a></li>

	<li>|</li>

	<li>
		<div class="btn-group">
			<a href="{{route('jelly-media')}}" class="btn btn-default btn-sm"><i class="fa fa-filter fa-fw" aria-hidden="true"></i></a>
			<a class="btn btn-{{$filter == 'attachment' ? 'primary' : 'default' }} btn-sm" href="{{route('jelly-media-files')}}">
				<span class="hidden-xs">Bestanden</span>
			</a>
			<a class="btn btn-{{$filter == 'picture' ? 'primary' : 'default' }} btn-sm" href="{{route('jelly-media-pictures')}}">
				<span class="hidden-xs">Afbeeldingen</span>
			</a>
		</div>
	</li>
@endsection

@section('content')
	<div class="container">



		<div class="panel panel-default">
			<div class="panel-heading">
				Alle bestanden binnen dit platform.
			</div>
			<table class="table table-bordered table-striped">
				<thead>
					<tr>
					 	<td align="left">Voorbeeld</td>
					 	<td>Titel</td>
					 	<td>Laatst aangepast</td>
						<td></td>
					</tr>
				</thead>
				<tbody>
					@if(count($list??[]) == 0)
					<tr>
						<td align="center" colspan="4"><small style="color:#919191;">Je hebt nog geen media.</small></td>
					</tr>
					@endif
					@foreach($list??[] as $item)
					<tr class="middle">
						<td align="left">
							@if($item->type == 'picture')
							<img height="80" src="{{route('img',[$item->id,'fit=90x70'])}}" alt="{{$item->title}}" title="{{$item->title}}"/>
							@else
							<img height="80" src="{{route('media-picture',['file_'.$item->filename])}}" alt="{{$item->title}}" title="{{$item->title}}"/>
							@endif
						</td>
						<td width="300">
							{{$item->title}}
							@if(isset($item->alert) && $item->alert == true)
								<br>
								<small style="float:left; color:orange; border-left:2px solid orange; padding-left:10px;">
									Deze afbeelding heeft een kleine resolutie! Gebruik deze afbeelding alleen bij kleine toepassingen, niet als banners.
								</small>
							@endif
						</td>
						<td>{{$item->updated_at}}</td>
						<td align="right">
							<a href="#" class="btn btn-default btn-xs">Titel aanpassen</a>
							<form action="{{route('jelly-media-remove',[$item->id])}}" method="post" style="display:inline">
								{{csrf_field()}}
								<button class="btn btn-danger btn-xs" onclick="return confirm('Verwijderen?')"><i class="fa fa-trash-o" aria-hidden="true"></i> Verwijderen</button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
			<div class="panel-footer">
				<small><i class="fa fa-hdd-o" aria-hidden="true"></i> {{$storage_size}}.</small>
			</div>
		</div>
	</div>
@endsection