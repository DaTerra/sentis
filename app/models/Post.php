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
		$posts = 
        DB::select(
            DB::raw('SELECT p.id, 
						    p.updated_at
					 FROM posts p 
					 WHERE p.status = 1
					 ORDER BY updated_at DESC')
        );
        
        return Post::loadPostModelsByIds($posts);
	}	

	public static function getLastActivityPosts(){
		$posts = 
        DB::select(
            DB::raw('SELECT p.id, 
						    MAX(s.updated_at) as last_activity
					 FROM posts p 
					 LEFT JOIN sentis s ON p.id = s.post_id
					 WHERE p.status = 1
					 GROUP BY s.post_id
					 ORDER BY last_activity DESC')
        );
        
        return Post::loadPostModelsByIds($posts);
	}
	
	public static function getMostPopularPosts(){
		$posts = 
        DB::select(
            DB::raw('SELECT p.id, 
						    count(s.post_id) as qtd
					 FROM posts p 
					 LEFT JOIN sentis s ON p.id = s.post_id
					 WHERE p.status = 1
					 GROUP BY s.post_id
					 ORDER BY qtd DESC')
        );
        
        return Post::loadPostModelsByIds($posts);
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

	public static function getLastActivityPostsByFeeling($feelingId){
		$posts = 
        DB::select(
            DB::raw('SELECT p.id, 
					 MAX(s.updated_at) as last_activity
				FROM  posts p, sentis s, sentis_feelings sf
				WHERE s.post_id = p.id
				AND   s.id = sf.sentis_id
				AND   p.status = 1
				AND   sf.feeling_id =' .$feelingId .' 
				GROUP BY s.post_id
				ORDER BY last_activity DESC')
        );
        
        return Post::loadPostModelsByIds($posts);
	}
	

	public static function getMostPopularPostsByFeeling($feelingId){
		$posts = 
        DB::select(
            DB::raw('SELECT p.id, 
						    count(s.post_id) as qtd
					 FROM  posts p, sentis s, sentis_feelings sf
					 WHERE s.post_id = p.id
					 AND   s.id = sf.sentis_id
					 AND   p.status = 1
					 AND   sf.feeling_id = ' .$feelingId .' 
					 GROUP BY s.post_id
					 ORDER BY qtd DESC')
        );
        
        return Post::loadPostModelsByIds($posts);
	}
	
	public static function getNewestPostsByFeeling($feelingId){
		$posts = 
        DB::select(
            DB::raw('SELECT p.id, 
						    p.updated_at
					FROM  posts p, sentis s, sentis_feelings sf
					WHERE p.id = s.post_id
					AND   s.id = sf.sentis_id 
					AND   p.status = 1
					AND   sf.feeling_id =' .$feelingId .'
					GROUP BY s.post_id
					ORDER BY updated_at DESC')
        );
        
        return Post::loadPostModelsByIds($posts);
	}

	public function tags()
    {
        return $this->belongsToMany('Tag', 'posts_tags');
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

	private static function loadPostModelsByIds($posts) {
		$postIds = [];
        foreach ($posts as $post) {
            array_push($postIds, $post->id);    
        }
        
        $posts = Post::find($postIds);
        return Post::orderPosts($posts, $postIds);
	}
}
