<?php
class Sentimeter extends Eloquent {
	protected $fillable = array('sentis_id', 'feeling_id', 'value');
	
	public function sentis(){
		return $this->belongsTo('Sentis');
	}

	public function feelings(){
		return this->belongsTo('Feeling')
	}
}
