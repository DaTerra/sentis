<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
		<title>Sentis</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<script>
			$( document ).ready(function() {
			  $('.mini-submenu').fadeIn();
			  $('.mini-submenu').next('.list-group').hide();
			});
			$(function(){
				$('#slide-submenu').on('click',function() {			   
			        $(this).closest('.list-group').fadeOut('slide',function(){
			        	$('.mini-submenu').fadeIn();	
			        });
			      });
				$('.mini-submenu').on('click',function(){		
			        $(this).next('.list-group').toggle('slide');
			        $('.mini-submenu').hide();
				})
			})

		</script>
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
			.mini-submenu{
			  display:none;  
			  background-color: rgba(0, 0, 0, 0);  
			  border: 1px solid rgba(0, 0, 0, 0.9);
			  border-radius: 4px;
			  padding: 9px;  
			  /*position: relative;*/
			  width: 42px;

			}

			.mini-submenu:hover{
			  cursor: pointer;
			}

			.mini-submenu .icon-bar {
			  border-radius: 1px;
			  display: block;
			  height: 2px;
			  width: 22px;
			  margin-top: 3px;
			}

			.mini-submenu .icon-bar {
			  background-color: #000;
			}

			#slide-submenu{
			  background: rgba(0, 0, 0, 0.45);
			  display: inline-block;
			  padding: 0 8px;
			  border-radius: 4px;
			  cursor: pointer;
			}
    	</style>
	</head>
	<body>
		<div class="container">
			<nav class="navbar navbar-default" role="navigation">
			  <div class="container-fluid">
			    <!-- Brand and toggle get grouped for better mobile display -->
			    <div class="navbar-header">
			    	{{link_to_route('home', 'Sentis', null, array('class' => 'navbar-brand'))}}
			    </div>

			    <!-- Collect the nav links, forms, and other content for toggling -->
			    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
			      <ul class="nav navbar-nav">
			        <li>{{link_to_route('feelings', 'Feelings')}}</li>
                    <li>{{link_to_route('tags', 'Tags')}}</li>
			      </ul>
			      <form  id="searchForm" style="width:30%" action="/search/" class="navbar-form navbar-left" role="search">
			        <div class="input-group">
			        	@if(isset($order))
			        		<input type="hidden" name="order" id="order" value="{{$order}}" />
			        	@else
							<input type="hidden" name="order" id="order"/>
						@endif
			        	
			            
						{{Form::text('search', isset($search) ? $search : null,  ['placeholder'=>'Search', 'class' => 'form-control'])}}
						
			            <div class="input-group-btn">
			                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			            </div>
			            
			        </div>
			      </form>
			      <ul class="nav navbar-nav navbar-right">
			        @if(!Auth::check())
						@if(Request::path() !== 'account/login')
							<li>{{link_to_route('account-login', 'Sign In')}}</li>
						@endif
						@if(Request::path() !== 'account/create')
							<li>{{link_to_route('account-create', 'Sign Up')}}</li>
						@endif
					@else
						<li style="text-align: right;">
							<a href="/user/{{Auth::user()->username}}">
								<img style="width:4%;" src="{{{Auth::user()->avatar_url}}}">
								<strong>{{{Auth::user()->username}}}</strong>
							</a>
						<li>{{link_to_route('account-logout', 'Sign out')}}</li>
					@endif
			      </ul>
			    </div><!-- /.navbar-collapse -->
			  </div><!-- /.container-fluid -->
			</nav>
			
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
