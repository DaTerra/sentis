@extends('master')

@section('content')
	
	{{Form::open(array('method'=>'delete',  'class'=>'form-signin'))}}
		<h2 class="form-signin-heading">Delete Topic?</h2>
		<div class="form-signin">
	    	@if($topic->title)
		    	<div>
		    		<label>Title:</label>
		    		{{{$topic->title}}}
		    	</div>
		    @endif
	      	
	      	@if($topic->content)
		      	<div>
					<label>Content:</label>
		      		{{{$topic->content}}}
		      	</div>
		    @endif
			
		    <div>
		  		<label>Status:</label>
		  		{{{$topic->status}}}
	  		</div>
		    
		    <div>
		  		<label>User:</label>
		  		{{{$topic->user->username}}}
	  		</div>

	      	<div>
	      		<label>Updated At:</label>
	  			    <p>{{$topic->updated_at}}</p>
	      	</div>
	      	<div>
	      		<label>Filter Type:</label>
			    @if($topic->filter_type === 'i')
			    	<p>Inclusive</p>
			    @else
			    	<p>Exclusive</p>
			    @endif
	      	</div>
	      	<table class="table table-striped">
				<thead>
	    			<tr align="center">
			        	<th>Keywords</th>
			        	<th>Tags</th>
			        	<th>Feelings</th>
	        		</tr>
	    		</thead>
	    		<tbody>
		        	<tr>
		        		<td>
			        		@if(count($topic->keywords) > 0)
				        		@foreach ($topic->keywords as $keyword)
					                <p>{{$keyword->keyword}}</p>
								@endforeach
							@else
								<p>-</p>
							@endif	
			        	</td>	
			        	<td>
			        		@if(count($topic->tags) > 0)
				        		@foreach ($topic->tags as $tag)
					                <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
								@endforeach
							@else
								<p>-</p>
							@endif
			        	</td>	
			        	<td>
			        		@if(count($topic->feelings) > 0)
			        			@foreach ($topic->feelings as $feeling)
				                	<p>{{link_to_route('feelings-page', $feeling->name,  $feeling->id)}}</p>
								@endforeach
							@else
								<p>-</p>
							@endif	
						</td>
			        </tr>
		    	</tbody> 
		    </table>
		</div>
		{{ Form::submit('Delete', array('class' => 'btn btn-large btn-primary'))}}
	</div>	
	{{Form::close()}}
	
@stop