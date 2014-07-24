@extends('master')
@section('content')
	<div class="page-header">
    	<a href="{{url('/')}}">Back to overview</a>
		@if (Auth::user() && Auth::user()->canEditTopic($topic))
			<a href="{{url('topics/'.$topic->id.'/edit')}}">
			<span class="glyphicon glyphicon-edit"></span> Edit
			</a>
			<a href="{{url('topics/'.$topic->id.'/delete')}}">
				<span class="glyphicon glyphicon-trash"></span> Delete
			</a>
		@endif
	</div>

	<div class="form-signin">
    	
		@if($topic->title)
	    	<div>
	    		<label>Title:</label>
	    		{{{$topic->title}}}
	    	</div>
	    @endif
      	
      	@if($topic->content)
	      	<div>
				<label>Content:</label>
	      		{{{$topic->content}}}
	      	</div>
	    @endif
		
	    <div>
	  		<label>Status:</label>
	  		{{{$topic->status}}}
  		</div>
	    
	    <div>
	  		<label>User:</label>
	  		{{{$topic->user->username}}}
  		</div>
		
		<div>
      		<label>Keywords:</label>
  			@foreach ($topic->keywords as $keyword)
                <p>{{$keyword->keyword}}</p>
			@endforeach
      	</div>

      	<div>
      		<label>Tags:</label>
  			@foreach ($topic->tags as $tag)
                <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
			@endforeach
      	</div>
		
		<div>
      		<label>Feelings:</label>
  			@foreach ($topic->feelings as $feeling)
                <p>{{link_to_route('feelings-page', $feeling->name,  $feeling->id)}}</p>
			@endforeach
      	</div>
      	<div>
      		<label>Updated At:</label>
  			    <p>{{$topic->updated_at}}</p>
      	</div>
	</div>	
	@if (count($posts) > 0)
	    @include('post.list', array('posts'=>$posts))
	@else
	    <p>There are no posts for this topic.</p>
	@endif
	{{--
	<div class="form-signin">
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
	--}}
@stop
