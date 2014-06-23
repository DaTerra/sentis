<?php

class Post extends Eloquent {

	protected $fillable = array('user_id', 
								'anonymous', 
								'post_geolocation', 
								'user_geolocation', 
								'user_ip_address', 
								'privacy_id');
								
	
	public function user() {
		return $this->belongsTo('User');
	}

	public function privacy(){
		return $this->belongsTo('Privacy');
	}

	public function tags()
    {
        return $this->belongsToMany('Tag', 'posts_tags');
    }

	public function postContent(){
		return $this->hasOne('PostContent');
	}
}
