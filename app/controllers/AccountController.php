<?php

class AccountController extends BaseController {

	public function getCreate(){
		return View::make('account.create');
	}
	
	public function postCreate (){
		$rules = array(
			'email' 	=> 'required|max:50|email',
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
			
			$user = User::where('email', '=', $email);

			if($user->count()){
				//user already signed up by fb account
				$user = $user->first();
				
				if($user->signed_up_by_form == 1){
					return Redirect::route('account-create')
						->with('error', 'Email already in use!');
				} else { 
					if($user->facebook_id != '') {
						$user->username = $username;
						$user->password = Hash::make($password);
						$user->signed_up_by_form  = 1;
						$user->save();
						if($user){
							return Redirect::route('home')
								->with('message', 'Your account has been created!');
						}		
					} 
				}
			} else {
				$default_avatar_url = URL::to('uploads/default-avatar.png');
				//activation code
				$code = str_random(60);
				
				$user = User::create(array(
					'email' 	 		=> $email,
					'username'   		=> $username,
					'password'   		=> Hash::make($password),
					'code'       		=> $code,
					'active'     		=> 0,
					'avatar_url' 		=> $default_avatar_url,
					'signed_up_by_form' => 1
				));

                $user->makeRoles('sus');
				
				if($user){
					Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $code), 'username' => $username), function($message) use ($user) {
						$message->to($user->email, $user->username)->subject('Sentis - Activate your account');
					});
					return Redirect::route('home')
						->with('message', 'Your account has been created! We have sent you an email to activate your account.');
				}		
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
				return Redirect::route('account-login')
					->with('message', 'Activated! You can now sign in!');
			}
		}

		return Redirect::route('account-login')
			->with('error', 'We could not activate your account. Try again later.');
	}
	
	public function getLessPopularPosts(){
		Post::getLessPopularPosts();
		return "ok";
	}
		
	public function getLoginFB(){
		$userFB = Social::facebook('user');
		$user = null;
		if($userFB) {
			
			$user = User::where('email', '=', $userFB->email);
			
			//verifies if users is already signed up by his fb email
			if($user->count()){
				
				//if its already signed up update field fb id and create user session
				$user = $user->first();
				
				if((!isset($user->facebook_id) || trim($user->facebook_id)==='')) {
					$user->facebook_id = $userFB->id;
					$user->active = 1;	
					$user->code   = '';
					if($user->save()){
						Debugbar::info('FBID updated... Authorizing user');
					}
				}	
			} else { //not signed up
				$email    = $userFB->email;
				$facebook_id = $userFB->id;
				$username = $userFB->email;
				$default_avatar_url = URL::to('uploads/default-avatar.png');
				
				$user = User::create(array(
					'email' 	  => $email,
					'username'	  => $username,
					'facebook_id' => $facebook_id,
					'avatar_url'  => $default_avatar_url,
					'active'      => 1
				));

				$user->makeRoles('sus');

				if($user){
					Debugbar::info('User successfully created!');
				}
			}
			
			Auth::login($user);
			return Redirect::intended('/');	
		}
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

		return Redirect::route('account-login');
	}

	public function getLogout() {
		Auth::logout();
		return Redirect::route('home')
			->with('message', 'You were successfully signed out');
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

			$user = User::where('email', '=', Input::get('email'))
						->where('signed_up_by_form', '=', 1);
			
			if($user->count()) {
				$user = $user->first();
				
				//Generate new code and password
				$code 				 = str_random(60);
				$user->code 		 = $code;
				
				if($user->save()) {
					Mail::send('emails.auth.forgot', array('link' => URL::route('account-recover', $code), 'username' => $user->username), function($message) use ($user) {
						$message->to($user->email, $user->username)->subject('Sentis - Account Recovery.');
					});
					return Redirect::route('home')
						->with('message', 'We have sent you instruction to reset your password by email.');
				}
			}
		}

		return Redirect::route('account-forgot-password')
			->with('error', 'Could not request new password. Please verify the email and try again.');
	}
	
	public function postRecover($code) {
		$rules = array(
			'password'  => 'required|min:6',
			'password_confirmation' => 'required|same:password'
		);

		$validator = Validator::make(Input::all(), $rules);		

		if($validator->fails()) {
			return Redirect::route('account-recover', $code)
				->withErrors($validator);
		} else {
			
			$user = User::where('code', '=', $code);
			if($user->count()) {
				
				$user = $user->first();
				$password 		= Input::get('password');
				$user->password = Hash::make($password);
				
				if($user->save()){
					return Redirect::route('account-login')
						->with('message', 'Your account was successfully recovered.');
				}

			} else {
				return Redirect::route('account-recover', $code)
					->with('error', 'We could not recover your account. Please try again.');
			}

		}

		return Redirect::route('account-recover', $code)
			->with('error', 'We could not recover your account. Please try again.');
	}

	public function getRecover($code) {
		$user = User::where('code', '=', $code);
		if($user->count()) {
			return View::make('account.recover_form')
				->with('code', $code);
		} else {
			return Redirect::route('home')
				->with('error', 'We could not recover your account.');
		}
	}

	public function getUploadAvatar() {
		return View::make('account.avatar');
	}	

	public function postUploadAvatar() {
		
		$rules = array(
			'avatar' => 'required|image|mimes:jpeg,bmp,png|max:500'
		);

		$validator = Validator::make(Input::all() , $rules);
		
		if($validator->fails()) {
			return Redirect::route('account-upload-avatar')
				->withErrors($validator)
				->withInput();
		} else {
			$file = Input::file('avatar');
 			$destinationPath = public_path() .'/uploads/'.sha1(Auth::user()->id);
 			$filename  = $file->getClientOriginalName();
			
		 	$upload_success = Input::file('avatar')->move($destinationPath, $filename);
			
		 	if($upload_success) {
		 		$user = User::find(Auth::user()->id);
		 	   	//update user avatar url
		 	   	$avatar_url = URL::to('uploads/'.sha1(Auth::user()->id).'/'.$filename);
		 	   	$user->avatar_url = $avatar_url;

			   	if($user->save()){
			  		return Redirect::route('home')
			 			->with('message', 'You have successfully uploaded your avatar!');
				}
			} else {
				return Redirect::route('home')
					->with('error', 'An error occured while uploading your avatar. Please try again later.');
			}
		}	
	}	
	public function getSendActivationEmail() {
		return View::make('account.send_activation_email');
	}

	public function postSendActivationEmail() {
		$rules = array(
			'email' => 'required|email'
		);

		$validator = Validator::make(Input::all() , $rules);		
		
		if($validator->fails()) {
			return Redirect::route('account-send-activation-email')
				->withErrors($validator)
				->withInput();
		} else {
			$user = User::where('email', '=', Input::get('email'))
						->where('signed_up_by_form', '=', 1)
						->where('active', 0);
			if($user->count()) {
				$user = $user->first();
				Mail::send('emails.auth.activate', array('link' => URL::route('account-activate', $user->code), 'username' => $user->username), function($message) use ($user) {
					$message->to($user->email, $user->username)->subject('Sentis - Activate your account');
				});
				return Redirect::route('home')
					->with('message', 'We have sent you an email to activate your account.');
			}		
		}

		return Redirect::route('account-send-activation-email')
			->with('error', 'Could not send activation email. Please verify the email and try again.');
	}
}