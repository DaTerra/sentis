@extends('master')

@section('header')
	<h2>Please Log In</h2>
@stop

@section('content')
	{{Form::open(array('class'=>'form-horizontal'))}}
		<div class="control-group">
			{{Form::label('Username', null, array('class' => 'control-label'))}} 
			<div class="controls"> 
				{{Form::text('username')}}
			</div>		
		</div>
		<div class="control-group">
			{{Form::label('Password', null, array('class' => 'control-label'))}} 
			<div class="controls"> 
				{{Form::password('password')}}
			</div>
		</div>
		<div class="control-group">
			<div class="controls">
				{{Form::submit('Sign in', array('class' => 'btn'))}}
		    </div>
		</div>
	{{Form::close()}}
@stop

<!-- 
 <form class="form-horizontal">
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email</label>
    <div class="controls">
      <input type="text" id="inputEmail" placeholder="Email">
    </div>
  </div>
  <div class="control-group">
    <label class="control-label" for="inputPassword">Password</label>
    <div class="controls">
      <input type="password" id="inputPassword" placeholder="Password">
    </div>
  </div>
  <div class="control-group">
    <div class="controls">
      <label class="checkbox">
        <input type="checkbox"> Remember me
      </label>
      <button type="submit" class="btn">Sign in</button>
    </div>
  </div>
</form> -->