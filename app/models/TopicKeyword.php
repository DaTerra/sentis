<?php

class TopicKeyword extends Eloquent {
	protected $fillable = array('topic_id', 'keyword');
	
	public function topic(){
		return $this->belongsTo('Topic');
	}
}