@extends('master')

@section('content')
<div class="page-header">
    <h2>
        {{$feeling->name}}
        @if(isset($feeling->description))
            <p>{{{$feeling->description}}}</p>
        @endif
    </h2>
</div>
@if (count($feeling->posts()) > 0)
    @include('post.list', array('posts'=>$feeling->posts()))
@else
    <p>There are no posts created with this feeling.</p>
@endif

@stop