<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Sentis</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<link rel="stylesheet" href="{{asset('bootstrap.min.css')}}">
		<style type="text/css">
      		body {
		        padding-bottom: 40px;
		    }

	      	.form-signin {
		        max-width: 370px;
		        padding: 19px 29px 29px;
		        margin: 0 auto 20px;
		        background-color: #fff;
		        border: 1px solid #e5e5e5;
		        -webkit-border-radius: 5px;
		           -moz-border-radius: 5px;
		                border-radius: 5px;
		        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
		                box-shadow: 0 1px 2px rgba(0,0,0,.05);
	      	}
	      
	      	.form-signin .form-signin-heading,
	      	.form-signin .checkbox {
	        	margin-bottom: 10px;
	      	}
		    
		    .form-signin input[type="text"],
		    .form-signin input[type="password"] {
		    	font-size: 16px;
		     	height: auto;
		     	width: 310px;
		     	margin-bottom: 15px;
		     	padding: 7px 9px;
      		}

      		.checkbox {
	  			font-weight: normal;
			}
			#search_list li{
				list-style: none;
			}
			#search_list {
				padding-left: 0px;
				max-height: 300px;
				overflow-y: scroll;
				width: 340px;
			}

    	</style>
	</head>
	<body>
		<div class="container">
			<div class="page-header">
				<div class="text-right">
                    {{link_to_route('home', 'Home')}} |
                    {{link_to_route('tags', 'Tags')}} |
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
