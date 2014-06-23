@extends('master')

@section('header')
	<a href="{{url('/')}}">Back to overview</a>
	@if (Auth::user() && Auth::user()->canEdit($post))
		<a href="{{url('posts/'.$post->id.'/edit')}}">
		<span class="glyphicon glyphicon-edit"></span> Edit
		</a>
		<a href="{{url('posts/'.$post->id.'/delete')}}">
			<span class="glyphicon glyphicon-trash"></span> Delete
		</a>
	@endif
	
@stop

@section('content')
	User: {{{$post->user->username}}} </br>
	Privacy: {{{$post->privacy->name}}} </br>
	Content: {{{$post->content}}} </br>
	Anonyomus: {{{$post->anonymous}}} </br>
@stop
