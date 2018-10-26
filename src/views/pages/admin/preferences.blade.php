@extends('jf::layouts.default')

@section('toolbar')
	<h1>Instellingen</h1>
@endsection

@section('content')
	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-heading">
					Formulieren
				</div>
				<div class="panel-body">
					<div class="col-xs-12 text-right">
						<form action="" method="post">
							<div class="form-group text-left">
								<label>SMS notificatie sturen.</label>
								<select name="forms_send_sms" class="form-control">
									<option value="false">Nee</option>
									<option value="true"{{ isset($preferences['forms_send_sms']) && $preferences['forms_send_sms'] == "true" ? ' selected' : null }}>Ja</option>
								</select>
							</div>
							<div class="form-group text-left">
								<label>SMS server secret</label>
								<input type="text" class="form-control" name="forms_sms_key" value="{{ $preferences['forms_sms_key'] ?? null }}"/>
							</div>
							<div class="form-group text-left">
								<label>06 Nummers</label>
								<input type="text" class="form-control" name="forms_sms_numbers" value="{{ $preferences['forms_sms_numbers'] ?? null }}"/>
								<p class="help-block">Gebruik alleen nummers, scheiden met komma.</p>
							</div>
							{{csrf_field()}}
							<input type="submit" class="btn btn-primary" value="Opslaan"/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection