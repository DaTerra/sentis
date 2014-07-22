@extends('master')

@section('content')
	<h2 style="float:left;">Topics</h2>
	
	@if (count($topics) > 0)
		@include('topic.list', array('topics'=>$topics))
	@else
    <p>There are no topics created.</p>
	@endif
    {{ link_to_route('topics-create', 'Add a new Topic', null, ['class' => 'btn btn-primary pull-right'] )}}
@stop