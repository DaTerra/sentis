<?php

class HomeController extends BaseController {

	public function home()
	{
		$posts = Post::where('status', '=', 1)->orderBy('created_at', 'DESC')->get();
		return View::make('home')
			->with('posts', $posts);
	}

}
