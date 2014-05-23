<?php
class Category extends Eloquent {
	protected $fillable = array('name');
	public $timestamps = false;
	
	public function posts(){
		return $this->hasMany('Post');
	}
}
