<?php
class Sentis extends Eloquent {
	protected $fillable = array('user_id', 'post_id',  'geolocation');
	
	public function user(){
		return $this->belongsTo('User');
	}

	public function post(){
		return this->belongsTo('Post')
	}

	public function sentimeters(){
		return $this->hasMany('Sentimeter');
	}
}
