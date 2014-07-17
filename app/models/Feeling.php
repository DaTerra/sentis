<?php
class Feeling extends Eloquent {
	protected $fillable = array('name', 'description', 'order', 'icon');
	public $timestamps = false;
	
	public function sentis(){
		return $this->belongsToMany('Sentis', 'sentis_feelings','feeling_id', 'sentis_id')
            ->withPivot('value');
	}
}
