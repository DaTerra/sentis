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

Route::get('login', function(){
	return View::make('login');
});	

Route::post('login', function(){
	if(Auth::attempt(Input::only('username', 'password'))) {
		return Redirect::intended('/posts');
	} else {
		return Redirect::back()
			->withInput()
			->with('error', "Invalid credentials");
	}
});

Route::get('logout', function(){
	Auth::logout();
	return Redirect::to('/posts')
		->with('message', 'You are now logged out');
});	

Route::group(array('before'=>'auth'), function(){
	Route::get('posts/create', function() {
		$post = new Post;
		return View::make('posts.edit')
			->with('post', $post)
			->with('method', 'post');
	});
	
	Route::post('posts', function(){
		$post = Post::create(Input::all());
		if($post->save()){
			return Redirect::to('posts/' . $post->id)
				->with('message', 'Successfully created post!');
		} else {
			return Redirect::back()
				->with('error', 'Error creating post!');
		}
		
	});

	Route::get('posts/{post}/edit', function(Post $post) {
		if(Auth::user()->canEdit($post)){
			return View::make('posts.edit')
				->with('post', $post)
				->with('method', 'put');
		} else {
			return Redirect::to('posts/' . $post->id)
				->with('error', "Unauthorized operation");
		}
	});

	Route::get('posts/{post}/delete', function(Post $post) {
		if(Auth::user()->canEdit($post)){
			return View::make('posts.edit')
				->with('post', $post)
				->with('method', 'delete');
		} else {
			return Redirect::to('posts/' . $post->id)
				->with('error', "Unauthorized operation");
		}
	});

	Route::put('posts/{post}', function(Post $post) {
		if(Auth::user()->canEdit($post)){
			$post = Post::create(Input::all());
			if($post->save()){
				return Redirect::to('posts/' . $post->id)
					->with('message', 'Successfully created profile!');
			} else {
				return Redirect::back()
					->with('error', 'Could not create profile');
			}
		} else {
			return Redirect::to('posts/' . $post->id)
				->with('error', "Unauthorized operation");
		}
	});

	Route::delete('posts/{post}', function(Post $post) {
		$post->delete();
		return Redirect::to('posts')
		->with('message', 'Successfully deleted page!');
	});

});


Route::get('posts', function()
{
	$posts = Post::all();
		return View::make('posts.index')
			->with('posts', $posts);
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

