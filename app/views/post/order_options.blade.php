<p style="float:right;">Order by
	{{ Form::select('orderOpts', 
					['newest' => 'Newest',
				     'activity' => 'Activity',
				     'popular' => 'Popular'
				    ], 
				    isset($order) ? $order : null, 
				    ['id' => 'orderOpts']) }}
</p>
