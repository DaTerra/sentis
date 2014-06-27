<?php
class Tag extends Eloquent {
	protected $fillable = array('name', 'description');
	
 	/**
     * Set timestamps off
     */
    public $timestamps = false;
	
	public function posts()
    {
        return $this->belongsToMany('Post', 'posts_tags');
    }
	
}
