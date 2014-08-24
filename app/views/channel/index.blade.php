@extends('master')

@section('content')
	<h2 style="float:left;">Channels</h2>
	
	@if (count($channels) > 0)
		@include('channel.list', array('channels'=>$channels))
	@else
    <p>There are no channels created.</p>
	@endif
    {{ link_to_route('channels-create', 'Add a new Channel', null, ['class' => 'btn btn-primary pull-right'] )}}
@stop