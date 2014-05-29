@extends('master')

@section('content')
	<style type="text/css">
      		body {
		        padding-top: 40px;
		        padding-bottom: 40px;
		        background-color: #f5f5f5;
		    }

	      	.form-signin {
		        max-width: 300px;
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
		     	margin-bottom: 15px;
		     	padding: 7px 9px;
      		}

    </style>
	{{Form::open(array('class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Please sign up</h2>
		@if ( $errors->count() > 0 )
	    	<div class="alert alert-danger">
		      	<ul>
		        	@foreach( $errors->all() as $message )
		         	 <li>{{ $message }}</li>
		        	@endforeach
		      	</ul>	
	      	</div>
    	@endif
		{{Form::text('email', null,  ['placeholder'=>'Email', 'class' => 'input-block-level'])}}
		{{Form::text('username', null,  ['placeholder'=>'Username', 'class' => 'input-block-level'])}}
		{{ Form::password('password',   ['placeholder'=>'Password', 'class' => 'input-block-level']) }}
		{{Form::submit('Sign up', array('class' => 'btn btn-large btn-primary'))}}
	{{Form::close()}}
	
@stop