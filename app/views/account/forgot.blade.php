@extends('master')

@section('content')
	{{Form::open(array('class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Password Recovery</h2>
		{{Form::text('email', null,  ['placeholder'=>'Email', 'class' => 'input-block-level'])}}
		@if($errors->has('email'))
			<div class="alert alert-danger">{{$errors->first('email')}}</div>
		@endif
		
		{{Form::submit('Recover', array('class' => 'btn btn-large btn-primary'))}}
	{{Form::close()}}
	
@stop