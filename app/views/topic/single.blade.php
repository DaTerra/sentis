@extends('master')
@section('content')
	<div class="page-header">
    	<a href="{{url('/topics')}}">
    		<span class="glyphicon glyphicon-arrow-left"></span> 
    		Back to overview
    	</a>
		@if (Auth::user() && Auth::user()->canEditTopic($topic))
			<a href="{{url('topics/'.$topic->id.'/edit')}}">
			<span class="glyphicon glyphicon-edit"></span> Edit
			</a>
			<a href="{{url('topics/'.$topic->id.'/delete')}}">
				<span class="glyphicon glyphicon-trash"></span> Delete
			</a>
			@if($topic->status == 1)
				<a href="{{url('topics/'.$topic->id.'/status/0')}}">
					<span class="glyphicon glyphicon-remove"></span> Unpublish
				</a>
			@else
				<a href="{{url('topics/'.$topic->id.'/status/1')}}">
					<span class="glyphicon glyphicon-ok"></span> Publish
				</a>
			@endif
		@endif
	</div>
	<div class="form-signin" style="float:left;width:49%;max-width:680px;min-height: 413px;">
    	<h1>Topic</h1>
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
	  		{{link_to_route('profile-user',$topic->user->username,  $topic->user->username)}}
  		</div>

      	<div>
      		<label>Updated At:</label>
  			    <p>{{$topic->updated_at}}</p>
      	</div>
      	<table class="table table-striped">
			<thead>
    			<tr align="center">
		        	<th>Tags</th>
		        	<th>Feelings</th>
		        	<th>Keywords</th>
        		</tr>
    		</thead>
    		<tbody>
	        	<tr>
	        		<td>
		        		@if(count($topic->tags) > 0)
			        		@foreach ($topic->tags as $tag)
				                <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
							@endforeach
						@else
							<p>-</p>
						@endif
		        	</td>	
		        	<td>
		        		@if(count($topic->feelings) > 0)
		        			@foreach ($topic->feelings as $feeling)
			                	<p>{{link_to_route('feelings-page', $feeling->name,  $feeling->id)}}</p>
							@endforeach
						@else
							<p>-</p>
						@endif	
					</td>
					<td>
		        		@if(count($topic->keywords) > 0)
			        		@foreach ($topic->keywords as $keyword)
				                <p>{{$keyword->keyword}}</p>
							@endforeach
						@else
							<p>-</p>
						@endif	
		        	</td>
		        </tr>
	    	</tbody> 
	    </table>
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
			<p>There are no sentis on this topic.</p>
		@endif
	</div>
	<div class="form-signin" style="float:left;width:100%;max-width:1200px;">
		<h1>Posts</h1>
		@if (Auth::user() && Auth::user()->canEditTopic($topic))	
			<h3>Saving Static Posts means the topic will allways show the 	selected posts</h3>
		@endif

		<input type="hidden" value="/topics/{{$topic->id}}/static-posts/" id="topicPostsAction"/>
		
		@if (Auth::user() && Auth::user()->canEditTopic($topic))
			<input type="button" class="btn btn-large btn-primary" id="staticPosts" value="Save static Posts">
		@endif

		{{-- 
			se sou dono do post e tiver posts estaticos, quero
		    ver os posts dinamicos e os estaticos selecionados
		--}}
		@if(count($topic->posts) > 0)
			@if(Auth::user() && Auth::user()->canEditTopic($topic))
				@include('post.list', array('posts'=>$posts, 'topicList'=> 	true))
			@else
				@include('post.list', array('posts'=>$topic->posts, 'topicList'=> 	true))		
			@endif
		@elseif (count($posts) > 0)
				@include('post.list', array('posts'=>$posts, 'topicList'=> 	true))	
		@else
	    	<p>There are no posts for this topic.</p>
		@endif
	</div>	
<script type="text/javascript">
    $("#staticPosts").click(function() {
        var selectedPosts = $("#topicPostsIds:checked").map(function() {
		    return this.value;
		}).get();
        var action = $('#topicPostsAction').val();
        $('#topicPosts').val(selectedPosts);
        $('#searchForm').attr('action', action);
        $('#searchForm').submit();
    });
</script>
@stop

