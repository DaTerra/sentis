<?php

class UserController extends BaseController {

	public function login()
	{
		if(Auth::attempt(Input::only('username', 'password'))) {
			return Redirect::intended('posts');
		} else {
			return Redirect::back()
				->withInput()
				->with('error', "Invalid credentials");
		}
	}

	public function signup (){
		$rules = array(
			'email' 	=> 'required|Email|unique:users',
			'username'	=> 'required|min:5',
			'password'  =>'Required|AlphaNum|Between:4,8|Confirmed',
        	'password_confirmation'=>'Required|AlphaNum|Between:4,8'
		);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
   	 	{
        	return Redirect::back()
        		->withErrors($validator)
        		->withInput();
    	} else {
			$user = User::create(Input::all());
			$user->password = Hash::make(Input::get('password'));
			if($user->save()){
				return Redirect::to('login/')
					->with('message', 'Successfully created user!');
			} else {
				return Redirect::back()
					->with('error', 'Error creating user!');
			}	
    	}
	}
}
