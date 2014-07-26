@extends('master')

@section('content')
    
    <link rel="stylesheet" href="{{ URL::asset('select2/select2.css') }}">
    <script type="text/javascript" src="{{ URL::asset('select2/select2.js') }}"></script>
	{{Form::open(array('topics-edit', $topic->id, 'method' => 'put', 'class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Edit a Topic</h2>
		
		{{Form::label('title', 'Title')}}
		{{Form::text('title', $topic->title,  ['placeholder'=>'Title', 'class' => 'input-block-level'])}}
		@if($errors->has('title'))
			<div class="alert alert-danger">{{$errors->first('title')}}</div>
		@endif
		
		{{Form::label('content', 'Content')}}
		{{ Form::textarea('content', $topic->content, ['placeholder'=>'Content', 'size' => '48x10', 'class' => 'input-block-level']) }}
		@if($errors->has('content'))
			<div class="alert alert-danger">{{$errors->first('content')}}</div>
		@endif

        {{Form::label('tags', 'Tags')}}
        {{Form::hidden('tags', $topic->tags, ['style'=>'width:300px;'])}}
        {{Form::hidden('tagsJSON', $topic->tags , array('placeholder'=>'Source', 'class' => 'tagsJSON'))}}
        @if($errors->has('tags'))
            <div class="alert alert-danger">{{$errors->first('tags')}}</div>
        @endif
        
        </br>
        </br>
        
        {{Form::label('feelings', 'Feelings')}}
        {{Form::hidden('feelings', $topic->feelings, ['style'=>'width:300px;'])}}
        {{Form::hidden('feelingsJSON', $topic->feelings, array('placeholder'=>'Source', 'class' => 'feelingsJSON'))}}
        @if($errors->has('feelings'))
            <div class="alert alert-danger">{{$errors->first('feelings')}}</div>
        @endif
        
        </br>
        </br>
        
        {{Form::label('keywords', 'Keywords (Search keyword on posts title and content)')}}
        {{Form::hidden('keywords', $topic->keywords, ['style'=>'width:300px;'])}}
        {{Form::hidden('keywordsJSON', $topic->keywords, array('placeholder'=>'Source', 'class' => 'keywordsJSON'))}}
        @if($errors->has('keywords'))
            <div class="alert alert-danger">{{$errors->first('keywords')}}</div>
        @endif
        
        </br>
        </br>
        </br>
		
		{{ Form::submit('Save', array('class' => 'btn btn-large btn-primary'))}}
		<input type="checkbox" name="status", id="status" value="1" 
        @if($topic->status == 1)checked @endif />
        {{Form::label('status', 'Publish Topic?')}}
        

	{{Form::close()}}

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
            initSelection : function (element, callback) {
                var data = [];
                var tagsJSN = JSON.parse($('.tagsJSON').val());
                // tagsJSNArray = $.makeArray(tagsJSN);
                $(tagsJSN).each(function (index, element) {
                    data.push({id: element.id, text: element.name});
                });
                callback(data);
            }
        });

        $('#feelings').select2({
            minimumInputLength: 2,
            tags : [],
            placeholder: "Please enter feelings",
            ajax: {
                url: '/feelings/get-feelings-by-name',
                dataType: 'json',
                type: 'GET',
                quietMillis: 50,
                data: function(term) {
                    return { feelings:term };
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
            initSelection : function (element, callback) {
                var data = [];
                var feelingsJSN = JSON.parse($('.feelingsJSON').val());
                $(feelingsJSN).each(function (index, element) {
                    data.push({id: element.id, text: element.name});
                });
                callback(data);
            }
        });    

        $('#keywords').select2({
            minimumInputLength: 2,
            tags : [],
            placeholder: "Please enter keywords",
            createSearchChoice:function(term, data) { 
                if ($(data).filter(function() { 
                    return this.text.localeCompare(term)===0; 
                }).length===0) {
                    return {id:term, text:term};
                }
           },
           initSelection : function (element, callback) {
                var data = [];
                var keywordsJSN = JSON.parse($('.keywordsJSON').val());
                $(keywordsJSN).each(function (index, element) {
                   data.push({id: element.keyword, text: element.keyword});
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

        $('#feelings').change(function() {
            var selections = ( JSON.stringify($('#feelings').select2('data')) );
            $('.feelingsJSON').val(selections);
        });

        $('#keywords').change(function() {
            var selections = ( JSON.stringify($('#keywords').select2('data')) );
            $('.keywordsJSON').val(selections);
        });

        $( document ).ready(function() {
            var selections = ( JSON.stringify($('#keywords').select2('data')) );
            $('.keywordsJSON').val(selections);
        });
    </script>
@stop