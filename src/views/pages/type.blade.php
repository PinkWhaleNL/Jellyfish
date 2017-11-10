@extends('jf::layouts.default')

@section('content')

	<div class="container">

		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">
					Document
				</div>
				<div class="panel-body">
					<form action="" method="post">
						{{csrf_field()}}
						@foreach($data->json()->fields as $key=>$value)
							@include('jf::partials.fields.'.$value->type)
						@endforeach
						<input type="submit" value="Save!"/>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection