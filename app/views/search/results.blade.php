@extends('master')

@section('content')

<h2 style="float:left;">Results searching by "{{$search}}"</h2>
<p style="float:right;">Order by
	{{ Form::select('orderOpts', 
					['newest' => 'Newest',
				     'activity' => 'Activity',
				     'popular' => 'Popular'
				    ], 
				    isset($order) ? $order : null, 
				    ['id' => 'orderOpts']) }}
</p>

@if (count($posts) > 0)
	@include('post.list', array('posts'=>$posts))
@else
    <p>No results found. Please try again with diferent terms.</p>
@endif
<script type="text/javascript">
	$("#orderOpts").change(function() {
    	var selectedVal = $("#orderOpts option:selected").val()
    	$('#order').val(selectedVal);
    	$('#searchForm').submit();
  	});
</script>
@stop