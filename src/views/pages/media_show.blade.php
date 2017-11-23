@extends('jf::layouts.default')

@section('toolbar')
	<h1>Bestand {{isset($data->id) ? 'bewerken' : 'uploaden'}}</h1>
@endsection

@section('content')

	<div class="container">

		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-body">
					<form action="" method="post" class="form-horizontal" enctype="multipart/form-data">
						{{csrf_field()}}

						<div class="form-group {{ $errors->has('title') ? 'has-error' : ''}}">
							<label class="col-md-4 control-label field-required">Omschrijving</label>
							<div class="col-md-8">
								<input type="text" name="title" class="form-control"/>
								{!! $errors->first('title', '<p class="help-block">:message</p>') !!}
								<p class="help-block">Voor SEO doeleinden en helpt je met het terugvinden van deze afbeelding in het mediabeheer.</p>
							</div>
						</div>

						@if($fileID == 'new')
							<div class="form-group {{ $errors->has('file') ? 'has-error' : ''}}">
								<label class="col-md-4 control-label field-required">Kies een bestand</label>
								<div class="col-md-8">
									<input type="file" name="file" class="form-control" value=""/>
									{!! $errors->first('file', '<p class="help-block">:message</p>') !!}
									<small style="color:red;">Gebruik afbeeldingen groter dan 800x700px!</small>
								</div>
							</div>
						@endif

						<div class="form-group">
							<label class="col-md-4"></label>
							<div class="col-md-8">
								<input type="submit" class="btn btn-primary btn-sm" value="{{isset($data->id)?'Opslaan':'Start upload!'}}"/>
							</div>
						</div>



					</form>
				</div>
			</div>
		</div>
	</div>
@endsection