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


Route::get('posts', function()
{
	$posts = Post::all();
		return View::make('posts.index')
			->with('posts', $posts);
});

Route::get('posts/create', function() {
	$post = new Post;
	return View::make('posts.edit')
		->with('post', $post)
		->with('method', 'post');
});

Route::get('posts/{post}', function(Post $post) {
	return View::make('posts.single')
		->with('post', $post);
});

Route::get('posts/{post}/edit', function(Post $post) {
	return View::make('posts.edit')
		->with('post', $post)
		->with('method', 'put');
});

Route::get('posts/{post}/delete', function(Post $post) {
	return View::make('posts.edit')
		->with('post', $post)
		->with('method', 'delete');
});

Route::post('posts', function(){
	$post = Post::create(Input::all());
	return Redirect::to('posts/' . $post->id)
	->with('message', 'Successfully created page!');
});

Route::put('posts/{post}', function(Post $post) {
	$post->update(Input::all());
	return Redirect::to('posts/' . $post->id)
	->with('message', 'Successfully updated page!');
});

Route::delete('posts/{post}', function(Post $post) {
	$post->delete();
	return Redirect::to('posts')
	->with('message', 'Successfully deleted page!');
});

View::composer('posts.edit', function($view){
	$users = User::all();
	$privacies = Privacy::all();
	$categories = Category::all();
	
	if(count($users) > 0){
		$user_options = array_combine($users->lists('id'),
		$users->lists('username'));
	} else {
		$user_options = array(null, 'Unspecified');
	}

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

	$view->with('user_options', $user_options);
	$view->with('privacy_options', $privacy_options);
	$view->with('category_options', $category_options);
});

