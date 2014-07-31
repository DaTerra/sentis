<?php

class ProfileController extends BaseController {


	public function user($username)
	{
		$user = User::where('username', '=', $username);
		
		if($user->count()){
			$user = $user->first();

			$user->posts = Post::where('user_id', '=', $user->id)
							   ->where('status', '=', 1)
							   ->get();
			
			$user->topics = Topic::orderBy('updated_at', 'DESC')
								  ->where('status','=',1)
								  ->where('user_id','=',$user->id)
								  ->get();

			return View::make('profile.user')
				->with('user', $user);	
		}

        return Redirect::route('home')
            ->with('error', 'We could not load the profile page. Please try again later.');

	}
	
	public function follow($username)
	{
		$user = User::where('username', '=', $username);
		$authUser = Auth::user();

		if($user->count()){
			$user = $user->first();
			if($authUser->canFollow($user)){
				$authUser->follow()->save($user);
				return Redirect::route('profile-user', $user->username)
            		->with('error', 'You are now following this user.');
			} else {
				return Redirect::route('profile-user', $user->username)
            		->with('error', 'You are already following this user.');
			}
			
		}

        return Redirect::route('home')
            ->with('error', 'We could not load the profile page. Please try again later.');

	}

	public function unfollow($username)
	{
		$user = User::where('username', '=', $username);
		$authUser = Auth::user();

		if($user->count()){
			$user = $user->first();
			$authUser->follow()->detach($user);
			return Redirect::route('profile-user', $user->username)
        		->with('error', 'You are not following this user anymore.');
		}

        return Redirect::route('home')
            ->with('error', 'We could not load the profile page. Please try again later.');

	}
}
