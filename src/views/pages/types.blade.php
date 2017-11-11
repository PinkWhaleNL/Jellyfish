@extends('jf::layouts.default')


@section('toolbar')
	<h1>Documents</h1>
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
						@foreach(array_slice($data->json()->fields,0,4) as $item)
					 	<td>{{$item->title}}</td>
						@endforeach
						<td align="right">Laatste update</td>
						<td align="right"></td>
					</tr>
				</thead>
				<tbody>
					@foreach($documents as $doc)
						<tr>
							<td>{{$doc->id}}</td>
							@foreach(array_slice($data->json()->fields,0,4) as $item)
								@php
									$name = $item->name;
									$content = (array)$doc->json();
								@endphp

								@if($item->type == 'markdown')
								<td>{{str_limit(strip_tags(Markdown::convertToHtml(($content[$name]??null))),40)}}</td>
								@elseif($item->type == 'media')
								<td>

								</td>
								@else
								<td>{{$content[$name]??null}}</td>
								@endif
							@endforeach
							<td align="right">{{Carbon::parse($doc->updated_at)->format('d-m-Y H:i')}}</td>
							<td align="right">
								Edit
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection