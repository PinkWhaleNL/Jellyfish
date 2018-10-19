<div class="form-group{{ $errors->has($value->name) ? ' has-error' : ''}}">

	<label for="{{$value->name}}">{{$value->title??null}} {!! isset($value->required) && $value->required == true ? '<span style="color:red;">*</span>':null !!}</label>

	<input type="text"
	       name="{{ $value->name??null }}"
	       class="form-control"
	       id="{{$value->name}}"
	       value="{{isset($old[$value->name]) && !empty($old[$value->name]) ? old($value->name) : isset($db[$value->name]) ? $db[$value->name] : null}}"
	       placeholder="{{$value->placeholder??null}}" {!! isset($value->required) && $value->required == true ? ' required':null !!}
	/>

	{{-- Check if user want to create slug from this field. --}}
	@if(isset($value->slug) && $value->slug == true && !isset($db[$value->name]))

		<small style="color:red">Pas op! Dit veld maakt een slug aan. Deze is nadien niet te veranderen i.v.m. SEO cq. vindtbaarheid.</small>
		<input type="hidden" id="{{$value->name}}_slug" onkeyup="updateSlug()" name="{{ $value->name??null }}_slug" value="{{isset($old[$value->name.'_slug']) && !empty($old[$value->name.'_slug']) ? old($value->name.'_slug') : isset($db[$value->name.'_slug']) ? $db[$value->name.'_slug'] : null}}"/>
		
		@section('js')
		<script type="text/javascript">
			$( document ).ready(function() {

				function convertToSlug(Text) {
					return Text.toLowerCase().replace(/[^\w ]+/g,'').replace(/ +/g,'-');
				}

				$('input#{{$value->name}}').on('input',function(){
					$('input#{{$value->name}}_slug').val(convertToSlug($(this).val()));
				})
			});
		</script>
		@endsection
	@else
	<p class="help-block"><strong>Je Slug:</strong> {{isset($old[$value->name.'_slug']) && !empty($old[$value->name.'_slug']) ? old($value->name.'_slug') : isset($db[$value->name.'_slug']) ? $db[$value->name.'_slug'] : null}}</p>
	@endif

	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}

</div>


