<?php
use Illuminate\Database\Eloquent\Collection;
class Post extends Eloquent {

	protected $fillable = array('user_id', 
								'anonymous', 
								'post_geolocation', 
								'user_geolocation', 
								'user_ip_address', 
								'privacy_id',
								'status');
								
	
	public function user() {
		return $this->belongsTo('User');
	}

	public function privacy(){
		return $this->belongsTo('Privacy');
	}
	
	public function publicTags(){
		$publicTagsByPost = 
	    DB::select(
			DB::raw('SELECT count(*) qtd, t.id, t.name
					 FROM sentis s, tags t, sentis_tags st
					 WHERE s.id = st.sentis_id
					 AND   st.tag_id = t.id
					 AND   s.post_id =' .$this->id 
					 .' GROUP BY st.tag_id')
		);
		return $publicTagsByPost;
	}
	
	public static function getNewestPosts(){
		$query = 'SELECT p.id, 
					     p.updated_at
				  FROM posts p 
				  WHERE p.status = 1
				  ORDER BY updated_at DESC';
        
        return Post::loadPostModelsByIds($query);
	}	

	public static function getLastActivityPosts(){
		$query = 'SELECT p.id, 
						 MAX(s.updated_at) as last_activity
				  FROM posts p 
				  LEFT JOIN sentis s ON p.id = s.post_id
				  WHERE p.status = 1
				  GROUP BY p.id
				  ORDER BY last_activity DESC';
        
        return Post::loadPostModelsByIds($query);
	}
	
	public static function getMostPopularPosts(){
		$query = 'SELECT p.id, 
					     count(s.post_id) as qtd
				  FROM posts p 
			      LEFT JOIN sentis s ON p.id = s.post_id
				  WHERE p.status = 1
				  GROUP BY p.id
			  	  ORDER BY qtd DESC';
        
        return Post::loadPostModelsByIds($query);
	}
	
	public static function feelingsByPosts($postIds) {
		$feelingsByPosts = 
	    DB::select(
			DB::raw('SELECT f.id id,
							f.name feeling, 
							count(*) feelings_left, 
				            avg(sf.value) feeling_avg, 
				            sum(sf.value) feeling_total
				     FROM sentis_feelings sf, feelings f, sentis s, posts p 
				     WHERE p.id = s.post_id
					 AND   s.id = sf.sentis_id
					 AND   f.id = sf.feeling_id
					 AND   p.id IN(' .implode(',', $postIds) .')'
					 .' GROUP BY sf.feeling_id')
		);

		return $feelingsByPosts;
	}

	public function feelings() {
		$feelingsByPost = 
	    DB::select(
			DB::raw('SELECT f.id id,
							f.name feeling, 
							count(*) feelings_left, 
				            avg(sf.value) feeling_avg, 
				            sum(sf.value) feeling_total
				     FROM sentis_feelings sf, feelings f, sentis s, posts p 
				     WHERE p.id = s.post_id
					 AND   s.id = sf.sentis_id
					 AND   f.id = sf.feeling_id
					 AND   p.id =' .$this->id
					 .' GROUP BY sf.feeling_id')
		);

		return $feelingsByPost;
	}
	
	/*
	| POSTS BY FEELING
	*/
	public static function getLastActivityPostsByFeeling($feelingId){
		$query = 'SELECT p.id, 
				        MAX(s.updated_at) as last_activity
				 FROM  posts p, sentis s, sentis_feelings sf
				 WHERE s.post_id = p.id
				 AND   s.id = sf.sentis_id
				 AND   p.status = 1
				 AND   sf.feeling_id =' .$feelingId .' 
				 GROUP BY s.post_id
				 ORDER BY last_activity DESC';
        
        return Post::loadPostModelsByIds($query);
	}
	

	public static function getMostPopularPostsByFeeling($feelingId){
		$query = 'SELECT p.id, 
					     count(s.post_id) as qtd
				  FROM  posts p, sentis s, sentis_feelings sf
				  WHERE s.post_id = p.id
			 	  AND   s.id = sf.sentis_id
			 	  AND   p.status = 1
				  AND   sf.feeling_id = ' .$feelingId .' 
			 	  GROUP BY s.post_id
			 	  ORDER BY qtd DESC';
        
        return Post::loadPostModelsByIds($query);
	}
	
	public static function getNewestPostsByFeeling($feelingId){
		$query = 'SELECT p.id, 
					   	 p.updated_at
				  FROM  posts p, sentis s, sentis_feelings sf
				  WHERE p.id = s.post_id
				  AND   s.id = sf.sentis_id 
				  AND   p.status = 1
				  AND   sf.feeling_id =' .$feelingId .'
				  GROUP BY s.post_id
				  ORDER BY updated_at DESC';
        
        return Post::loadPostModelsByIds($query);
	}

	/*
	| POSTS BY TAG
	*/

