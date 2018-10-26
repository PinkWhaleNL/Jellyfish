<div class="form-group{{ $errors->has($value->name) ? ' has-error' : ''}}">
	<label for="{{$value->name}}">{{$value->title??null}} {!! isset($value->required) && $value->required == true ? '<span style="color:red;">*</span>':null !!}</label>
	<select class="form-control" name="{{ $value->name??null}}">
		@if(isset($value->options) && count($value->options)>0)
		@foreach($value->options as $sValue)
		<option {{ old($value->name) != null && old($value->name) == $sValue ? ' selected' : null }} 
		{{ isset($db[$value->name]) && $db[$value->name] == $sValue ? ' selected' : null }}>{{ $sValue }}</option>
		@endforeach
		@endif
	</select>
	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}
</div>