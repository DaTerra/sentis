@extends('master')

@section('content')
	
	{{Form::open(array('method'=>'delete',  'class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Delete Post?</h2>
		
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
	      		<img style="width:80%" src="{{{$post->postContent['media_url']}}}"/>
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

      	{{ Form::submit('Delete', array('class' => 'btn btn-large btn-primary'))}}
	</div>	
	{{Form::close()}}
	
@stop