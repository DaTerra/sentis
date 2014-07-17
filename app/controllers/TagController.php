<?php

class TagController extends BaseController {

    public function getTagPage($id){
        $order = Input::get('order');
        $tag = Tag::find($id);
        
        if($order === 'activity'){
            $posts = Post::getLastActivityPostsByTag($tag->id);
        } else if ($order === 'newest') {
            $posts = Post::getNewestPostsByTag($tag->id);
        } else {
            $posts = Post::getMostPopularPostsByTag($tag->id);
            $order = 'popular';
        }
        
        $tag->posts = $posts;
        
        return View::make('tag.single')
            ->with('tag', $tag)
            ->with('order', $order);
    }

    public function getTags(){
        $tags = Tag::All();
        return View::make('tag.index')
            ->with('tags', $tags);
    }

    public function getTagsByName(){
		$name = Input::get('tags');
		return Tag::where('name','like','%' .$name .'%')->get();
	}
}