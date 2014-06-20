<?php

class Media extends Eloquent {

	protected $fillable = array('type');
	/**
     * Set timestamps off
     */
    public $timestamps = false;

    public function posts()
    {
        return $this->hasMany('Post');
    }
}
