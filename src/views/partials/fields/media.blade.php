<div class="form-group{{ $errors->has($value->name) ? ' has-error' : ''}}" style="height:100px">

	<label for="{{$value->name}}">{{$value->title??null}} {!! isset($value->required) && $value->required == true ? '<span style="color:red;">*</span>':null !!}</label>

	<select name="{{$value->name??null}}"
			class="selectpicker form-control"
			placeholder="{{$value->placeholder??null}}" {!! isset($value->required) && $value->required == true ? ' required':null !!}
	>
		@if(!isset($value->required) || $value->required != true)
		<option value="none">No File</option>
		@endif

		@php
			$list = (new Pinkwhale\Jellyfish\Models\Media);
			if(isset($value->function) && in_array($value->function,['picture'])) $list = $list->where('type','picture');
			if(isset($value->function) && in_array($value->function,['file'])) $list = $list->where('type','attachment');
		@endphp

		@foreach($list->get() as $file)
			<option
					value="{{$file->id}}" data-live-search="true"
			        data-content="<img height=50 src='{{route('media-picture',[($file->type=='attachment'?'file_':'small_').$file->filename])}}'/> {{$file->title}} ({{Carbon::parse($file->updated_at)->format('d-m-Y')}})">{{$file->title}}
	        </option>
		@endforeach



		<?php /*@foreach((new \App\Models\Files)->where('type','attachment')->get() as $file)
			<option{{$content->attachment_id == $file->id ? ' selected':null}} value="{{$file->id}}">{{$file->title}} ({{Carbon::parse($file->updated_at)->format('d-m-Y')}})</option>
		@endforeach*/?>
	</select>

	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}

</div>


