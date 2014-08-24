<table class="table table-striped">
	<thead>
    	<tr>
        	<th>#</th>
        	<th>Name</th>
        	<th>User</th>
        	<th>Status</th>
        	<th>Topics</th>
        	<th>Updated At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($channels as $channel)
	        @if( ($channel->status == 1) || (Auth::user() && Auth::user()->canEditChannel($channel)))
        		<tr>
		        	<td>
	                    {{ link_to_route('channels-page', $channel->id, $channel->id)}}
	                    @if (Auth::user() && Auth::user()->canEditChannel($channel))
							<a href="{{url('channels/'.$channel->id.'/edit')}}" title="Edit Channel">
							<span class="glyphicon glyphicon-edit"></span>
							</a>
							<a href="{{url('channels/'.$channel->id.'/delete')}}" title="Delete Channel">
								<span class="glyphicon glyphicon-trash"></span>
							</a>
						@endif
	                </td>
		          	<td>{{{$channel->name}}}</td>
		          	<td>
						{{link_to_route('profile-user',$channel->user->username,  $channel->user->username)}}
		          	</td>
		          	<td>{{{$channel->status}}}</td>
		          	<td>
		          		@foreach ($channel->topics as $topic)
	                    <p>{{link_to_route('topics-page', $topic->title,  $topic->id)}}</p>
						@endforeach
		          	</td>
		          	<td>
		          		{{ date('d M Y H:i a',strtotime($channel->updated_at)) }}
		          	</td>
	        	</tr>
	        @endif
        @endforeach
    </tbody>
</table>