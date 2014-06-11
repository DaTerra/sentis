@extends('master')

@section('header')
	<h2>
		User
	</h2>
@stop

@section('content')
	<p>{{$user->username }} ({{$user->email}})</p>
	@if (Auth::user() && Auth::user()->canChangePassword($user))
		{{link_to_route('account-change-password', 'Change Password')}}
	@endif
@stop
