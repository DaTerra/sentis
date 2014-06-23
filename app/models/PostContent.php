<?php

class PostContent extends Eloquent {

	protected $fillable = array('post_id',
								'main_post_id',
								'title',
								'content',
								'source_url',
								'media_id',
								'media_url');

	public $timestamps = false;
	
	public function content(){
		return $this->content;
	}

	public function media()
    {
        return $this->belongsTo('Media');
    }

    public function post() {
    	return $this->belongsTo('Post');
    }
}
