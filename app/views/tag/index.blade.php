@extends('master')

@section('content')
<div class="page-header">
    <h2>Tags</h2>
</div>
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
            <td>
                {{ link_to_route('tags-page', $tag->name, $tag->id)}} 
                {{$tag->postSentisTagsCount()}}
            </td>
            <td>
                @if(isset($tag->description))
                    {{{$tag->description}}}
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@else
<p>There are no tags created.</p>
@endif

@stop