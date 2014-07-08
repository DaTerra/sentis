<?php

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
}
