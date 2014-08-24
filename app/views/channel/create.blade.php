@extends('master')

@section('content')
	{{Form::open(array('class'=>'form-signin', 'style'=>'max-width:1200px;', 'id'=>'channelForm'))}}
		<h2 class="form-signin-heading">Create a Channel</h2>
		<input type="hidden" id="selectedTopics" name="selectedTopics" value=""/>

		{{Form::label('name', 'Name')}}
		{{Form::text('name', null,  ['placeholder'=>'Name', 'class' => 'input-block-level'])}}
		@if($errors->has('name'))
			<div class="alert alert-danger">{{$errors->first('name')}}</div>
		@endif
		<h4>Select Channel Topics</h4>
		@include('channel.topics', array('topics'=>$topics))
		{{ Form::submit('Create', array('class' => 'btn btn-large btn-primary'))}}
	{{Form::close()}}
	<script type="text/javascript">
	    $("#channelForm").submit(function() {
	        var selectedTopics = $("#channelTopicsIds:checked").map(function() {
			    return this.value;
			}).get();
	        $('#selectedTopics')
	        	.val(JSON.stringify(selectedTopics));
	    });
	</script>
@stop