@extends('master')

@section('content')
	{{Form::open(array('class'=>'form-signin', 'enctype' => 'multipart/form-data'))}}
		<h2 class="form-signin-heading">Avatar Upload</h2>
		{{Form::label('avatar', 'Avatar')}}
		{{Form::file('avatar')}}
		@if($errors->has('avatar'))
			<div class="alert alert-danger">{{$errors->first('avatar')}}</div>
		@endif
		{{ Form::submit('Upload', array('class' => 'btn btn-large btn-primary'))}}
	{{Form::close()}}
	
@stop