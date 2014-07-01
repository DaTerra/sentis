@extends('master')

@section('header')
	<h1>
		<img style="width:10%;" src="{{$user->avatar_url}}"/>
		{{$user->username }} ({{$user->email}})
	</h1>
@stop

@section('content')
	
	
	
	<h2>User Roles:</h2>
	@foreach ($user->roles as $role)
	    <p>{{ $role->name }}</p>
	@endforeach
	
	<h2>User Posts:</h2>
	@if (count($user->posts) > 0)
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
                    <th>Status</th>
		        </tr>
		    </thead>
		    <tbody>
		        @foreach($user->posts as $post)
			        <tr>
			        	<td>
                            {{ link_to_route('posts-page', $post->id, $post->id)}}
                            <a href="{{url('sentis/'.$post->id.'/create')}}">
                                <span class="glyphicon glyphicon-heart"></span></a>
                        </td>
			          	<td>{{{$post->postContent['title']}}}</td>
			          	<td>{{{$post->postContent['content']}}}</td>
			          	<td>{{{$post->postContent['source_url']}}}</td>
			          	<td>{{{$post->postContent['media']['type']}}}</td>
			          	<td>
			          	<img style="width:30%;" src="{{{$post->postContent['media_url']}}}"/>
			          	</td>
			          	<td>
			          		@foreach ($post->tags as $tag)
                                <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
							@endforeach
		          		</td>
			          	<td>{{{$post->user->username}}}</td>
			          	<td>{{{$post->privacy->name}}}</td>
			          	<td>{{{$post->anonymous}}}</td>
			          	<td>{{{$post->user_ip_address}}}</td>
                        <td>{{{$post->status}}}</td>
		        	</tr>
		        @endforeach
		    </tbody>
		</table>
	@else 
		<p>There are no posts created from this user.</p>
	@endif

	@if (Auth::user() && Auth::user()->canChangePassword($user))
		@if(Auth::user()->signed_up_by_form == 1)
			{{link_to_route('account-change-password', 'Change Password')}} | 
		@endif
		{{link_to_route('account-upload-avatar', 'Upload Avatar')}}
	@endif
@stop
