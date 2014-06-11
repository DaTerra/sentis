<?php

class PostController extends BaseController {

	public function getCreate() {
		$post = new Post;
		return View::make('posts.edit')
			->with('post', $post)
			->with('method', 'post');
	}

	public function postCreate() {
		$rules = array(
				'content' 	=> 'required|min:10',
				'tags' 		=> 'required|min:3'
			);

		$validator = Validator::make(Input::all(), $rules);
		if ($validator->fails())
	    {
	        return Redirect::back()->withErrors($validator);
	    } else {
			$post = Post::create(Input::all());
			if($post->save()){
				return Redirect::to('home' . $post->id)
					->with('message', 'Successfully created post!');
			} else {
				return Redirect::back()
					->with('error', 'Error creating post!');
			}	
	    }
	}
}
