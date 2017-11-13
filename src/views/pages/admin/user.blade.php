@extends('jf::layouts.default')

@section('toolbar')
	<h1>{{isset($user->id)?$user->name:'Nieuwe gebruiker.'}}</h1>
@endsection

@section('content')
	<style type="text/css" media="screen">
		#editor {
			height:600px;
		}
	</style>
	<div class="container">
		<div class="col-md-6 col-md-offset-3">
			<div class="panel panel-default">
				<div class="panel-body">
					<div class="col-xs-12 text-right">
						<form action="" method="post">
							<div class="form-group text-left">
								<label>Naam</label>
								<input type="text" class="form-control" name="name" value="{{old('name')??($user->name??null)}}"/>
							</div>
							<div class="form-group text-left">
								<label>Emailadres</label>
								<input type="email" class="form-control" name="email" value="{{old('email')??($user->email??null)}}"/>
							</div>
							<div class="form-group text-left">
								<label>Wachtwoord</label>
								<input type="text"{{!isset($user->id)?' readonly':null}} class="form-control" name="password" value="{{!isset($user->id)?str_random(15):null}}"/>
							</div>
							<div class="form-group text-left">
								<label>Rang</label>
								<select name="rank" class="form-control">
									<option value="user"{{isset($user->id) && $user->rank == 'user' ? ' selected' : null}}>Standaard gebruiker</option>
									<option value="admin"{{isset($user->id) && $user->rank == 'admin' ? ' selected' : null}}>Administrator</option>
								</select>
							</div>
							{{csrf_field()}}
							<input type="submit" class="btn btn-primary" value="Opslaan"/>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

@endsection