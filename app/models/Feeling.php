<?php
class Feeling extends Eloquent {
	protected $fillable = array('name', 'icon');
	public $timestamps = false;
	
	public function sentimeters(){
		return $this->hasMany('Sentimeter');
	}
}
