<div class="form-group{{ $errors->has($value->name) ? ' has-error' : ''}}">

	<label for="{{$value->name}}">{{$value->title??null}} {!! isset($value->required) && $value->required == true ? '<span style="color:red;">*</span>':null !!}</label>

	<input type="text"
	       name="{{$value->name??null}}"
	       class="form-control datepicker"

	       value="{{isset($old[$value->name]) && !empty($old[$value->name]) ? old($value->name) : isset($db[$value->name]) ? $db[$value->name] : null}}"
	       placeholder="{{$value->placeholder??null}}" {!! isset($value->required) && $value->required == true ? ' required':null !!}
	/>

	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}

</div>