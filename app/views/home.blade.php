@extends('master')

@section('header')
	<h2>
		Posts
	</h2>
@stop

@section('content')
	<table class="table table-striped">
		<thead>
	    	<tr>
	        	<th>#</th>
	        	<th>Title</th>
	        	<th>Content</th>
	        	<th>Source</th>
				<th>Media Type</th>
				<th>Media URL</th>
				<th>Tags</th>
	        	<th>User</th>
			    <th>Privacy</th>
			    <th>Anonymous</th>
			    <th>IP Address</th>
	        </tr>
	    </thead>
	    <tbody>
	        @foreach($posts as $post)
		        <tr>
		        	<td>{{ link_to_route('posts-page', $post->id, $post->id)}}</td>
		          	<td>{{{$post->postContent['title']}}}</td>
		          	<td>{{{$post->postContent['content']}}}</td>
		          	<td>{{{$post->postContent['source_url']}}}</td>
		          	<td>{{{$post->postContent['media']['type']}}}</td>
		          	<td>
		          	<img style="width:30%;" src="{{{$post->postContent['media_url']}}}"/>
		          	</td>
		          	<td>
		          		@foreach ($post->tags as $tag)
	    					<p>{{ $tag->name }}</p>
						@endforeach
		          	</td>
		          	<td>
						{{link_to_route('profile-user',$post->user->username,  $post->user->username)}}
		          	</td>
		          	<td>{{{$post->privacy->name}}}</td>
		          	<td>{{{$post->anonymous}}}</td>
		          	<td>{{{$post->user_ip_address}}}</td>
	        	</tr>
	        @endforeach
	    </tbody>
	</table>
	
	<td>
		{{ link_to_route('posts-create', 'Add a new Post', null, ['class' => 'btn btn-primary pull-right'] )}}
	</td>
	
@stop