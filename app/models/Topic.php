<?php

class Topic extends Eloquent {
	protected $fillable = array('title', 'content', 'status', 'user_id', 'filter_type');
	
	public function user() {
		return $this->belongsTo('User');
	}

	public function keywords()
    {
        return $this->hasMany('Keyword');
    }

	/*
	| Many to Many relatioships
	*/
	public function posts(){
		return $this->belongsToMany('Post', 'topics_posts');
	}
	
	public function tags(){
		return $this->belongsToMany('Tag', 'topics_tags');
	}
	
	public function feelings(){
		return $this->belongsToMany('Feeling', 'topics_feelings');
	}

	public static function getLast5Topics(){
		return Topic::orderBy('updated_at', 'DESC')->where('status','=', 1)->take(5)->get();
	}
}