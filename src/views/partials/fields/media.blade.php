<div class="form-group{{ $errors->has($value->name) ? ' has-error' : ''}}" style="height:100px">

	<label for="{{$value->name}}">{{$value->title??null}} {!! isset($value->required) && $value->required == true ? '<span style="color:red;">*</span>':null !!}</label>

	@php
		$db = isset($old[$value->name]) && !empty($old[$value->name]) ? old($value->name) : isset($db[$value->name]) ? $db[$value->name] : null;
	@endphp

	@php
		$list = (new Pinkwhale\Jellyfish\Models\Media);
		if(isset($value->function) && in_array('picture',$value->function))
			$list = $list->where('type','picture');
		if(isset($value->function) && in_array('attachment',$value->function))
			$list = $list->where('type','attachment');
	@endphp

	<select name="{{$value->name??null}}"
			class="selectpicker form-control"
			placeholder="{{$value->placeholder??null}}" {!! isset($value->required) && $value->required == true ? ' required':null !!}
	>
		@if(!isset($value->required) || $value->required != true)
		<option value="none">No File</option>
		@endif



		@foreach($list->get() as $file)
			<option
				value="{{$file->id}}" data-live-search="true"
		        data-content="<img height=50 style=margin-right:10px align=left src='{{route('media-picture',[($file->type=='attachment'?'file_':'small_').$file->filename])}}'/> {{$file->title}} ({{Carbon::parse($file->updated_at)->format('d-m-Y')}}) {{$file->alert == true ? '<bR><small style=\'color:orange\'><b>[LETOP]</b> - Afbeelding is te klein voor grote toepassingen. (bv. Banners)</small>' : null}}"
		        {{$db == $file->id ? ' selected' : null}}
			>
	        </option>
		@endforeach



		<?php /*@foreach((new \App\Models\Files)->where('type','attachment')->get() as $file)
			<option{{$content->attachment_id == $file->id ? ' selected':null}} value="{{$file->id}}">{{$file->title}} ({{Carbon::parse($file->updated_at)->format('d-m-Y')}})</option>
		@endforeach*/?>
	</select>

	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}

</div>


