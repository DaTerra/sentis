<?php

class Channel extends Eloquent {
	protected $fillable = array('name', 'status', 'user_id');
	
	public function user() {
		return $this->belongsTo('User');
	}

	/*
	| Many to Many relatioships
	*/
	public function topics(){
		return $this->belongsToMany('Topic', 'channels_topics');
	}
}