@extends('jf::layouts.default')

@section('toolbar')
	<h1>{{!isset($content->id) ? 'Nieuw document' : 'Berwerken van je document'}}</h1>
@endsection

@section('content')
<form action="" method="post">
	{{csrf_field()}}
	<div class="container">
		<div class="col-md-8 col-md-offset-2">


			<div class="panel panel-default">
				<div class="panel-heading">
					Standaard opties
				</div>
				<div class="panel-body">
					@if($data->sortable == true)
					<b>Rankschikken</b>
					<input type="number" class="form-control" name="sort" value="{{old('sort')??($row->sort??null)}}"/>
					<small style="color:#919191;">
						Je kunt documenten sorteren, dit zal op de website in volgorde worden getoond.
					</small>
					@endif
					@if($data->publish_date == true)
					{!! $data->sortable == true ? '<br><br>' : null !!}
					<b>(Publicatie) Datum</b>
					<input type="text" class="form-control datepicker" name="published_at" value="{{old('published_at')??($row->published_at??null)}}"/>
					<small style="color:#919191;">
						Dit document kan gesorteerd worden op datum en/of zal worden vertoond met een (publicatie) datum.
					</small>
					@endif
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					Document
				</div>
				<div class="panel-body">
					@foreach($data->data->fields as $key=>$value)
						@include('jf::partials.fields.'.$value->type)
					@endforeach
					<input type="submit" value="Save!"/>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection