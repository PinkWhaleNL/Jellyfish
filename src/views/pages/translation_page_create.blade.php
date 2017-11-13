@extends('jf::layouts.default')

@section('toolbar')
	<h1>Nieuwe pagina aanmaken.</h1>
@endsection

@section('content')



	<div class="container">

		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="post">
						{{csrf_field()}}
						<div class="form-group{{ $errors->has('title') ? ' has-error' : ''}}">
							<label>Titel van deze nieuwe pagina</label>
							<input type="text" name="title" class="form-control" required value="{{old('title')}}"/>
						</div>

						<div class="form-group{{ $errors->has('key') ? ' has-error' : ''}}">
							<label>Unieke Key</label>
							<input type="text" name="key" class="form-control" required value="{{old('key')}}"/>
							<small style="color:grey">Bijvoorbeeld; contact, over-ons, home etc..</small>
						</div>


						<input type="submit" value="Save!"/>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection