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

			return View::make('profile.user')
				->with('user', $user);	
		}

        return Redirect::route('home')
            ->with('error', 'We could not load the profile page. Please try again later.');

	}

	
}
