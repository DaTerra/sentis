@extends('master')

@section('content')
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

    </style>
	{{Form::open(array('class'=>'form-signin', 'enctype' => 'multipart/form-data'))}}
		<h2 class="form-signin-heading">Create a Post</h2>
		
		{{Form::label('title', 'Title')}}
		{{Form::text('title', null,  ['placeholder'=>'Title', 'class' => 'input-block-level'])}}
		@if($errors->has('title'))
			<div class="alert alert-danger">{{$errors->first('title')}}</div>
		@endif
		
		{{Form::label('content', 'Content')}}
		{{ Form::textarea('content', null, ['placeholder'=>'Content', 'size' => '48x10', 'class' => 'input-block-level']) }}
		@if($errors->has('content'))
			<div class="alert alert-danger">{{$errors->first('content')}}</div>
		@endif
		
		{{Form::label('source_url', 'Source')}}
		{{Form::text('source_url', null,  ['placeholder'=>'Source', 'class' => 'input-block-level'])}}
		@if($errors->has('source_url'))
			<div class="alert alert-danger">{{$errors->first('source_url')}}</div>
		@endif

		{{Form::label('media', 'Media')}}
		{{Form::file('media')}}
		@if($errors->has('media'))
			<div class="alert alert-danger">{{$errors->first('media')}}</div>
		@endif
		
		</br>
		
		{{ Form::submit('Create', array('class' => 'btn btn-large btn-primary'))}}
		<input type="checkbox" name="anonymous", id="anonymous" value="1" />
		{{Form::label('anonymous', 'Post Anonymously?')}}

	{{Form::close()}}
	
@stop