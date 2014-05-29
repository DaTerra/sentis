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

					@if(!Auth::check())
						@if(Request::path() !== 'login')
							{{link_to('login', 'Sign In')}} | 
						@endif
						{{link_to('signup', 'Sign Up')}}
					@else
						Signed in as
						<strong>{{{Auth::user()->username}}}</strong>
						{{link_to('signout', 'Sign Out')}}		
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