	public static function getNewestPostsByTag($tagId){
      //get the posts with tags on posts_tags and sentis_tags
      $query = 'SELECT DISTINCT id FROM (
					SELECT p.id, 
						   p.updated_at as updated
					FROM   posts p, posts_tags pt
					WHERE  p.id = pt.post_id 
					AND    p.status = 1
					AND    pt.tag_id =' .$tagId 
					.' 
					UNION

					SELECT s.post_id, p.updated_at as updated
					FROM   posts p, sentis_tags st, sentis s
					WHERE  st.sentis_id = s.id
					AND    p.id = s.post_id
					AND    p.status = 1
					AND    st.tag_id =' .$tagId .'
				) a 
				ORDER BY updated DESC';
        
        return Post::loadPostModelsByIds($query);
    }
	
	public static function getLastActivityPostsByTag($tagId){
		$query = 'SELECT DISTINCT id FROM (
						SELECT p.id, 
							   MAX(s.updated_at) last_activity
						FROM   posts p LEFT JOIN sentis s ON p.id = s.post_id, 
							   posts_tags pt
						WHERE  p.id = pt.post_id 
						AND    p.status = 1
						AND    pt.tag_id =' .$tagId .' 
						GROUP BY p.id

						UNION

						SELECT s.post_id, 
							   MAX(s.updated_at) as last_activity
						FROM   posts p, 
							   sentis_tags st, 
							   sentis s
						WHERE  st.sentis_id = s.id
						AND    p.id = s.post_id
						AND    p.status = 1
						AND    st.tag_id =' .$tagId .' 
						GROUP BY p.id
					) a 
					ORDER BY last_activity DESC';
        
        return Post::loadPostModelsByIds($query);
	}
	
	public static function getMostPopularPostsByTag($tagId){
		$query = 'SELECT DISTINCT id FROM (
						SELECT p.id, 
							   count(s.post_id) as qtd
						FROM   posts p LEFT JOIN sentis s ON p.id = s.post_id, 
							   posts_tags pt
						WHERE  p.id = pt.post_id 
						AND    p.status = 1
						AND    pt.tag_id =' .$tagId .' 
						GROUP BY p.id

						UNION

						SELECT s.post_id, 
							   count(s.post_id) as qtd
						FROM   posts p, sentis_tags st, sentis s
						WHERE  st.sentis_id = s.id
						AND    p.id = s.post_id
						AND    p.status = 1
						AND    st.tag_id =' .$tagId .' 
						GROUP BY p.id
					) a 
					ORDER BY qtd DESC';
        
        return Post::loadPostModelsByIds($query);
	}
	
	public static function getMostPopularPostsByTagsQuery($tagIds){
		return '(SELECT p.id, 
					   count(s.post_id) as qtd
				FROM   posts p LEFT JOIN sentis s ON p.id = s.post_id, 
					   posts_tags pt
				WHERE  p.id = pt.post_id 
				AND    p.status = 1
				AND    pt.tag_id IN (' .$tagIds .') 
				GROUP BY p.id)
				
				UNION

				(SELECT s.post_id, 
					   count(s.post_id) as qtd
				FROM   posts p, sentis_tags st, sentis s
				WHERE  st.sentis_id = s.id
				AND    p.id = s.post_id
				AND    p.status = 1
				AND    st.tag_id IN (' .$tagIds .') 
				GROUP BY p.id)';
	}
	
	public static function getMostPopularPostsByFeelingsQuery($feelingIds){
		return '(SELECT p.id, 
				       count(s.post_id) as qtd
				FROM  posts p, sentis s, sentis_feelings sf
				WHERE s.post_id = p.id
			 	AND   s.id = sf.sentis_id
			 	AND   p.status = 1
				AND   sf.feeling_id IN(' .$feelingIds .')
			 	GROUP BY s.post_id
			 	ORDER BY qtd DESC)';
	}

	public static function getMostPopularPostsByKeywordsQuery($keywords){
		$finalQuery = '';
		$i = 1;
		$count = count($keywords);
		foreach ($keywords as $keyword) {
			$finalQuery = $finalQuery 
				.'(SELECT p.id, 
					     count(s.post_id) as qtd
				  FROM posts p LEFT JOIN sentis s ON p.id = s.post_id, 
				       post_contents pc
				  WHERE p.id = pc.post_id
				  AND   p.status = 1
				  AND   (pc.title like "%' .$keyword->keyword .'%"'
					    .' OR 
					    pc.content like "%' .$keyword->keyword .'%")
				  GROUP BY p.id
			      ORDER BY qtd DESC)';
			
			if ($i !== $count){
				$finalQuery = $finalQuery .' UNION ';
			}
			$i = $i +1;
		}
		return $finalQuery;			
	}

	public static function getMostPopularPostsByTopic($topic) {
		$query = 'SELECT DISTINCT id FROM (';
		$filterUsed = false;
		//check the tags and increase the query
		if(count($topic->tags) > 0){
			$filterUsed = true;
			$tagIds = [];
        	foreach ($topic->tags as $tag) {
            	array_push($tagIds, $tag->id);
            }
            $query = $query . Post::getMostPopularPostsByTagsQuery(implode(',', $tagIds));
        }
		
		//check the tags and increase the query
		if(count($topic->feelings) > 0){
			if($filterUsed){
				$query = $query .' UNION ';
			}
			$filterUsed = true;
			$feelingIds = [];
        	foreach ($topic->feelings as $feeling) {
            	array_push($feelingIds, $feeling->id);
            }
            $query = $query . Post::getMostPopularPostsByFeelingsQuery(implode(',', $feelingIds));
		}
	
		//check the keywords and increase the query
		if(count($topic->keywords) > 0){
			if($filterUsed){
				$query = $query .' UNION ';
			}
			$filterUsed = true;
			$query = $query . Post::getMostPopularPostsByKeywordsQuery($topic->keywords);
		}		

		$query = $query .') a ORDER BY qtd DESC';
		
		return Post::loadPostModelsByIds($query);
	}

	public static function getMostPopularPostsByTopicExclusively($topic) {
		$query = 'SELECT DISTINCT id FROM (
					(SELECT p.id, 
						   count(s.post_id) as qtd
					 FROM   posts p LEFT JOIN sentis s ON p.id = s.post_id, 
						    posts_tags pt,
						    sentis_feelings sf,
						    post_contents pc
					 WHERE  p.id = pt.post_id 
					 AND    s.id = sf.sentis_id
					 AND    p.id = pc.post_id
					 AND    p.status = 1';
		
		//check the tags and increase the query
		if(count($topic->tags) > 0){
			$tagIds = [];
        	foreach ($topic->tags as $tag) {
            	array_push($tagIds, $tag->id);
            }
            $query = $query . ' AND    pt.tag_id IN (' .implode(',', $tagIds) .')';
        }
		
		//check the feelings and increase the query
		if(count($topic->feelings) > 0){
			$feelingIds = [];
        	foreach ($topic->feelings as $feeling) {
            	array_push($feelingIds, $feeling->id);
            }
            $query = $query . ' AND    sf.feeling_id IN (' .implode(',', $feelingIds) .')';
		}
	
		//check the keywords and increase the query
		if(count($topic->keywords) > 0){
			
			foreach ($topic->keywords as $keyword) {
				$query = 
					$query . ' AND (pc.title like "%'   .$keyword->keyword .'%" '
						   . ' OR '
						   . ' pc.content like "%' .$keyword->keyword .'%")';
			}
		}
		$query = $query .' GROUP BY p.id) ';

		//fazer union com sentis tags
		
		$query = $query .'UNION 
					  	  ( SELECT s.post_id, 
								   count(s.post_id) as qtd
							FROM   posts p, 
								   sentis_tags st, 
								   sentis s,
								   posts_tags pt,
								   sentis_feelings sf,
								   post_contents pc
							WHERE  st.sentis_id = s.id
							AND    p.id = s.post_id
							AND    s.id = sf.sentis_id
							AND    p.id = pc.post_id
							AND    p.status = 1';

		//check the tags and increase the query
		if(count($topic->tags) > 0){
			$tagIds = [];
        	foreach ($topic->tags as $tag) {
            	array_push($tagIds, $tag->id);
            }
            $query = $query . ' AND    st.tag_id IN (' .implode(',', $tagIds) .')';
        }
		
		//check the feelings and increase the query
		if(count($topic->feelings) > 0){
			$feelingIds = [];
        	foreach ($topic->feelings as $feeling) {
            	array_push($feelingIds, $feeling->id);
            }
            $query = $query . ' AND    sf.feeling_id IN (' .implode(',', $feelingIds) .')';
		}
	
		//check the keywords and increase the query
		if(count($topic->keywords) > 0){
			
			foreach ($topic->keywords as $keyword) {
				$query = 
					$query . ' AND (pc.title like "%'   .$keyword->keyword .'%" '
						   . ' OR '
						   . ' pc.content like "%' .$keyword->keyword .'%")';
			}
		}
		$query = $query .' GROUP BY p.id) ';

		$query = $query .') a ORDER BY qtd DESC';
		return Post::loadPostModelsByIds($query);
	}
	public function tags()
    {
        return $this->belongsToMany('Tag', 'posts_tags');
    }
	
	public function topics(){
    	return $this->belongsToMany('Topic', 'topics_posts');
    }

	public function postContent(){
		return $this->hasOne('PostContent');
	}

	public function sentis() {
		return $this->hasMany('Sentis');
	}

	private static function orderPosts($posts, $postIds){
		$sorted = array_flip($postIds);
					
		foreach ($posts as $post) $sorted[$post->id] = $post;
		$sorted = Collection::make(array_values($sorted));

        return $sorted;
	}

	private static function loadPostModelsByIds($query) {
		$posts = 
        DB::select(
            DB::raw($query)
        );

		$postIds = [];
        foreach ($posts as $post) {
            array_push($postIds, $post->id);    
        }
        
        $posts = Post::find($postIds);
        return Post::orderPosts($posts, $postIds);
	}
}
