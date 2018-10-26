@extends('jf::layouts.default')


@section('toolbar')
	<h1>Documenten in {{ucfirst($data->type)}}</h1>
@endsection

@section('buttons')
	<li><a class="btn btn-default btn-sm" href="{{route('jelly-module',[$data->type,'new'])}}"><i class="fa fa-plus fa-fw" aria-hidden="true"></i><span class="hidden-xs">Create new document.</span></a></li>
@endsection

@section('content')

	<div class="container">

		<div class="panel panel-default">
			<div class="panel-heading">
				Alle beschikbare documenten binnen {{ucfirst($data->type)}}.
			</div>
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<td>#</td>
						@if($data->sortable == true)
						<td>Rangschikking</td>
						@endif
						@foreach(array_slice($data->data->fields??[],0,3) as $item)
					 	<td>{{$item->title??null}}</td>
						@endforeach
						<td align="right" width="150">Laatste update</td>
						<td align="right" width="150"></td>
					</tr>
				</thead>
				<tbody>
					@foreach($documents as $doc)
						<tr>
						
							<td>{{$doc->id}}</td>
							@if($data->sortable == true)
								<td align="center">{{$doc->sort}}</td>
							@endif
							@foreach(array_slice($data->data->fields,0,3) as $item)
								@php
									$name = $item->name;
									$content = (array)$doc->data;
								@endphp

									@if($item->type == 'markdown')
									<td>{{str_limit(strip_tags(Markdown::convertToHtml(($content[$name]??null))),40)}}</td>
									@elseif($item->type == 'media')
									@php
										$file = (new \Pinkwhale\Jellyfish\Models\Media)->where('id',($content[$name]??null))->first();
									@endphp
								<td>
									@if(isset($file->type)&&$file->type == 'picture')
										<img height="80" src="{{route('media-picture',['small_'.$file->filename])}}" alt="{{$file->title}}" title="{{$file->title}}"/>
									@elseif(isset($file->type)&&$file->type == 'attachment')
										<img height="80" src="{{route('media-picture',['file_'.$file->filename])}}" alt="{{$file->title}}" title="{{$file->title}}"/>
									@endif
								</td>
								@else
								<td>{{str_limit($content[$name]??null,60)}}</td>
								@endif
							@endforeach
							<td align="right">{{Carbon::parse($doc->updated_at)->format('d-m-Y H:i')}}</td>
							<td align="right">
								<a href="{{route('jelly-module',[$data->type,$doc->id])}}" class="btn btn-default btn-xs"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Aanpassen</a>
								<form action="{{route('jelly-content-remove',[$data->type,$doc->id])}}" method="post" style="display:inline">
									{{csrf_field()}}
									<button class="btn btn-danger btn-xs" onclick="return confirm('Verwijderen?')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection