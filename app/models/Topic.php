<?php

class Topic extends Eloquent {
	protected $fillable = array('title', 'content', 'status', 'user_id');
	
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
	public function postsByTopic() {
		return Post::all();
	}
	public function posts(){
		return $this->belongsToMany('Post', 'topics_posts');
	}
	
	public function tags(){
		return $this->belongsToMany('Tag', 'topics_tags');
	}
	
	public function feelings(){
		return $this->belongsToMany('Feeling', 'topics_feelings');
	}
}