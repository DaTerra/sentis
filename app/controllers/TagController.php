<?php

class TagController extends BaseController {

    public function getTagPage($id){

        $tag = Tag::find($id);
        $posts = Post::whereHas('tags', function($q) use ($id)
        {
            $q->where('id', '=', $id);

        })->where('status', '=', '1')->get();

        return View::make('tag.single')
            ->with('tag', $tag)
            ->with('posts', $posts);
    }

    public function getTags(){
        $tags = Tag::All();
        return View::make('tag.index')
            ->with('tags', $tags);
    }

    public function getTagsByName(){
		$name = Input::get('tags');
		Debugbar::info($name);
		return Tag::where('name','like','%' .$name .'%')->get();
	}
}