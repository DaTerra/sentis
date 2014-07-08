@extends('master')

@section('content')
<script type="text/javascript" src="{{ URL::asset('fastLiveFilter/jquery.fastLiveFilter.js') }}"></script>
<div class="page-header">
    <h2>
        Feelings
        {{Form::text('search_input', null, ['id' => 'search_input', 'placeholder'=>'Type to filter', 'class' => 'input-block-level']) }}
    </h2>
</div>
@if (count($feelings) > 0)
    
    <table class="table table-striped"  style="width:100%;">
        <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
        </tr>
        </thead>
        <tbody id="search_list">
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
<script type="text/javascript">
    $(function() {
        $('#search_input').fastLiveFilter('#search_list');
    });
</script>
@stop