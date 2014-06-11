@extends('master')

@section('header')
	<h2>
		Posts
	</h2>
@stop

@section('content')
	<table class="table table-striped">
		<thead>
	    	<tr>
	        	<th>#</th>
	          	<th>User</th>
			    <th>Privacy</th>
			    <th>Content</th>
			    <th>Category</th>
			    <th>Tags</th>
			    <th>Version</th>
			    <th>Anonymous</th>
	        </tr>
	    </thead>
	    <tbody>
	        @foreach($posts as $post)
		        <tr>
		        	<td><a href="{{url('posts/'.$post->id)}}">{{{$post->id}}}</a></td>
		          	<td>{{{$post->user->username}}}</td>
		          	<td>{{{$post->privacy->name}}}</td>
		          	<td>{{{$post->content}}}</td>
		          	<td>{{{$post->category->name}}}</td>
		         	<td>{{{$post->tags}}}</td>
		          	<td>{{{$post->version}}}</td>
		          	<td>{{{$post->anonymous}}}</td>
	        	</tr>
	        @endforeach
	    </tbody>
	</table>
	
	<a href="{{url('posts/create')}}" class="btn btn-primary pull-right">
		Add a new Post
	</a>
@stop