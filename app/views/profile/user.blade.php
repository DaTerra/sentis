@extends('master')

@section('header')
	<h1>
		<img style="width:10%;" src="{{URL::asset($user->avatar_url)}}"/>
		{{$user->username }} ({{$user->email}})
	</h1>
@stop

@section('content')
	
	
	
	<h2>User Roles:</h2>
	@foreach ($user->roles as $role)
	    <p>{{ $role->name }}</p>
	@endforeach

	@if (Auth::user() && Auth::user()->canChangePassword($user))
		{{link_to_route('account-change-password', 'Change Password')}} | 
		{{link_to_route('account-upload-avatar', 'Upload Avatar')}}
	@endif
@stop
