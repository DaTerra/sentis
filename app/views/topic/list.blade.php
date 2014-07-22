<table class="table table-striped">
	<thead>
    	<tr>
        	<th>#</th>
        	<th>Title</th>
        	<th>Content</th>
        	<th>Status</th>
        	<th>User</th>
			<th>Keywords</th>
			<th>Tags</th>
			<th>Feelings</th>
        	<th>Posts</th>
        	<th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topics as $topic)
	        <tr>
	        	<td>
	        		{{$topic->id}}
	        		{{--
                    {{ link_to_route('topics-page', $topic->id, $topic->id)}}
                    --}}
                </td>
	          	<td>{{{$topic->title}}}</td>
	          	<td>{{{$topic->content}}}</td>
	          	<td>{{{$topic->status}}}</td>
	          	<td>
					{{link_to_route('profile-user',$topic->user->username,  $topic->user->username)}}
	          	</td>
	          	<td>
	          		@foreach ($topic->topicKeywords as $keyword)
                    	<p>{{$keyword->keyword}}</p>
					@endforeach
	          	</td>
	          	<td>
	          		@foreach ($topic->tags as $tag)
                    <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
					@endforeach
	          	</td>
	          	<td>
	          		@foreach ($topic->feelings as $feeling)
                    	<p>{{link_to_route('feelings-page', $feeling->name,  $feeling->id)}}</p>
					@endforeach
	          	</td>
	          	
	          	<td>
	          		@foreach ($topic->posts as $post)
                    	<p>{{link_to_route('posts-page', $post->id, $post->id)}}</p>
					@endforeach
	          	</td>
	          	<td>
	          		{{ date('d M Y H:i a',strtotime($topic->updated_at)) }}
	          	</td>
        	</tr>
        @endforeach
    </tbody>
</table>