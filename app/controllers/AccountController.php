<?php

class AccountController extends BaseController {

	public function getCreate(){
		return View::make('account.create');
	}
	
	public function postCreate (){
		$rules = array(
			'email' 	=> 'required|max:50|email|unique:users',
			'username'	=> 'required|max:20|min:3|unique:users',
			'password'  => 'required|min:6',
        	'password_confirmation'=> 'required|same:password'
		);

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
   	 	{
        	return Redirect::route('account-create')
        		->withErrors($validator)
        		->withInput();
    	} else {
    		//Create account
			$email    = Input::get('email');
			$username = Input::get('username');
			$password = Input::get('password');
			
			//activation code
			$code = str_random(60);

			$user = User::create(array(
				'email' 	=> $email,
				'username'  => $username,
				'password'  => Hash::make($password),
				'code'      => $code,
				'active'    => 0
			));

			if($user){
				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user) {
					$message->to($user->email, $user->username)->subject('Sentis - Activate your account');
				});
				
				return Redirect::route('home')
					->with('message', 'Your account has been created! We have sent you an email to activate your account.');
			}
		}
	}

	public function getActivate($code) {
		$user = User::where('code', '=', $code)->where('active', '=', 0);

		if($user->count()) {
			$user = $user->first();
			
			//update user to activate state
			$user->active = 1;
			$user->code = '';
			
			if($user->save()){
				return Redirect::route('home')
					->with('message', 'Activated! You can now sign in!');
			}
		}

		return Redirect::route('account-login')
			->with('error', 'We could not activate your account. Try again later.');
	}

	public function getLogin() {
		return View::make('account.login');
	}

	public function postLogin()
	{
		$rules = array(
			'username' 	=> 'required',
			'password'  => 'required'
		);

		$validator = Validator::make(Input::all(), $rules);

		if($validator->fails()) {
			Redirect::route('account-login')
				->withErrors($validator)
				->withInput();
		} else {
			
			$remember = (Input::has('remember')) ?  true : false;
			
			$auth = Auth::attempt(array(
				'username' => Input::get('username'),
				'password' => Input::get('password'),
				'active'   => 1
			), $remember);


			if($auth) {
				return Redirect::intended('/');	
			} else {
				return Redirect::route('account-login')
					->with('error', 'Username/password wrong, or account not activated.');				
			}
		}

		return Redirect::route('account-login')
			->with('error', 'There was a problem with your login.');
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::route('account-login');
	}

	public function getChangePassword() {
		return View::make('account.password');
	}

	public function postChangePassword() {
		$rules = array(
			'old_password' => 'required',
			'password'  => 'required|min:6',
			'password_confirmation' => 'required|same:password'
		);

		$validator = Validator::make(Input::all(), $rules);		

		if($validator->fails()) {
			return Redirect::route('account-change-password')
				->withErrors($validator);
		} else {
			$user 			= User::find(Auth::user()->id);
			$old_password 	= Input::get('old_password');
			$password 		= Input::get('password');

			if(Hash::check($old_password, $user->getAuthPassword())){
				$user->password = Hash::make($password);
				if($user->save()){
					return Redirect::route('home')
						->with('message', 'Your password has been changed.');
				}
			} else {
				return Redirect::route('account-change-password')
					->with('error', 'Your old password is incorrect.');
			}

		}

		return Redirect::route('account-change-password')
			->with('error', 'Your password could not be changed. Please try again.');
	}

	public function getForgotPassword() {
		return View::make('account.forgot');
	}	

	public function postForgotPassword() {
		$rules = array(
			'email' => 'required|email'
		);

		$validator = Validator::make(Input::all() , $rules);		
		
		if($validator->fails()) {
			return Redirect::route('account-forgot-password')
				->withErrors($validator)
				->withInput();
		} else {

			$user = User::where('email', '=', Input::get('email'));
			
			if($user->count()) {
				$user = $user->first();
				
				//Generate new code and password
				$code 				 = str_random(60);
				$password 			 = str_random(10);
				$user->code 		 = $code;
				$user->password_temp = Hash::make($password);

				if($user->save()) {
					Mail::send('emails.auth.forgot', array('link' => URL::route('account-recover', $code), 'username' => $user->username, 'password' => $password), function($message) use ($user) {
						$message->to($user->email, $user->username)->subject('Sentis - Your new password.');
					});

					return Redirect::route('home')
						->with('message', 'We have sent you a new password by email.');
				}
			}
		}

		return Redirect::route('account-forgot-password')
			->with('error', 'Could not request new password. Please try again.');
	}

	public function getRecover($code) {
		$user = User::where('code', '=', $code)
					->where('password_temp', '!=', '');

		if($user->count()) {
			$user = $user->first();
			$user->password = $user->password_temp;
			$user->password_temp = '';
			$user->code = '';
			
			if($user->save()) {
				return Redirect::route('home')
						->with('message', 'Your account has been recovered and you can sign in with you new password.');
			}			  
		}

		return Redirect::route('home')
						->with('error', 'Could not recover your account. Please try again.');
	}	
}

