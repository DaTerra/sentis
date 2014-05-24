@extends('master')

@section('header')
	<a href="{{url('/posts')}}">Back to overview</a>
	<a href="{{url('posts/'.$post->id.'/edit')}}">
		<span class="glyphicon glyphicon-edit"></span> Edit
	</a>
	<a href="{{url('posts/'.$post->id.'/delete')}}">
		<span class="glyphicon glyphicon-trash"></span> Delete
	</a>
@stop

@section('content')
	User: {{{$post->user->username}}} </br>
	Privacy: {{{$post->privacy->name}}} </br>
	Content: {{{$post->content}}} </br>
	Category: {{{$post->category->name}}} </br>
	Tags: {{{$post->tags}}} </br>
	Version: {{{$post->version}}} </br>
	Anonyomus: {{{$post->anonymous}}} </br>
@stop
