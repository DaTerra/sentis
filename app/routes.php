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
		| Topic Update
		*/
		Route::put('topics/{id}/edit', array(
			'as'	=> 'topics-edit',
			'uses'	=> 'TopicController@postEdit'
		));

		/*
		| Channel Update
		*/
		Route::put('channels/{id}/edit', array(
			'as'	=> 'channels-edit',
			'uses'	=> 'ChannelController@postEdit'
		));

		/*
		| Topics Create (POST)
		*/
		Route::post('/topics/create', array(
			'as'	=> 'topics-create-post',
			'uses'	=> 'TopicController@postCreate'
		));

		/*
		| Channels Create (POST)
		*/
		Route::post('/channels/create', array(
			'as'	=> 'channels-create-post',
			'uses'	=> 'ChannelController@postCreate'
		));
		
		/*
		| Channel Delete
		*/
		Route::delete('channels/{id}/delete', array(
			'as' 	=> 'channels-delete',
			'uses' 	=> 'ChannelController@postDelete'
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
	| Edit Post (GET)
	*/
	Route::get('/topics/{id}/edit', array(
		'as'	=> 'topics-edit',
		'uses'	=> 'TopicController@getEdit'
	));

	/*
	| Edit Channel (GET)
	*/
	Route::get('/channels/{id}/edit', array(
		'as'	=> 'channels-edit',
		'uses'	=> 'ChannelController@getEdit'
	));

	/*
	| Topics Create (GET)
	*/
	Route::get('/topics/create', array(
		'as'	=> 'topics-create',
		'uses'	=> 'TopicController@getCreate'
	));

	/*
	| Channels Create (GET)
	*/
	Route::get('/channels/create', array(
		'as'	=> 'channels-create',
		'uses'	=> 'ChannelController@getCreate'
	));
	
	/* 
	| Delete Channel (GET)
	*/
	Route::get('/channels/{id}/delete', array(
		'as'  	=> 'channels-delete',
		'uses'	=> 'ChannelController@getDelete'
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

	/*
	| Topic Static Posts
	*/
	Route::get('topics/{id}/static-posts', array(
		'as'    => 'topics-static-posts',
		'uses'  => 'TopicController@selectStaticPosts'
	));

	/*
	| Topic Static Posts
	*/
	Route::get('topics/{id}/dinamic-posts', array(
		'as'    => 'topics-dinamic-posts',
		'uses'  => 'TopicController@selectDinamicPosts'
	));

	/*
	| Topic Static Posts
	*/
	Route::get('topics/{id}/static-posts', array(
		'as'    => 'topics-static-posts',
		'uses'  => 'TopicController@selectStaticPosts'
	));

	Route::get('/user/{username}/follow', array(
		'as'  	=> 'follow-user',
		'uses' 	=> 'ProfileController@follow'
	));

	Route::get('/user/{username}/unfollow', array(
		'as'  	=> 'unfollow-user',
		'uses' 	=> 'ProfileController@unfollow'
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
	| Topics List (GET)
	*/
	Route::get('/topics', array(
		'as'	=> 'topics',
		'uses'	=> 'TopicController@getTopics'
	));

	/*
	| Channels (GET)
	*/
	Route::get('/channels', array(
		'as'	=> 'channels',
		'uses'	=> 'ChannelController@getChannels'
	));

	/* 
	| Login (GET)
	*/
	Route::get('/account/login', array(
		'as'   	=> 'account-login',
		'uses' 	=> 'AccountController@getLogin'
	));
	
	Route::get('/posts/getLessPopularPosts', array(
		'as' 	=> 'getLessPopularPosts',
		'uses' 	=> 'PostController@getLessPopularPosts'
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
	
	Route::get('/users/getLessPopularPosts', array(
		'as' 	=> 'getLessPopularPosts',
		'uses' 	=> 'AccountController@getLessPopularPosts'
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
	| Channel Page (GET)
	*/
	Route::get('/channel/{id}/page/', array(
		'as' 	=> 'channels-page',
		'uses' 	=> 'ChannelController@getChannelPage'
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
	
	Route::get('/tags/getLessPopularPosts/', array(
        'as' 	=> 'tags-popular',
        'uses' 	=> 'TagController@getLessPopularPosts'
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
