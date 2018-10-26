@extends('jf::layouts.default')


@section('toolbar')
	<h1>Formulieren</h1>
@endsection


@section('content')



	<div class="container">

		<div class="row">
			<div class="col-xs-12 text-right">
				@if (JellyPreferences::key('forms_send_sms') != 'true')
					<b style="color:#919191;">SMS Notificaties uitgeschakeld.</b>
				@else
					<b>SMS notificaties ingeschakeld voor<br><small>{{ JellyPreferences::key('forms_sms_numbers') }}</small></b>
				@endif
			</div>
			<br><br><br>
		</div>

		

		<div class="panel panel-default">
			<div class="panel-heading">
				Alle ingevulde formulieren.
			</div>
			<table class="table table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<td>#</td>
						<td>Type</td>
						<td>Eerste resultaat</td>
						<td align="right" width="150">Ingevuld op</td>
						<td align="right" width="150"></td>
					</tr>
				</thead>
				<tbody>
					@foreach($list as $data)
					<tr>
						<td>{{ $data->id }}</td>
						<td>{{ $data->type }}</td>
						<td>{{ str_limit($data->data[key($data->data)],25,'...') }}</td>
						<td align="right">{{Carbon::parse($data->created_at)->format('d-m-Y H:i')}}</td>
							<td align="right">
								<a href="{{route('jelly-form',[$data->id])}}" class="btn btn-default btn-xs"><i class="fa fa-eye" aria-hidden="true"></i> Weergeven</a>
							</td>
					</tr>	
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@endsection