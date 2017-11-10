@extends('jf::layouts.default')

@section('content')
	<style type="text/css" media="screen">
		#editor {
			height:600px;
		}
	</style>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-heading"><b>Type:</b> {{$data->type??null}}</div>
			<div class="panel-body">
				<div class="col-xs-12 text-right">
					<form action="" method="post">
						<div class="form-group text-left">
							<label>Title</label>
							<input type="text" class="form-control" name="title" value="{{old('title')??($data->title??null)}}"/><br>
						</div>
						<div class="form-group text-left">
							<label>Type (Unique)</label>
							<input type="text" class="form-control" name="type" value="{{old('type')??($data->type??null)}}"/><br>
						</div>
						{{csrf_field()}}
						<div id="editor">{{old('json')??($data->data??null)}}</div>
						<br>
						<textarea name="json" class="hidden">{{old('json')??($data->data??null)}}</textarea>
						<input type="submit" class="btn btn-primary" value="Opslaan"/>
					</form>
				</div>

				<!-- ONLY FOR ACE -->
				<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
				<script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js')}}" type="text/javascript" charset="utf-8"></script>
				<script>
					var editor = ace.edit("editor");
					editor.setTheme("ace/theme/monokai");
					editor.getSession().setMode("ace/mode/json");
					editor.getSession().on('change', function(){
						$('textarea[name=json]').val(editor.getSession().getValue());
					});
				</script>
				<!-- END -->
			</div>
		</div>
	</div>

@endsection