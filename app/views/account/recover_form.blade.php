@extends('master')

@section('content')
	{{Form::open(array('class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Password Recovery</h2>
		{{ Form::password('password',   ['placeholder'=>'Password', 'class' => 'input-block-level']) }}
		@if($errors->has('password'))
			<div class="alert alert-danger">{{$errors->first('password')}}</div>
		@endif
		
		{{ Form::password('password_confirmation', ['placeholder'=>'Password Confirmation', 'class' => 'input-block-level']) }}
		@if($errors->has('password_confirmation'))
			<div class="alert alert-danger">{{$errors->first('password_confirmation')}}</div>
		@endif
		{{ Form::submit('Save', array('class' => 'btn btn-large btn-primary'))}}
	{{Form::close()}}
	
@stop