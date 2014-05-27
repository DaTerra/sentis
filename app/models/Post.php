<?php

class Post extends Eloquent {

	protected $fillable = array('content', 'category_id', 'tags', 'version', 
								'anonymous', 'user_id', 'privacy_id');
	
  	
	public function user(){
		return $this->belongsTo('User');
	}

	public function privacy(){
		return $this->belongsTo('Privacy');
	}

	public function category(){
		return $this->belongsTo('Category');
	}
}
