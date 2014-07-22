@extends('master')

@section('content')
<div class="row">
	<div class="col-sm-4 col-md-3 sidebar">
	    <div class="mini-submenu">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	    </div>
	    <div class="list-group">
	        <span href="#" class="list-group-item active" style="background: rgb(231, 219, 220);">
	            <b>Top Feelings</b>
	            <span class="pull-right" id="slide-submenu">
	                <i class="fa fa-times"></i>
	            </span>
	        </span>
	        @foreach ($topFeelings as $feeling) 
	        	<a href="{{url('feelings/'.$feeling->id.'/page')}}" class="list-group-item">
	            	{{$feeling->name}} ({{$feeling->qtd}})
	        	</a>	
	        @endforeach

	        <span href="#" class="list-group-item" style="background: rgb(231, 219, 220);">
	            <b>Top Tags</b>
	        </span>
	        @foreach ($topTags as $tag) 
	        	<a href="{{url('tags/'.$tag->id.'/page')}}" class="list-group-item">
	            	{{$tag->name}} ({{$tag->qtd}})
	        	</a>	
	        @endforeach
	    </div>
	</div>
</div>

<h2 style="float:left;">Posts</h2>
@include('post.order_options')
@if (count($posts) > 0)
	@include('post.list', array('posts'=>$posts))
@else
    <p>There are no posts created.</p>
@endif

{{ link_to_route('posts-create', 'Add a new Post', null, ['class' => 'btn btn-primary pull-right'] )}}

<script type="text/javascript">
	$("#orderOpts").change(function() {
    	var selectedVal = $("#orderOpts option:selected").val();
    	$('#order').val(selectedVal);
    	$('#searchForm').attr('action', '/');
    	$('#searchForm').submit();
  	});
</script>
@stop