<?php
use Illuminate\Database\Eloquent\Collection;

class SearchController extends BaseController {
	public function search(){
		$rules = array(
			'search' => 'required|min:3'
		);
		
		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
   	 	{
   	 		return Redirect::back()
  			   		->with('error', 'At least 3 characters must be filled for searching')
  			   		->withInput();
		} else {
			$order = Input::get('order');

			$terms = explode(' ', Input::get('search'));
			$results = 
	    	DB::select(
				DB::raw($this->getSearchQuery($terms, $order))
			);
			
			$postIds = [];
	        foreach ($results as $result) {
	            array_push($postIds, $result->id);
	        }
			
			$posts = Post::find($postIds);

			$sorted = array_flip($postIds);
			
			foreach ($posts as $post) $sorted[$post->id] = $post;
			$sorted = Collection::make(array_values($sorted));

	        return View::make('search.results')
	        	->with('posts', $sorted)
	        	->with('order', Input::get('order'))
	        	->with('search', Input::get('search'));		
		}
	}

  	private function getSearchQuery($terms, $order) {
  		$finalQuery = 'SELECT DISTINCT id FROM (';
  		
  		foreach ($terms as $term) {
			$finalQuery = $finalQuery
					   .' SELECT DISTINCT p.id, 
					   					  p.created_at as created, 
					   					  p.updated_at as updated,
					   					  count(s.post_id) as qtd,
					   					  MAX(s.updated_at) as last_activity
					   	  FROM posts p LEFT JOIN sentis s ON p.id = s.post_id, 
					 	  	   post_contents pc, 
					 	  	   tags t, 
					 	  	   posts_tags pt
						  WHERE p.id = pc.post_id
						  AND   pt.post_id = p.id
						  AND   pt.tag_id = t.id
						  AND   p.status = 1
						  AND   (pc.title like "%' .$term .'%"'
						  		 .' OR 
						 		 pc.content like "%' .$term .'%"'
						 		 .' OR
						 		 t.name like "%' .$term .'%"'
						 	     .')
						  GROUP BY s.post_id

						  UNION  

						  SELECT DISTINCT p.id, 
					   					  p.created_at as created, 
					   					  p.updated_at as updated,
					   					  count(s.post_id) as qtd,
					   					  MAX(s.updated_at) as last_activity
						  FROM posts p, tags t, sentis s, sentis_tags st
						  WHERE p.id = s.post_id
						  AND   st.sentis_id = s.id
						  AND   st.tag_id = t.id
						  AND   p.status = 1
						  AND   t.name like "%' .$term .'%"
						  GROUP BY s.post_id

						  UNION

						  SELECT DISTINCT p.id, 
					   					  p.created_at as created, 
					   					  p.updated_at as updated,
					   					  count(s.post_id) as qtd,
					   					  MAX(s.updated_at) as last_activity
						  FROM posts p, feelings f, sentis s, sentis_feelings sf
						  WHERE p.id = s.post_id
						  AND   s.id = sf.sentis_id
						  AND   sf.feeling_id = f.id
						  AND   p.status = 1
						  AND   f.name like "%' .$term .'%"
						  GROUP BY s.post_id

						  UNION

						  SELECT DISTINCT p.id, 
					   					  p.created_at as created, 
					   					  p.updated_at as updated,
					   					  count(s.post_id) as qtd,
					   					  MAX(s.updated_at) as last_activity
						  FROM  posts p LEFT JOIN sentis s ON p.id = s.post_id, 
								users u
						  WHERE p.user_id = u.id
						  AND   p.status = 1
						  AND   u.username like "%' .$term .'%"
						  GROUP BY s.post_id';
				
				if ($term !== end($terms)){
					$finalQuery = $finalQuery .' UNION ';
				}
		}

		$finalQuery = $finalQuery . ') a'; 

		if ($order === 'activity') {
			$finalQuery = $finalQuery . ' ORDER BY last_activity DESC';
		} else if($order === 'popular'){
			$finalQuery = $finalQuery . ' ORDER BY qtd DESC';
		} else {
			$finalQuery = $finalQuery . ' ORDER BY updated DESC, created DESC';
		}

  		return $finalQuery;
  	}
}

