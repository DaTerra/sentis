@extends('master')

@section('content')
	
	{{Form::open(array('method'=>'delete',  'class'=>'form-signin', 'style'=>'max-width:1200px;'))}}
		<h2 class="form-signin-heading">Delete Channel?</h2>
		<div class="form-signin" style="max-width: 1200px;">
    		<div>
	    		<label>Name:</label>
	    		{{{$channel->name}}}
	    	</div>
	    	@include('channel.topics', array('origin'=>'delete','topics'=>$channel->topics))
		</div>
		{{ Form::submit('Delete', array('class' => 'btn btn-large btn-primary'))}}
	</div>	
	{{Form::close()}}
	
@stop