<table class="table posts-list">
	<thead>
    	<tr>
        	<th>#</th>
        	<th>Title</th>
        	<th>Content</th>
        	<th>Source</th>
			<th>Media</th>
			<th>Tags</th>
			<th>Public Tags</th>
        	<th>User</th>
        	<th>Last update</th>
        </tr>
    </thead>
    <tbody>
    	@foreach($posts as $post)
	        <tr>
	        	<td>
	        		{{ link_to_route('posts-page', "Stats", $post->id)}}
                    
                    @if((isset($topicList)) && (Auth::user()) && (Auth::user()->canEditTopic($topic)))
						<input type="checkbox" name="topicPostsIds" value="{{$post->id}}" id="topicPostsIds"
						@foreach($topic->posts as $topicPost)
							@if($post->id === $topicPost->id)
								checked
							@endif	
						@endforeach

						/>
					@endif
                    @if (Auth::user() && Auth::user()->canEdit($post))
						<a class="edit-btn" href="{{url('posts/'.$post->id.'/edit')}}" title="Edit Post">
							Edit
						<span class="glyphicon glyphicon-edit"></span>
						</a>
						<a class="delete-btn" href="{{url('posts/'.$post->id.'/delete')}}" title="Delete Post">
							Delete
							<span class="glyphicon glyphicon-trash"></span>
						</a>
					@endif
				    <a class="sentis-btn" href="{{url('sentis/'.$post->id.'/create')}}" title="Sentis this">
				    	Sentis
				        <span class="glyphicon glyphicon-heart"></span> 
				    </a>
                </td>
	          	<td><!-- {{{$post->postContent['title']}}} --></td>
	          	<td><!-- {{{$post->postContent['content']}}} --></td>
	          	<td><!-- {{{$post->postContent['source_url']}}} --></td>
	          	<td>
	          	@if(isset($post->postContent['media_url']))
	          		<img src="{{{$post->postContent['media_url']}}}"/>
	          	@endif
	          	</td>
	          	<td>
	          		<!-- @foreach ($post->tags as $tag)
                    	<p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
					@endforeach -->
	          	</td>
	          	<td>
	          		<!-- @foreach ($post->publicTags() as $tag)
                    	<p>{{link_to_route('tags-page', $tag->name .' (' .$tag->qtd .') ',  $tag->id)}}</p>
					@endforeach -->
	          	</td>
	          	<td>
					<!-- {{link_to_route('profile-user',$post->user->username,  $post->user->username)}} -->
	          	</td>
	          	<td>
	          		<!-- {{ date('d M Y H:i a',strtotime($post->updated_at)) }} -->
	          	</td>
        	</tr>
        @endforeach
    </tbody>
</table>