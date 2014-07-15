@extends('master')

@section('content')
<div class="page-header">
	<h2>Most Popular Posts</h2>
</div>
@if (count($posts) > 0)
	@include('post.list', array('posts'=>$posts))
@else
    <p>There are no posts created.</p>
@endif
<td>
    {{ link_to_route('posts-create', 'Add a new Post', null, ['class' => 'btn btn-primary pull-right'] )}}
</td>
	
@stop