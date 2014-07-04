@extends('master')

@section('content')
    <script type="text/javascript" src="{{ URL::asset('fastLiveFilter/jquery.fastLiveFilter.js') }}"></script>

    
    {{Form::open(array('class'=>'form-signin', 'enctype' => 'multipart/form-data'))}}
        <h2 class="form-signin-heading">Leave you Sentis</h2>
        {{Form::text('search_input', null, ['id' => 'search_input', 'placeholder'=>'Type to filter', 'class' => 'input-block-level']) }}
        <p id='num_results'></p> 
        <ul id="search_list">
            @foreach ($feelings as $feeling)
                <li>
                    {{Form::label($feeling->id , $feeling->name)}}
                    {{ Form::text($feeling->id , null, ['placeholder'=>'Value', 'class' => 'input-block-level']) }}
                    @if($errors->has($feeling->id))
                        <div class="alert alert-danger">{{$errors->first($feeling->id)}}</div>
                    @endif
                </li>
            @endforeach
        </ul>    
        {{Form::hidden('feelingsJSON', null, array('class' => 'feelingsJSON'))}}
        {{ Form::submit('Create', array('class' => 'btn btn-large btn-primary'))}}

    {{Form::close()}}

    <script>
        $(function() {
            $('#search_input').fastLiveFilter('#search_list');
        });
        
        var feelingsValues = [];
        $( ".form-signin" ).submit(function( event ) {
            $('#search_list li :input').each(function( index ) {
                var val = $( this ).val();
                var id = $ ( this ).attr('id');
                if(val != ''){
                    feelingsValues.push({feeling_id: id, value: val});
                }
            });
            var feelingsJSON = JSON.stringify(feelingsValues);
            $('.feelingsJSON').val(feelingsJSON);
        });

    </script>
@stop