@extends('master')
@section('header')
<h2>
    Feelings
</h2>
@stop

@section('content')

@if (count($feelings) > 0)
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody>
        @foreach($feelings as $feeling)
        <tr>
            <td>{{ link_to_route('feelings-page', $feeling->name, $feeling->id)}}</td>
            <td>
                @if(isset($feeling->description))
                    {{{$feeling->description}}}
                @else
                    -
                @endif
            </td>
        </tr>
        @endforeach
        </tbody>
    </table>
@else
<p>There are no feelings created.</p>
@endif

@stop