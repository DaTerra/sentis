@extends('master')

@section('content')
<h2 style="float:left;">Posts</h2>
@include('post.order_options')
@if (count($posts) > 0)
	@include('post.list', array('posts'=>$posts))
@else
    <p>There are no posts created.</p>
@endif
<td>
    {{ link_to_route('posts-create', 'Add a new Post', null, ['class' => 'btn btn-primary pull-right'] )}}
</td>

<script type="text/javascript">
	$("#orderOpts").change(function() {
    	var selectedVal = $("#orderOpts option:selected").val();
    	$('#order').val(selectedVal);
    	$('#searchForm').attr('action', '/');
    	$('#searchForm').submit();
  	});
</script>
@stop