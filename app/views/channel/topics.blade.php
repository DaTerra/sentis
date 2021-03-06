<table class="table table-striped">
	<thead>
    	<tr>
        	<th>#</th>
        	<th>Title</th>
        	<th>Content</th>
        	<th>User</th>
			<th>Tags</th>
			<th>Feelings</th>
			<th>Keywords</th>
        	<th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topics as $topic)
	        	<tr>
		        	<td>
	                    @if(!isset($origin) || $origin != 'delete')
	                    	<input type="checkbox" name="channelTopicsIds" value="{{$topic->id}}" id="channelTopicsIds"
   							/>
	                    @endif	
	                    {{ link_to_route('topics-page', $topic->id, $topic->id)}}
	                </td>
		          	<td>{{{$topic->title}}}</td>
		          	<td>{{{$topic->content}}}</td>
		          	<td>
						{{link_to_route('profile-user',$topic->user->username,  $topic->user->username)}}
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
		          		@foreach ($topic->keywords as $keyword)
	                    	<p>{{$keyword->keyword}}</p>
						@endforeach
		          	</td>
		          	<td>
		          		{{ date('d M Y H:i a',strtotime($topic->updated_at)) }}
		          	</td>
	        	</tr>
        @endforeach
    </tbody>
</table>