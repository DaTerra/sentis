@extends('master')

@section('content')

    {{Form::open(array('channels-edit', $channel->id, 'method' => 'put', 'class'=>'form-signin'))}}
        <h2 class="form-signin-heading">Edit a Channel</h2>
        <input type="hidden" id="selectedTopics" name="selectedTopics" value=""/>

        {{Form::label('name', 'Name')}}
        {{Form::text('name', $channel->name,  ['placeholder'=>'Name', 'class' => 'input-block-level'])}}
        @if($errors->has('name'))
            <div class="alert alert-danger">{{$errors->first('name')}}</div>
        @endif

        {{ Form::submit('Save', array('class' => 'btn btn-large btn-primary'))}}
    {{Form::close()}}
    <script type="text/javascript">
        $("#channelForm").submit(function() {
            var selectedTopics = $("#channelTopicsIds:checked").map(function() {
                return this.value;
            }).get();
            $('#selectedTopics')
                .val(JSON.stringify(selectedTopics));
        });
    </script>
@stop