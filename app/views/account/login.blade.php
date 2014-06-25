@extends('master')

@section('content')
	{{Form::open(array('class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Please sign in</h2>
		{{Form::text('username', null,  ['placeholder'=>'Username', 'class' => 'input-block-level'])}}
		@if($errors->has('username'))
			<div class="alert alert-danger">{{$errors->first('username')}}</div>
		@endif
		{{ Form::password('password',   ['placeholder'=>'Password', 'class' => 'input-block-level']) }}
		@if($errors->has('password'))
			<div class="alert alert-danger">{{$errors->first('password')}}</div>
		@endif
		{{Form::submit('Sign in', array('class' => 'btn btn-large btn-primary'))}}
		 <a href="<?= Social::login('facebook') ?>">
		 	<img style="width:14%;" src="http://ottopilotmedia.com/wp-content/uploads/2012/07/facebook-icon.jpg">
		 </a>
		<input type="checkbox" name="remember", id="remember"/>
		<label for="remember">
			Remember me
		</label>
		<br><br>
		{{link_to_route('account-forgot-password', 'Forgot Password')}} 
	{{Form::close()}}
	
@stop