<?php
class Sentis extends Eloquent {
	protected $fillable = array('user_id', 'post_id',  'user_ip_address');
	
	public function user(){
		return $this->belongsTo('User');
	}

	public function post(){
		return $this->belongsTo('Post');
	}

    public function feelings(){
        return $this->belongsToMany('Feeling', 'sentis_feelings', 'sentis_id', 'feeling_id')
            ->withPivot('value');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag', 'sentis_tags');
    }
}
