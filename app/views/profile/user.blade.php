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
			{{link_to_route('account-upload-avatar', 'Upload Avatar')}}
		@endif
	</div>	
	
	<h2>User Roles:</h2>
	@foreach ($user->roles as $role)
	    <p>{{ $role->name }}</p>
	@endforeach
	
	<h2>User Posts:</h2>
	@if (count($user->posts) > 0)
		@include('post.list', array('posts'=>$user->posts))
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
