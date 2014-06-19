<?php
class Role extends Eloquent {
	protected $fillable = array('name');
	
 	/**
     * Set timestamps off
     */
    public $timestamps = false;
	
	public function users()
    {
        return $this->belongsToMany('User', 'users_roles');
    }
	
}
