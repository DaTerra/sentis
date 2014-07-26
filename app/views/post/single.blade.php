@extends('master')

@section('content')
	<div class="page-header">
    	<a href="{{url('/')}}">
    		<span class="glyphicon glyphicon-arrow-left"></span> 
    		Back to overview
    	</a>
		@if (Auth::user() && Auth::user()->canEdit($post))
			<a href="{{url('posts/'.$post->id.'/edit')}}">
			<span class="glyphicon glyphicon-edit"></span> Edit
			</a>
			<a href="{{url('posts/'.$post->id.'/delete')}}">
				<span class="glyphicon glyphicon-trash"></span> Delete
			</a>
		@endif
	    <a href="{{url('sentis/'.$post->id.'/create')}}">
	        <span class="glyphicon glyphicon-heart"></span> Sentis
	    </a>
	</div>

	<div class="form-signin" style="float:left;width:49%;max-width:1200px;">
    	
		@if($post->postContent['title'])
	    	<div>
	    		<label>Title:</label>
	    		{{{$post->postContent['title']}}}
	    	</div>
	    @endif
      	
      	@if($post->postContent['content'])
	      	<div>
				<label>Content:</label>
	      		{{{$post->postContent['content']}}}
	      	</div>
	    @endif

	    @if($post->postContent['media_url'])
	      	<div>
	      		<label>Media:</label>
	      		<img style="width:80%;margin-bottom: 0px;" src="{{{$post->postContent['media_url']}}}"/>
	      	</div>
	    @endif
	     	
		@if($post->postContent['media']['type'])
			<div>
	      		<label>Media Type:</label>
	      		{{{$post->postContent['media']['type']}}}
	      	</div>
	    @endif
	    
	    @if($post->postContent['source_url'])  	
	      	<div>
	      		<label>Source:</label>
	      		{{{$post->postContent['source_url']}}}
	      	</div>
      	@endif
      	
		<div>
      		<label>Tags:</label>
      			@foreach ($post->tags as $tag)
                    <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
				@endforeach
      	</div>

      	<div>
      		<label>Public Tags:</label>
      			@foreach ($post->publicTags() as $tag)
                    <p>{{link_to_route('tags-page', $tag->name .' (' .$tag->qtd .') ',  $tag->id)}}</p>
				@endforeach
      	</div>

      	<div>
      		<label>Author:</label>
      		{{link_to_route('profile-user',$post->user->username,  $post->user->username)}}
      	</div>
      	<div>
      		<label>Privacy:</label>
      		{{{$post->privacy->name}}}
      	</div>
      	<div>
      		<label>Anonymous:</label>
      		{{{$post->anonymous}}}
      	</div>
      	<div>
      		<label>IP Address:</label>
      		{{{$post->user_ip_address}}}
      	</div>
	</div>	
	<div class="form-signin" style="float:right;width:49%;max-width:1200px;">
		<h1>Sentis Report:</h1>
		@if (count($post->feelings()) > 0)
			<table class="table table-striped">
				<thead>
			    	<tr>
			        	<th>Feeling</th>
			        	<th>Quantity</th>
			        	<th>Average</th>
			        	<th>Total</th>
			        </tr>
			    </thead>
			    <tbody>
			        @foreach($post->feelings() as $feeling)
				        <tr>
				        	<td>
				        	{{ link_to_route('feelings-page', $feeling->feeling, $feeling->id)}}</td>
				          	<td>{{{$feeling->feelings_left}}}</td>
				          	<td>{{{$feeling->feeling_avg}}}</td>
				          	<td>{{{$feeling->feeling_total}}}</td>
			        	</tr>
			        @endforeach
			    </tbody>
			</table>
		@else 
			<p>There are no sentis on this post.</p>
		@endif
	</div>
@stop
