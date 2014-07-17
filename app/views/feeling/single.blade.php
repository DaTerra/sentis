@extends('master')

@section('content')
    
    <h2>
        {{$feeling->name}}
        @if(isset($feeling->description))
            <p>{{{$feeling->description}}}</p>
        @endif
    </h2>
    @include('post.order_options')
    {{Form::hidden('feelingPageAction', '/feelings/' .$feeling->id .'/page', ['id'=>'feelingPageAction'])}}

	@if (count($feeling->posts) > 0)
	    @include('post.list', array('posts'=>$feeling->posts))
	@else
	    <p>There are no posts created with this feeling.</p>
	@endif
    
    <script type="text/javascript">
        $("#orderOpts").change(function() {
            var selectedVal = $("#orderOpts option:selected").val();
            var action = $('#feelingPageAction').val();
            $('#order').val(selectedVal);
            $('#searchForm').attr('action', action);
            $('#searchForm').submit();
        });
    </script>
@stop