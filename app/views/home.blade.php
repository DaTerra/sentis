@extends('master')

@section('content')
<div class="row ticker">

	<div>
		<h3>
			Top Feelings
		</h3>
		<ul>
			@foreach ($topFeelings as $feeling) 
				<li>
					<a href="{{url('feelings/'.$feeling->id.'/page')}}" class="list-group-item">
						{{$feeling->name}} ({{$feeling->qtd}})
					</a>
				</li>	
			@endforeach
		</ul>
	</div>
	<div>
		<h3>
			Top Tags
		</h3>
		<ul>
			@foreach ($topTags as $tag) 
				<li>
					<a href="{{url('tags/'.$tag->id.'/page')}}" class="list-group-item">
						{{$tag->name}} ({{$tag->qtd}})
					</a>
				</li>	
			@endforeach
		</ul>
	</div>
	<div>
		<h3>
			Last Topics
		</h3>
		<ul>
			@foreach ($lastTopics as $topic) 
				<li>
					<a href="{{url('topic/'.$topic->id.'/page')}}" class="list-group-item">
						{{$topic->title}}
					</a>
				</li>	
			@endforeach
		</ul>
	</div>
	@include('post.order_options')
</div>


<!-- <h2 style="float:left;">Posts</h2> -->
@if (count($posts) > 0)
	@include('post.list', array('posts'=>$posts))
@else
    <p>There are no posts created.</p>
@endif

{{ link_to_route('posts-create', '+ post', null, ['class' => 'addpost'] )}}

<script type="text/javascript">
	$("#orderOpts").change(function() {
    	var selectedVal = $("#orderOpts option:selected").val();
    	$('#order').val(selectedVal);
    	$('#searchForm').attr('action', '/');
    	$('#searchForm').submit();
  	});
</script>
@stop