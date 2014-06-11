<?php

/*
|--------------------------------------------------------------------------
| Applipostion Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an applipostion.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::model('post', 'Post');


Route::get('/', array(
	'as'   => 'home',
	'uses' => 'HomeController@home'
));

Route::get('/user/{username}', array(
	'as'   => 'profile-user',
	'uses' => 'ProfileController@user'
));

/*
| Authenticated group
*/
Route::group(array('before'=>'auth'), function(){
	/* 
	|CSRF Protection
	*/
	Route::group(array('before' =>'csrf'), function(){
		/* 
		| Change password (POST)
		*/
		Route::post('/account/change-password', array(
			'as' 	=> 'account-change-password-post',
			'uses' 	=> 'AccountController@postChangePassword'
		));

		Route::post('/posts/create', array(
			'as' 	=> 'posts-create-post',
			'uses' 	=> 'PostController@postCreate'
		));
	});

	/* 
	| Signout (GET)
	*/
	Route::get('/account/logout', array(
		'as'   => 'account-logout',
		'uses' => 'AccountController@getLogout'
	));
	
	/* 
	| Change Password (GET)
	*/
	Route::get('/account/change-password', array(
		'as'   => 'account-change-password',
		'uses' => 'AccountController@getChangePassword'
	));

	/*
	| Create post (GET)
	*/
	Route::get('posts/create', array(
		'as' 	=> 'posts-create',
		'uses' 	=> 'PostController@getCreate'
	));

});

/*
| Unauthenticated group
*/

Route::group(array('before'=>'guest'), function(){
	/* 
	|CSRF Protection
	*/
	Route::group(array('before' =>'csrf'), function(){
		/* 
		| Create account (POST)
		*/
		Route::post('/account/create', array(
			'as' => 'account-create-post',
			'uses' => 'AccountController@postCreate'
		));

		/* 
		| Login (POST)
		*/
		Route::post('/account/login', array(
			'as' => 'account-login-post',
			'uses' => 'AccountController@postLogin'
		));

		/*
		| Forgot Password (POST)
		*/
		Route::post('/account/forgot-password', array(
			'as' => 'account-forgot-password-post',
			'uses' => 'AccountController@postForgotPassword'
		));
		
	});
	
	/* 
	| Login (GET)
	*/
	Route::get('/account/login', array(
		'as' => 'account-login',
		'uses' => 'AccountController@getLogin'
	));

	/* 
	| Create account (GET)
	*/
	Route::get('/account/create', array(
		'as' => 'account-create',
		'uses' => 'AccountController@getCreate'
	));
	
	/* 
	| Activate account (GET)
	*/
	Route::get('/account/activate/{code}', array(
		'as' => 'account-activate',
		'uses' => 'AccountController@getActivate'
	));
	
	/*
	| Forgot Password (GET)
	*/
	Route::get('/account/forgot-password', array(
		'as' => 'account-forgot-password',
		'uses' => 'AccountController@getForgotPassword'
	));

	/*
	| Recover account (GET)
	*/
	Route::get('/account/recover/{code}', array(
		'as' => 'account-recover',
		'uses' => 'AccountController@getRecover'
	));
	
});	






Route::get('posts/{post}', function(Post $post) {
	return View::make('posts.single')
		->with('post', $post);
});

View::composer('posts.edit', function($view){
	$privacies = Privacy::all();
	$categories = Category::all();
	
	if(count($privacies) > 0){
		$privacy_options = array_combine($privacies->lists('id'),
		$privacies->lists('name'));
	} else {
		$user_options = array(null, 'Unspecified');
	}

	if(count($categories) > 0){
		$category_options = array_combine($categories->lists('id'),
		$categories->lists('name'));
	} else {
		$category_options = array(null, 'Unspecified');
	}

	$view->with('privacy_options', $privacy_options);
	$view->with('category_options', $category_options);
});

