<?php

class Post extends Eloquent {

	protected $fillable = array('user_id', 
								'anonymous', 
								'post_geolocation', 
								'user_geolocation', 
								'user_ip_address', 
								'privacy_id',
								'media_id',
								'media_url');
	
	public function user(){
		return $this->belongsTo('User');
	}

	public function privacy(){
		return $this->belongsTo('Privacy');
	}

	public function media()
    {
        return $this->belongsTo('Media');
    }
}
