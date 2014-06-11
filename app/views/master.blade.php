<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Sentis</title>
		<link rel="stylesheet" href="{{asset('bootstrap.min.css')}}">
		
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<div class="text-right">
					{{link_to_route('home', 'Home')}} | 
					@if(!Auth::check())
						@if(Request::path() !== 'account/login')
							{{link_to_route('account-login', 'Sign In')}} |   
						@endif
						@if(Request::path() !== 'account/create')
							{{link_to_route('account-create', 'Sign Up')}} 
						@endif
					@else
						{{link_to_route('account-logout', 'Sign out')}} | 
						Signed in as <strong>{{ link_to_route('profile-user', Auth::user()->username , Auth::user()->username)}} </strong>
					@endif
				</div>
				
				@yield('header')

			</div>
			
			@if(Session::has('message'))
				<div class="alert alert-success">
					{{Session::get('message')}}
				</div>
			@endif
			
			@if(Session::has('error'))
				<div class="alert alert-warning">
					{{Session::get('error')}}
				</div>
			@endif
			@yield('content')
		</div>
	</body>
</html>
