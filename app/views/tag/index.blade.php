@extends('master')
@section('header')
<h2>
    Tags
</h2>
@stop

@section('content')
@if (count($tags) > 0)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
        <tr>
            <td>{{ link_to_route('tags-page', $tag->name, $tag->id)}}</td>
            <td>{{{$tag->name}}}</td>
            <td>{{{$tag->description}}}</td>
        </tr>
        @endforeach
        </tbody>
    </table>
@else
<p>There are no tags created.</p>
@endif

@stop