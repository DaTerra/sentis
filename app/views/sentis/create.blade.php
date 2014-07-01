@extends('master')

@section('content')

	{{Form::open(array('class'=>'form-signin', 'enctype' => 'multipart/form-data'))}}
		<h2 class="form-signin-heading">Leave you Sentis</h2>
        @foreach ($feelings as $feeling)
            {{Form::label($feeling->name, $feeling->name)}}
            {{Form::text($feeling->name, null,  ['placeholder'=>'Value', 'class' => 'input-block-level'])}}

            @if($errors->has($feeling->name))
                <div class="alert alert-danger">{{$errors->first($feeling->name)}}</div>
            @endif

		@endforeach

		{{ Form::submit('Create', array('class' => 'btn btn-large btn-primary'))}}

	{{Form::close()}}
@stop