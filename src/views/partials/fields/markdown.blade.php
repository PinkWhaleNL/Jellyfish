<div class="form-group{{ $errors->has($value->name) ? ' has-error' : ''}}">
	<label for="{{$value->name}}">{{$value->title??null}} {!! isset($value->required) && $value->required == true ? '<span style="color:red;">*</span>':null !!}</label>
	<textarea name="{{$value->name??null}}"
	          placeholder="{{$value->placeholder??null}}"
	          class="from-control"
	          id="md_{{$value->name??null}}"
	>{{isset($old[$value->name]) && !empty($old[$value->name]) ? old($value->name) : isset($db[$value->name]) ? $db[$value->name] : null}}</textarea>
	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.css">
<script src="https://cdn.jsdelivr.net/simplemde/latest/simplemde.min.js"></script>
<script>
	var simplemde = new SimpleMDE({ element: document.getElementById("md_{{$value->name??null}}") });
</script>


