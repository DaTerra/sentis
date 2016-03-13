<div class="sortby">Sort by
	{{ Form::select('orderOpts', 
					['newest' => 'Newest',
				     'activity' => 'Activity',
				     'popular' => 'Popular'
				    ], 
				    isset($order) ? $order : null, 
				    ['id' => 'orderOpts']) }}
</div>
