<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;


class User extends Eloquent implements UserInterface, RemindableInterface {

	protected $fillable = array('email', 'username', 'password', 'password_temp', 'code', 'active', 'avatar_url', 'facebook_id', 'signed_up_by_form');

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';
	

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password');

	/**
	 * Get the unique identifier for the user.
	 *
	 * @return mixed
	 */
	public function getAuthIdentifier()
	{
		return $this->getKey();
	}

	/**
	 * Get the password for the user.
	 *
	 * @return string
	 */
	public function getAuthPassword()
	{
		return $this->password;
	}

	/**
	 * Get the token value for the "remember me" session.
	 *
	 * @return string
	 */
	public function getRememberToken()
	{
		return $this->remember_token;
	}

	/**
	 * Set the token value for the "remember me" session.
	 *
	 * @param  string  $value
	 * @return void
	 */
	public function setRememberToken($value)
	{
		$this->remember_token = $value;
	}

	/**
	 * Get the column name for the "remember me" token.
	 *
	 * @return string
	 */
	public function getRememberTokenName()
	{
		return 'remember_token';
	}

	/**
	 * Get the e-mail address where password reminders are sent.
	 *
	 * @return string
	 */
	public function getReminderEmail()
	{
		return $this->email;
	} 
	
	
	public function posts(){
		return $this->hasMany('Post');
	}

	public function topics(){
		return $this->hasMany('Topic');
	}

	public function channels()
	{
	  return $this->hasMany('Channel');
	}

	public function sentis(){
		return $this->hasMany('Sentis');
	}
	
	public function ownsChannel(Channel $channel){
		return $this->id == $channel->user_id;
	}

	public function ownsTopic(Topic $topic){
		return $this->id == $topic->user_id;
	}

	public function owns(Post $post){
		return $this->id == $post->user_id;
	}
	
	public function canEdit(Post $post){
		return $this->owns($post);
	}
	
	public function canEditTopic(Topic $topic){
		return $this->ownsTopic($topic);
	}

	public function canEditChannel(Channel $channel){
		return $this->ownsChannel($channel);
	}

	public function canChangePassword(User $user){
		return $this->id == $user->id;
	}

	public function roles()
    {
        return $this->belongsToMany('Role', 'users_roles');
    }

    /**
	 * User following relationship
	 */
	public function follow()
	{
	  return $this->belongsToMany('User', 'user_follows', 'user_id', 'follow_id');
	}
	
	public function canFollow($user) {
		$diferentUser = Auth::user() && Auth::user()->id !== $user->id;
		$followingList = Auth::user()->follow;
		$alreadyFollowing = false;
		if($followingList){
			foreach ($followingList as $following) {
				if($user->id === $following->id){
					$alreadyFollowing = true;
				}	
			}
		}
		
		return $diferentUser && !$alreadyFollowing;
	}

	/**
	 * User followers relationship
	 */
	public function followers()
	{
	  return $this->belongsToMany('User', 'user_follows', 'follow_id', 'user_id');
	}

    public function hasRole($check)
    {
        return in_array($check, array_fetch($this->roles->toArray(), 'name'));
    }
	
    /**
     * Add roles to user depending on each system
     */
    public function makeRoles($title)
    {
    	$assigned_roles = array();
 
        $roles_id = array_fetch(Role::all()->toArray(), 'id');
        $roles_name = array_fetch(Role::all()->toArray(), 'name');
 		$roles = array_combine($roles_id , $roles_name);
		switch ($title) {
            case 'admin':
                $assigned_roles[] = $this->getIdInArray($roles, 'ADM');
                $assigned_roles[] = $this->getIdInArray($roles, 'SME');
                $assigned_roles[] = $this->getIdInArray($roles, 'SUS');
                break;
            case 'sus':
                $assigned_roles[] = $this->getIdInArray($roles, 'SUS');
                break;
            case 'sme':
                $assigned_roles[] = $this->getIdInArray($roles, 'SME');
                $assigned_roles[] = $this->getIdInArray($roles, 'SUS');
                break;
            default:
                throw new Exception("The employee status entered does not exist");
        }
 		
        $this->roles()->attach($assigned_roles);
    }

    private function getIdInArray($array, $term)
    {
    	foreach ($array as $key => $value) {
            if ($value == $term) {
                return $key;
            }
        }
 
        throw new UnexpectedValueException;
    }
}
