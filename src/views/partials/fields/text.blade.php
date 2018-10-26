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
	<label style="margin-top:10px;">Slug</label>
	<input class="form-control" type="text" id="{{$value->name}}_slug" onkeyup="updateSlug()" name="{{ $value->name??null }}_slug" value="{{isset($old[$value->name.'_slug']) && !empty($old[$value->name.'_slug']) ? old($value->name.'_slug') : isset($db[$value->name.'_slug']) ? $db[$value->name.'_slug'] : null}}"/>
	<small class="help-block">Bewerk dit veldt alleen noodzakelijk, dit i.v.m. met SEO.</small>	
		@section('js')
		<script type="text/javascript">
			$( document ).ready(function() {

				function convertToSlug(Text) {
					return Text.toLowerCase().replace(/ +/g,'-');
				}

				$('input#{{$value->name}}_slug').on('input',function(){
					$('input#{{$value->name}}_slug').val(convertToSlug($(this).val()));
				})
			});
		</script>
		@endsection
	@endif

	{!! $errors->first($value->name, '<p class="help-block">:message</p>') !!}

</div>


