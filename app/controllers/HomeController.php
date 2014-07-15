<?php

class HomeController extends BaseController {

	public function home()
	{
		return View::make('home')
			->with('posts', Post::getMostPopularPosts());
	}

}
