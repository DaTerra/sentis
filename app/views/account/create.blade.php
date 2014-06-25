@extends('master')

@section('content')
	{{Form::open(array('class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Please sign up</h2>
		
		{{Form::text('email', null,  ['placeholder'=>'Email', 'class' => 'input-block-level'])}}
		@if($errors->has('email'))
			<div class="alert alert-danger">{{$errors->first('email')}}</div>
		@endif
		
		{{Form::text('username', null,  ['placeholder'=>'Username', 'class' => 'input-block-level'])}}
		@if($errors->has('username'))
			<div class="alert alert-danger">{{$errors->first('username')}}</div>
		@endif
		
		{{ Form::password('password',   ['placeholder'=>'Password', 'class' => 'input-block-level']) }}
		@if($errors->has('password'))
			<div class="alert alert-danger">{{$errors->first('password')}}</div>
		@endif
		
		{{ Form::password('password_confirmation', ['placeholder'=>'Password Confirmation', 'class' => 'input-block-level']) }}
		@if($errors->has('password_confirmation'))
			<div class="alert alert-danger">{{$errors->first('password_confirmation')}}</div>
		@endif
		{{ Form::submit('Sign up', array('class' => 'btn btn-large btn-primary'))}}
		<a href="<?= Social::login('facebook') ?>">
		 	<img style="width:14%;" src="http://ottopilotmedia.com/wp-content/uploads/2012/07/facebook-icon.jpg">
		 </a>
	{{Form::close()}}
	
@stop