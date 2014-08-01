<table class="table table-striped">
	<thead>
    	<tr>
        	<th>#</th>
        	<th>Title</th>
        	<th>Content</th>
        	<th>Status</th>
        	<th>User</th>
        	<th>Filter Type</th>
			<th>Tags</th>
			<th>Feelings</th>
			<th>Keywords</th>
        	<th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($topics as $topic)
	        @if( ($topic->status == 1) || (Auth::user() && Auth::user()->canEditTopic($topic)))
        		<tr>
		        	<td>
	                    {{ link_to_route('topics-page', $topic->id, $topic->id)}}
	                    @if (Auth::user() && Auth::user()->canEditTopic($topic))
							<a href="{{url('topics/'.$topic->id.'/edit')}}" title="Edit Topic">
							<span class="glyphicon glyphicon-edit"></span>
							</a>
							<a href="{{url('topics/'.$topic->id.'/delete')}}" title="Delete Topic">
								<span class="glyphicon glyphicon-trash"></span>
							</a>
						@endif
	                </td>
		          	<td>{{{$topic->title}}}</td>
		          	<td>{{{$topic->content}}}</td>
		          	<td>{{{$topic->status}}}</td>
		          	<td>
						{{link_to_route('profile-user',$topic->user->username,  $topic->user->username)}}
		          	</td>
		          	<td>	
		          		@if($topic->filter_type === 'i')
					    	Inclusive
					    @else
					    	Exclusive
					    @endif
		          	</td>
		          	<td>
		          		@foreach ($topic->tags as $tag)
	                    <p>{{link_to_route('tags-page', $tag->name,  $tag->id)}}</p>
						@endforeach
		          	</td>
		          	<td>
		          		@foreach ($topic->feelings as $feeling)
	                    	<p>{{link_to_route('feelings-page', $feeling->name,  $feeling->id)}}</p>
						@endforeach
		          	</td>
		          	<td>
		          		@foreach ($topic->keywords as $keyword)
	                    	<p>{{$keyword->keyword}}</p>
						@endforeach
		          	</td>
		          	<td>
		          		{{ date('d M Y H:i a',strtotime($topic->updated_at)) }}
		          	</td>
	        	</tr>
	        @endif
	        
	        
        @endforeach
    </tbody>
</table>