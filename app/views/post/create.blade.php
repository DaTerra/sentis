@extends('master')

@section('content')
	<link rel="stylesheet" href="{{ URL::asset('select2/select2.css') }}">
	<script type="text/javascript" src="{{ URL::asset('select2/select2.js') }}"></script>

	{{Form::open(array('class'=>'form-signin', 'enctype' => 'multipart/form-data'))}}
		<h2 class="form-signin-heading">Create a Post</h2>
		{{Form::label('title', 'Title')}}
		{{Form::text('title', null,  ['placeholder'=>'Title', 'class' => 'input-block-level'])}}
		@if($errors->has('title'))
			<div class="alert alert-danger">{{$errors->first('title')}}</div>
		@endif
		
		{{Form::label('content', 'Content')}}
		{{ Form::textarea('content', null, ['placeholder'=>'Content', 'size' => '48x10', 'class' => 'input-block-level']) }}
		@if($errors->has('content'))
			<div class="alert alert-danger">{{$errors->first('content')}}</div>
		@endif
		
		{{Form::label('source_url', 'Source')}}
		{{Form::text('source_url', null,  ['placeholder'=>'Source', 'class' => 'input-block-level'])}}
		@if($errors->has('source_url'))
			<div class="alert alert-danger">{{$errors->first('source_url')}}</div>
		@endif

		{{Form::label('media', 'Media')}}
		{{Form::file('media')}}
		@if($errors->has('media'))
			<div class="alert alert-danger">{{$errors->first('media')}}</div>
		@endif
				
		</br>
		
		{{Form::label('tags', 'Tags')}}
		{{Form::hidden('tags', null, ['style'=>'width:300px;'])}}
		{{Form::hidden('tagsJSON', Session::get('tagsJSON'), array('placeholder'=>'Source', 'class' => 'tagsJSON'))}}
		@if($errors->has('tags'))
			<div class="alert alert-danger">{{$errors->first('tags')}}</div>
		@endif

		</br>
		</br>
		</br>

		{{ Form::submit('Create', array('class' => 'btn btn-large btn-primary'))}}
		<input type="checkbox" name="anonymous", id="anonymous" value="1" />
		{{Form::label('anonymous', 'Post Anonymously?')}}

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