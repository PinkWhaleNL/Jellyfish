@extends('jf::layouts.default')

@section('toolbar')
	<h1>{{!isset($content->id) ? 'Nieuw document' : 'Berwerken van je document'}}</h1>
@endsection

@section('content')
<form action="" method="post">
	{{csrf_field()}}
	<div class="container">
		<div class="col-md-8 col-md-offset-2">
			@if($data->sortable == true)
			<div class="panel panel-default">
				<div class="panel-heading">
					Rangschikken
				</div>
				<div class="panel-body">
					<input type="number" class="form-control" name="sort" value="{{old('sort')??($row->sort??null)}}"/>
					<small style="color:#919191;">
						Je kunt documenten sorteren, dit zal op de website in volgorde worden getoond.
					</small>
				</div>
			</div>
			@endif
			<div class="panel panel-default">
				<div class="panel-heading">
					Document
				</div>
				<div class="panel-body">
					@foreach($data->json()->fields as $key=>$value)
						@include('jf::partials.fields.'.$value->type)
					@endforeach
					<input type="submit" value="Save!"/>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection