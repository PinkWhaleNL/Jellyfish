@extends('jf::layouts.default')

@section('toolbar')
	<h1>Module: {{$data->type??null}}</h1>
@endsection

@section('content')
	<style type="text/css" media="screen">
		#editor {
			height:600px;
		}
	</style>
	<div class="container">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="col-xs-12 text-right">
					<form action="" method="post">
						<div class="form-group text-left">
							<label>Title</label>
							<input type="text" class="form-control" name="title" value="{{old('title')??($data->title??null)}}"/><br>
						</div>
						<div class="checkbox text-left">
							<label>
								<input type="checkbox"
								       {{old('sortable') == true ? ' checked ' : (isset($data->sortable) && $data->sortable == true ? ' checked ' : null)}}
								       name="sortable"
								       value="true" /> Documenten moeten sorteerbaar zijn.
							</label>
						</div>
						<div class="checkbox text-left">
							<label>
								<input type="checkbox"
								       {{old('publish_date') == true ? ' checked ' : (isset($data->publish_date) && $data->publish_date == true ? ' checked ' : null)}}
								       name="publish_date"
								       value="true" /> Documenten beschikken over een publicatie datum.
							</label>
						</div><br>
						<div class="form-group text-left">
							<label>Type (Unique)</label>
							<input type="text" class="form-control" name="type" value="{{old('type')??($data->type??null)}}"/><br>
						</div>
						{{csrf_field()}}
						<div id="editor"></div>
						<br>
						<textarea id="json_area" name="json" class="hidden">{{old('json')??json_encode($data->data??'{}')}}</textarea>
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
						var FromEditor = editor.getSession().getValue();
						//var ToString = JSON.stringify(FromEditor);
						var NewValue = FromEditor.replace(/(\r\n|\n|\r)/gm, '').replace(/\s+/g," ");
						$('textarea[name=json]').val(NewValue);
					});

					function prettyPrint() {
						var ugly = document.getElementById('json_area').value;
						var obj = JSON.parse(ugly);
						var pretty = JSON.stringify(obj, undefined, 4);
						document.getElementById('json_area').value = pretty;
						editor.setValue(pretty);
					}

					prettyPrint();

				</script>
				<!-- END -->
			</div>
		</div>
	</div>

@endsection