@extends('master')

@section('content')
	<style type="text/css">
      		body {
		        padding-top: 40px;
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

    </style>
	{{Form::open(array('class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Please sign up</h2>
		
		{{Form::text('email', null,  ['placeholder'=>'Email', 'class' => 'input-block-level'])}}
		@if($errors->has('email'))
			<div class="alert alert-danger">{{$errors->first('email')}}</div>
		@endif
		
		{{Form::text('username', null,  ['placeholder'=>'Username', 'class' => 'input-block-level'])}}
		@if($errors->has('username'))
			<div class="alert alert-danger">{{$errors->first('username')}}</div>
		@endif
		
		{{ Form::password('password',   ['placeholder'=>'Password', 'class' => 'input-block-level']) }}
		@if($errors->has('password'))
			<div class="alert alert-danger">{{$errors->first('password')}}</div>
		@endif
		
		{{ Form::password('password_confirmation', ['placeholder'=>'Password Confirmation', 'class' => 'input-block-level']) }}
		@if($errors->has('password_confirmation'))
			<div class="alert alert-danger">{{$errors->first('password_confirmation')}}</div>
		@endif
		{{ Form::submit('Sign up', array('class' => 'btn btn-large btn-primary'))}}
		<a href="<?= Social::login('facebook') ?>">
		 	<img style="width:14%;" src="http://ottopilotmedia.com/wp-content/uploads/2012/07/facebook-icon.jpg">
		 </a>
	{{Form::close()}}
	
@stop