<?php

class Keyword extends Eloquent {
	protected $fillable = array('topic_id', 'keyword');
	public $timestamps = false;
		
	public function topic()
    {
        return $this->belongsTo('Topic');
    }
}