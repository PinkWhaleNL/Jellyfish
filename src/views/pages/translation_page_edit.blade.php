@extends('jf::layouts.default')

@section('toolbar')
	<h1>Pagina <u>{{$page->title}}</u> bewerken.</h1>
@endsection

@section('content')



	<div class="container">

		<div class="row">
			<div class="col-md-12">

				@if(session()->has('alert'))
				<div class="panel panel-default">
					<div class="panel-body">
						<p class="alert alert-{{session('alert')['state']}}" style="margin-bottom:0px;">
							{{session('alert')['message']}}
						</p>
					</div>
				</div>
				@endif

				@if(JellyAuth::IsAdmin())
				<div class="panel panel-default">
					<div class="panel-body">
						<form action="{{route('jelly-translation-item',['new'])}}" method="post">
							{{csrf_field()}}
							<input type="hidden" value="{{$page->id}}" name="page_id">
							<div class="form-group{{ $errors->has('key') ? ' has-error' : ''}}">
								<label><b style="color:red;">[ADMIN]</b> Nieuwe key toevoegen.</label>
								<div class="input-group">
									<input type="text" name="key" class="form-control" required value="{{old('key')}}"/>
									<span class="input-group-btn">
								        <button class="btn btn-primary" type="submit">Toevoegen</button>
								      </span>
								</div><!-- /input-group -->

								<small style="color:grey">Bijvoorbeeld; title, subtitle etc.. (wordt een slug string)</small>
							</div>
						</form>
					</div>
				</div>
				@endif

				<div class="panel panel-default">
					<table class="table">
						<thead>
							<tr>
								@foreach(config('jf.translation_languages') as $lItem)
									<td>{{strtoupper($lItem)}}</td>
								@endforeach
								<td width="100"></td>
							</tr>
						</thead>
						<tbody>
							@if(count($rows??[]) == 0)
								<tr><td align="center" colspan="{{count(config('jf.translation_languages')??['nl']) + 1}}">
										<small>Er zijn nog geen vertalingen aangemaakt.</small></td></tr>
							@endif
							@foreach($rows??[] as $row)
							<tr>
								<td style="padding-bottom:0px;" colspan="{{count(config('jf.translation_languages')??['nl'])+1}}" align="left">
									<b><small>{{$page->key}}.{{$row->key}}</small></b>
								</td>
							</tr>
							<tr>
								<form action="{{route('jelly-translation-item',[$row->id])}}" method="post" style="display:inline">
									{{csrf_field()}}
								@foreach(config('jf.translation_languages')??['nl'] as $lItem)
								<td style="border-top:0px !important">
									<textarea rows="2" name="data[{{$lItem}}]" class="form-control input-sm">{{$row->language($lItem)}}</textarea>
								</td>
								@endforeach
								<td align="right" style="border-top:0px !important">
									<button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
								</form>
								@if(JellyAuth::IsAdmin())
								<form action="{{route('jelly-translation-item-remove',[$row->id])}}" method="post" style="display:inline">
									{{csrf_field()}}
									<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Verwijderen?')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>
								</form>
								@endif

								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
@endsection