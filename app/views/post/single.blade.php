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
    <a href="{{url('sentis/'.$post->id.'/create')}}">
        <span class="glyphicon glyphicon-heart"></span> Sentis
    </a>
	
@stop

@section('content')
	<div class="form-signin">
    	
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
      		<label>Tags:</label>
      			@foreach ($post->tags as $tag)
                    <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
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
	<div class="form-signin">
		<h1>Sentis Report:</h1>
		@if (count($postFeelings) > 0)
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
			        @foreach($postFeelings as $feeling)
				        <tr>
				        	<td>{{{$feeling->feeling}}}</td>
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
