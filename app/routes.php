<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an applipostion.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::model('post', 'Post');

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

		/* 
		| Post Create (POST)
		*/
		Route::post('/posts/create', array(
			'as' 	=> 'posts-create-post',
			'uses' 	=> 'PostController@postCreate'
		));

		/* 
		| Upload Avatar (POST)
		*/
		Route::post('/account/upload-avatar', array(
			'as'	=> 'account-upload-avatar-post',
			'uses'	=> 'AccountController@postUploadAvatar'
		));
		
		/*
		| Post Delete
		*/
		Route::delete('posts/{id}/delete', array(
			'as' 	=> 'posts-delete',
			'uses' 	=> 'PostController@postDelete'
		));

		/*
		| Post Update
		*/
		Route::put('posts/{id}/edit', array(
			'as'	=> 'posts-edit',
			'uses'	=> 'PostController@postEdit'
		));

		/*
		| Topics ADM Create (POST)
		*/
		Route::post('/topics/create', array(
			'as'	=> 'topics-create-post',
			'uses'	=> 'TopicController@postCreate'
		));

		/*
		| Topic Delete
		*/
		Route::delete('topics/{id}/delete', array(
			'as' 	=> 'topics-delete',
			'uses' 	=> 'TopicController@postDelete'
		));
	});

	/* 
	| Signout (GET)
	*/
	Route::get('/account/logout', array(
		'as'   	=> 'account-logout',
		'uses' 	=> 'AccountController@getLogout'
	));
	
	/* 
	| Change Password (GET)
	*/
	Route::get('/account/change-password', array(
		'as'   	=> 'account-change-password',
		'uses' 	=> 'AccountController@getChangePassword'
	));

	/*
	| Create post (GET)
	*/
	Route::get('/posts/create', array(
		'as' 	=> 'posts-create',
		'uses' 	=> 'PostController@getCreate'
	));
	
	/* 
	| Upload Avatar (GET)
	*/
	Route::get('/account/upload-avatar', array(
		'as'   	=> 'account-upload-avatar',
		'uses' 	=> 'AccountController@getUploadAvatar'
	));

	/* 
	| Delete Post (GET)
	*/
	Route::get('/posts/{id}/delete', array(
		'as'  	=> 'posts-delete',
		'uses'	=> 'PostController@getDelete'
	));

	/*
	| Edit Post (GET)
	*/
	Route::get('/posts/{id}/edit', array(
		'as'	=> 'posts-edit',
		'uses'	=> 'PostController@getEdit'
	));

	/*
	| Topics ADM Create (GET)
	*/
	Route::get('/topics/create', array(
		'as'	=> 'topics-create',
		'uses'	=> 'TopicController@getCreate'
	));

	/* 
	| Delete Topic (GET)
	*/
	Route::get('/topics/{id}/delete', array(
		'as'  	=> 'topics-delete',
		'uses'	=> 'TopicController@getDelete'
	));

	/* 
	| Activate / Desactivate Topic (GET)
	*/
	Route::get('topics/{id}/status/{statusCode}', array(
		'as'    => 'topics-status',
		'uses'  => 'TopicController@changeStatus'
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
			'as' 	=> 'account-create-post',
			'uses' 	=> 'AccountController@postCreate'
		));

		/* 
		| Login (POST)
		*/
		Route::post('/account/login', array(
			'as' 	=> 'account-login-post',
			'uses' 	=> 'AccountController@postLogin'
		));

		/*
		| Forgot Password (POST)
		*/
		Route::post('/account/forgot-password', array(
			'as' 	=> 'account-forgot-password-post',
			'uses' 	=> 'AccountController@postForgotPassword'
		));

		/*
		| Recover account (POST)
		*/
		Route::post('/account/recover/{code}', array(
			'as' 	=> 'account-recover-post',
			'uses' 	=> 'AccountController@postRecover'
		));

        /*
		| Create Sentis (POST)
		*/
        Route::post('/sentis/{post_id}/create/', array(
            'as' 	=> 'sentis-create-post',
            'uses' 	=> 'SentisController@postCreate'
        ));

        /*
		| Resend Activation Email (POST)
		*/
	    Route::post('/account/send-activation-email', array(
	        'as' 	=> 'account-send-activation-email-post',
	        'uses' 	=> 'AccountController@postSendActivationEmail'
	    ));
	});
	
	/*
	| Topics ADM List (GET)
	*/
	Route::get('/topics', array(
		'as'	=> 'topics',
		'uses'	=> 'TopicController@getTopics'
	));

	/* 
	| Login (GET)
	*/
	Route::get('/account/login', array(
		'as'   	=> 'account-login',
		'uses' 	=> 'AccountController@getLogin'
	));

	/*
	| Facebook Login (GET)
	*/
	Route::get('/account/loginfb', array(
		'as'   	=> 'account-login-fb',
		'uses' 	=>  'AccountController@getLoginFB'
	));

	/* 
	| Create account (GET)
	*/
	Route::get('/account/create', array(
		'as' 	=> 'account-create',
		'uses' 	=> 'AccountController@getCreate'
	));

	
	/* 
	| Activate account (GET)
	*/
	Route::get('/account/activate/{code}', array(
		'as' 	=> 'account-activate',
		'uses'	=> 'AccountController@getActivate'
	));
	
	/*
	| Forgot Password (GET)
	*/
	Route::get('/account/forgot-password', array(
		'as' 	=> 'account-forgot-password',
		'uses' 	=> 'AccountController@getForgotPassword'
	));

	/*
	| Recover account (GET)
	*/
	Route::get('/account/recover/{code}', array(
		'as' 	=> 'account-recover',
		'uses' 	=> 'AccountController@getRecover'
	));

	Route::get('/user/{username}', array(
		'as'  	=> 'profile-user',
		'uses' 	=> 'ProfileController@user'
	));

	/*
	| HOME (GET)
	*/
	Route::get('/', array(
		'as'   	=> 'home',
		'uses' 	=> 'HomeController@home'
	));

	/*
	| Post Page (GET)
	*/
	Route::get('/posts/{id}/page/', array(
		'as' 	=> 'posts-page',
		'uses' 	=> 'PostController@getPostPage'
	));
	
	/*
	| Topic Page (GET)
	*/
	Route::get('/topic/{id}/page/', array(
		'as' 	=> 'topics-page',
		'uses' 	=> 'TopicController@getTopicPage'
	));

	/*
	| Search Tag By Name (GET)
	*/
	Route::get('/tags/get-tags-by-name/', array(
		'as' 	=> 'tags-by-name',
		'uses' 	=> 'TagController@getTagsByName'
	));

    /*
	| Single Tag Page (GET)
	*/
    Route::get('/tags/{id}/page/', array(
        'as' 	=> 'tags-page',
        'uses' 	=> 'TagController@getTagPage'
    ));

    /*
	| Tags Page (GET)
	*/
    Route::get('/tags/', array(
        'as' 	=> 'tags',
        'uses' 	=> 'TagController@getTags'
    ));
	
	/*
	| Single Feeling Page (GET)
	*/
    Route::get('/feelings/{id}/page/', array(
        'as' 	=> 'feelings-page',
        'uses' 	=> 'FeelingController@getFeelingPage'
    ));

	/*
	| Feelings Page (GET)
	*/
    Route::get('/feelings/', array(
        'as' 	=> 'feelings',
        'uses' 	=> 'FeelingController@getFeelings'
    ));

    /*
	| Create Sentis (GET)
	*/
    Route::get('/sentis/{post_id}/create/', array(
        'as' 	=> 'sentis-create',
        'uses' 	=> 'SentisController@getCreate'
    ));

    /*
	| Search (GET)
	*/
    Route::get('/search/', array(
        'as' 	=> 'search',
        'uses' 	=> 'SearchController@search'
    ));

    /*
	| Resend activation Email (GET)
	*/
    Route::get('/account/send-activation-email', array(
        'as' 	=> 'account-send-activation-email',
        'uses' 	=> 'AccountController@getSendActivationEmail'
    ));

    /*
	| Search Feeling By Name (GET)
	*/
	Route::get('/feelings/get-feelings-by-name/', array(
		'as' 	=> 'feelings-by-name',
		'uses' 	=> 'FeelingController@getFeelingsByName'
	));
});	

