@extends('master')
@section('content')
	<div class="page-header">
    	<a href="{{url('/channels')}}">
    		<span class="glyphicon glyphicon-arrow-left"></span> 
    		Back to overview
    	</a>
		@if (Auth::user() && Auth::user()->canEditChannel($channel))
			<a href="{{url('channels/'.$channel->id.'/edit')}}">
			<span class="glyphicon glyphicon-edit"></span> Edit
			</a>
			<a href="{{url('channels/'.$channel->id.'/delete')}}">
				<span class="glyphicon glyphicon-trash"></span> Delete
			</a>
		@endif
	</div>
	<div class="form-signin" style="float:left;width:49%;max-width:680px;min-height: 413px;">
    	<h1>Channel</h1>
    	
	    <div>
    		<label>Channel:</label>
    		{{{$channel->name}}}
    	</div>
      	
	    <div>
	  		<label>User:</label>
	  		{{link_to_route('profile-user',$channel->user->username,  $channel->user->username)}}
  		</div>

      	<div>
      		<label>Updated At:</label>
  			<p>{{$channel->updated_at}}</p>
      	</div>
      	<div>
      		<label>Topics:</label>
  			@foreach($channel->topics as $topic)
  				<p>{{link_to_route('topics-page',$topic->title, $topic->id)}}</p>
  			@endforeach
      	</div>
	</div>	
	
	<div class="form-signin" style="float:right;width:49%;max-width:680px;min-height: 413px;">
		<h1>Sentis Report:</h1>
		@if (count($feelingsByPosts) > 0)
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
			        @foreach($feelingsByPosts as $feeling)
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
			<p>There are no sentis on this channel.</p>
		@endif
	</div>
	<div class="form-signin" style="float:left;width:100%;max-width:1200px;">
		<h1>Posts</h1>
		@if(count($posts) > 0)
			@include('post.list', array('posts'=>$posts))	
		@else
	    	<p>There are no posts for this channel.</p>
		@endif
	</div>
@stop

