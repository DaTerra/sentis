<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
		<title>Sentis</title>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
		<link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css" rel="stylesheet">
		<script>
			// $( document ).ready(function() {
			//   $('.mini-submenu').fadeIn();
			//   $('.mini-submenu').next('.list-group').hide();
			// });
			// $(function(){
			// 	$('#slide-submenu').on('click',function() {			   
			//         $(this).closest('.list-group').fadeOut('slide',function(){
			//         	$('.mini-submenu').fadeIn();	
			//         });
			//       });
			// 	$('.mini-submenu').on('click',function(){		
			//         $(this).next('.list-group').toggle('slide');
			//         $('.mini-submenu').hide();
			// 	})
			// })

		</script>
		<link rel="stylesheet" href="{{asset('/css/style.css')}}">
		
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
                    {{--
                    @if(Auth::user() && Auth::user()->hasRole('ADM'))
                    --}}
						<li>{{link_to_route('topics', 'Topics')}}</li>
					{{--
					@endif
					--}}
						<li>{{link_to_route('channels', 'Channels')}}</li>
			      </ul>
			      <form  id="searchForm" style="width:30%" action="/search/" class="navbar-form navbar-left" role="search">
			        <div class="input-group">
			        	@if(isset($order))
			        		<input type="hidden" name="order" id="order" value="{{$order}}" />
			        	@else
							<input type="hidden" name="order" id="order"/>
						@endif
			        	<input type="hidden" name="topicPosts" id="topicPosts"/>
			            
						{{Form::text('search', isset($search) ? $search : null,  ['placeholder'=>'Search', 'class' => 'form-control'])}}
						
			            <div class="input-group-btn">
			                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
			            </div>
			            
			        </div>
			      </form>
			      <ul class="nav navbar-nav navbar-right" style="width:20%;">
			        @if(!Auth::check())
						@if(Request::path() !== 'account/login')
							<li>{{link_to_route('account-login', 'Sign In')}}</li>
						@endif
						@if(Request::path() !== 'account/create')
							<li>{{link_to_route('account-create', 'Sign Up')}}</li>
						@endif
					@else
						<li style="text-align: right;width:50%;">

							<a href="/user/{{Auth::user()->username}}"> <img style="width:10%;" src="{{{Auth::user()->avatar_url}}}">
								<strong>{{{Auth::user()->username}}}</strong>
							</a>
						<li style="text-align: right;">{{link_to_route('account-logout', 'Sign out')}}</li>
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
