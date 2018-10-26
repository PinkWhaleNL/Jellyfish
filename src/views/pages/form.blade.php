@extends('jf::layouts.default')

@section('toolbar')
	<h1>Formulier resultaat</h1>
@endsection

@section('content')
<div class="container">
		<div class="col-md-8 col-md-offset-2">
			<a href="{{ route('jelly-forms') }}" class="btn btn-primary btn-xs">Terug</a><br>
			<br>
			<div class="panel panel-default">
				<div class="panel-heading">
					Formulier ingevuld op: {{ $form->created_at }}
				</div>
				<table class="table table-condensed table-bordered table-striped">
					<tr>
						<td width="200">#</td><td>{{ $form->id }}</td>
					<tr>
						<td>Type</td><td>{{ $form->type }}</td>
					</tr>
					@foreach($form->data as $key=>$item)
					<tr>
						<td>{{ ucfirst($key) }}</td>
						<td>{{ $item }}</td>
					</tr>
					@endforeach
					<tr>
						<td>Ingevuld op</td>
						<td>{{ Carbon::parse($form->created_at)->format('d-m-Y H:i:s') }}</td>
					</tr>
				</table>
			</div>
		</div>
	</div>
</div>
@endsection