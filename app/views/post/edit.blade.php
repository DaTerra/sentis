@extends('master')

@section('content')
	
	{{Form::open(array('method' => 'put', 'class'=>'form-signin', 'enctype' => 'multipart/form-data'))}}
		<h2 class="form-signin-heading">Edit a Post</h2>
		
		{{Form::label('title', 'Title')}}
		{{Form::text('title', $post->postContent['title'],  ['placeholder'=>'Title', 'class' => 'input-block-level'])}}
		@if($errors->has('title'))
			<div class="alert alert-danger">{{$errors->first('title')}}</div>
		@endif
		
		{{Form::label('content', 'Content')}}
		{{ Form::textarea('content', $post->postContent['content'], ['placeholder'=>'Content', 'size' => '48x10', 'class' => 'input-block-level']) }}
		@if($errors->has('content'))
			<div class="alert alert-danger">{{$errors->first('content')}}</div>
		@endif
		
		{{Form::label('source_url', 'Source')}}
		{{Form::text('source_url', $post->postContent['source_url'],  ['placeholder'=>'Source', 'class' => 'input-block-level'])}}
		@if($errors->has('source_url'))
			<div class="alert alert-danger">{{$errors->first('source_url')}}</div>
		@endif
		
		{{Form::label('media', 'Media')}}
		@if($post->postContent['media_url'])
			<img style="width:80%" src="{{{$post->postContent['media_url']}}}"/>
		@endif
		
		</br></br>

		{{Form::file('media')}}
		@if($errors->has('media'))
			<div class="alert alert-danger">{{$errors->first('media')}}</div>
		@endif
		
		</br>
		
		{{ Form::submit('Save', array('class' => 'btn btn-large btn-primary'))}}
		<input type="checkbox" name="anonymous", id="anonymous" value="1" 
			@if($post->anonymous == 1)checked @endif />
		{{Form::label('anonymous', 'Post Anonymously?')}}

	{{Form::close()}}
	
@stop