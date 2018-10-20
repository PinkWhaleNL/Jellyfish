@if(!isset($value->function->module))
<b style="color:red">Error, no module set!</b>
@endif
<div class="form-group{{ $errors->has($value->name) ? ' has-error' : ''}}">

	<label for="{{$value->name}}">{{$value->title??null}} {!! isset($value->required) && $value->required == true ? '<span style="color:red;">*</span>':null !!}</label>

	<select name="{{$value->name??null}}" class="selectpicker form-control">
		@foreach(Jelly::module($value->function->module)->get() as $item)
			<option {{isset($db[$value->name]) && $db[$value->name] == $item->id ? ' selected' : null}} value="{{$item->id}}"> {{$item->data()->{$value->function->field} }}</option>
		@endforeach
	</select>
	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}
</div>