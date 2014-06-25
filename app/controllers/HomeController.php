<?php

class HomeController extends BaseController {

	public function home()
	{
		$posts = Post::where('status', '=', 1)->get();
		return View::make('home')
			->with('posts', $posts);
	}

}
