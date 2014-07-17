@extends('master')

@section('content')

<div class="page-header">
    <h2>
        {{$tag->name}} 
        {{$tag->postSentisTagsCount()}}
        
        @if(isset($tag->description))
            <p>{{{$tag->description}}}</p>
        @endif
    </h2>
    @include('post.order_options')
    {{Form::hidden('tagPageAction', '/tags/' .$tag->id .'/page', ['id'=>'tagPageAction'])}}
</div>
@if (count($tag->posts) > 0)
    @include('post.list', array('posts'=>$tag->posts))
@else
    <p>There are no posts created with this tag.</p>
@endif

<script type="text/javascript">
    $("#orderOpts").change(function() {
        var selectedVal = $("#orderOpts option:selected").val();
        var action = $('#tagPageAction').val();
        $('#order').val(selectedVal);
        $('#searchForm').attr('action', action);
        $('#searchForm').submit();
    });
</script>

@stop