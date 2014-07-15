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
</div>
@if (count($tag->postsByTag()) > 0)
    @include('post.list', array('posts'=>$tag->postsByTag()))
@else
    <p>There are no posts created with this tag.</p>
@endif

@stop