<table class="table table-striped">
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
                    {{ link_to_route('posts-page', $post->id, $post->id)}}
                    <a href="{{url('sentis/'.$post->id.'/create')}}">
                        <span class="glyphicon glyphicon-heart"></span></a>
                </td>
	          	<td>{{{$post->postContent['title']}}}</td>
	          	<td>{{{$post->postContent['content']}}}</td>
	          	<td>{{{$post->postContent['source_url']}}}</td>
	          	<td>
	          	<img style="width:30%;" src="{{{$post->postContent['media_url']}}}"/>
	          	</td>
	          	<td>
	          		@foreach ($post->tags as $tag)
                    <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
					@endforeach
	          	</td>
	          	<td>
	          		@foreach ($post->publicTags() as $tag)
                    	<p>{{link_to_route('tags-page', $tag->name .' (' .$tag->qtd .') ',  $tag->id)}}</p>
					@endforeach
	          	</td>
	          	<td>
					{{link_to_route('profile-user',$post->user->username,  $post->user->username)}}
	          	</td>
	          	<td>
	          		{{ date('d M Y H:i a',strtotime($post->updated_at)) }}
	          	</td>
        	</tr>
        @endforeach
    </tbody>
</table>