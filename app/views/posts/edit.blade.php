@extends('master')
@section('header')
	<a href="{{('/posts/'.$post->id.'')}}">&larr; Cancel </a>
	<h2>
		@if($method == 'post')
			Add a new post
		@elseif($method == 'delete')
			Delete {{$post->content}}?
		@else
			Edit {{$post->content}}
		@endif
	</h2>
@stop

@section('content')
	{{Form::model($post, array('method' => $method, 'url'=>'posts/'.$post->id))}}
		@unless($method == 'delete')
			{{ Form::hidden('user_id', Auth::user()->id) }}
			<div class="form-group">
				{{Form::label('Privacy')}}
				{{Form::select('privacy_id', $privacy_options)}}
			</div>
			<div class="form-group">
				{{Form::label('Content')}}
				{{Form::text('content')}}
			</div>
			<div class="form-group">
				{{Form::label('Category')}}
				{{Form::select('category_id', $category_options)}}
			</div>
			<div class="form-group">
				{{Form::label('Tags (separated by commas)')}}
				{{Form::text('tags')}}
			</div>
			<div class="form-group">
				{{Form::label('Anonymous')}}
				{{ Form::checkbox('anonymous') }}
			</div>

			{{Form::submit("Save", array("class"=>"btn btn-default"))}}
		@else
			{{Form::submit("Delete", array("class"=>"btn btn-default"))}}
		@endif
	{{Form::close()}}
@stop
