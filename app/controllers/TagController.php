<?php

class TagController extends BaseController {

    public function getTagPage($id){

        $tag = Tag::find($id);
        
        return View::make('tag.single')
            ->with('tag', $tag);
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