@extends('master')


@section('content')
	<div class="page-header">	
		<h1>
			<img style="width:10%;" src="{{$user->avatar_url}}"/>
			{{$user->username }} ({{$user->email}})
		</h1>
		@if (Auth::user() && Auth::user()->canChangePassword($user))
			@if(Auth::user()->signed_up_by_form == 1)
				{{link_to_route('account-change-password', 'Change Password')}} | 
			@endif
			{{link_to_route('account-upload-avatar', 'Upload Avatar')}} | 
		@endif
		@if (Auth::user() && $user->id !== Auth::user()->id)
			@if(Auth::user()->canFollow($user))
				{{link_to_route('follow-user', 'Follow', $user->username)}}
			@else
				{{link_to_route('unfollow-user', 'Unfollow', $user->username)}}
			@endif
			
		@endif
	</div>	
	
	<h2>User Posts:</h2>
	@if (count($user->posts) > 0)
		@include('post.list', array('posts'=>$user->posts))
	@else 
		<p>There are no posts created from this user.</p>
	@endif

	<h2>User Topics:</h2>
	@if (count($user->topics) > 0)
		@include('topic.list', array('topics'=>$user->topics))
	@else 
		<p>There are no posts created from this user.</p>
	@endif

	<h2>User Channels:</h2>
	@if (count($user->channels) > 0)
		@include('channel.list', array('channels'=>$user->channels))
	@else 
		<p>There are no channels created from this user.</p>
	@endif
	
	<h2>Following</h2>
	@if(count($user->follow) > 0)
		@foreach ($user->follow as $following)
			{{link_to_route('profile-user',$following->username,  $following->username)}}
		@endforeach
	@else
		The user are not following anyone.
	@endif
	<h2>Followers</h2>
	@if(count($user->followers) > 0)
		@foreach ($user->followers as $follower)
			{{link_to_route('profile-user',$follower->username,  $follower->username)}}	
		@endforeach
	@else
		The user has no followers.
	@endif
	
@stop
