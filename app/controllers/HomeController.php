<?php

class HomeController extends BaseController {

	public function home()
	{
		$order = Input::get('order');
		
		if($order === 'activity'){
			$posts = Post::getLastActivityPosts();
		} else if ($order === 'newest') {
			$posts = Post::getNewestPosts();
		} else {
			$posts = Post::getMostPopularPosts();
			$order = 'popular';
		}
		
		return View::make('home')
			->with('posts', $posts)
			->with('order', $order)
			->with('topFeelings', Feeling::top5Feelings())
			->with('topTags', Tag::top5Tags())
			->with('lastTopics', Topic::getLast5Topics());
	}

}
