@extends('master')

@section('content')
    <script type="text/javascript" src="{{ URL::asset('fastLiveFilter/jquery.fastLiveFilter.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('select2/select2.js') }}"></script>
    <link rel="stylesheet" href="{{ URL::asset('select2/select2.css') }}">
    
    {{Form::open(array('class'=>'form-signin', 'enctype' => 'multipart/form-data'))}}
        <h2 class="form-signin-heading">Leave you Sentis</h2>
        {{Form::text('search_input', null, ['id' => 'search_input', 'placeholder'=>'Type to filter', 'class' => 'input-block-level']) }}
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
        
        {{Form::label('tags', 'Tags')}}
        {{Form::hidden('tags', null, ['style'=>'width:300px;'])}}
        {{Form::hidden('tagsJSON', Session::get('tagsJSON'), array('placeholder'=>'Source', 'class' => 'tagsJSON'))}}
        @if($errors->has('tags'))
            <div class="alert alert-danger">{{$errors->first('tags')}}</div>
        @endif
        
        </br>
        </br>
        </br>

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
    <script type="text/javascript">
        $('#tags').select2({
            minimumInputLength: 2,
            tags : [],
            placeholder: "Please enter tags",
            ajax: {
                url: '/tags/get-tags-by-name',
                dataType: 'json',
                type: 'GET',
                quietMillis: 50,
                data: function(term) {
                    return { tags:term };
                },
                results: function (data) {
                    var results = [];
                    $.each(data, function(index, item){
                        results.push({
                            id: item.id,
                            text: item.name
                        });
                    });
                    return {
                      results: results
                  };
                }
            },
            createSearchChoice:function(term, data) { 
                if ($(data).filter(function() { 
                    return this.text.localeCompare(term)===0; 
                }).length===0) {
                    return {id:term, text:term};
                }
           },
           initSelection : function (element, callback) {
                var data = [];
                var tagsJSN = JSON.parse($('.tagsJSON').val());
                // tagsJSNArray = $.makeArray(tagsJSN);
                $(tagsJSN).each(function (index, element) {
                   data.push({id: element.id, text: element.text});
                });
                callback(data);
            }
        });
    </script>   
    <script type="text/javascript">
        $('#tags').change(function() {
            var selections = ( JSON.stringify($('#tags').select2('data')) );
            $('.tagsJSON').val(selections);
        });
    </script>
@stop