<?php

class TagController extends BaseController {
	public function getTagsByName(){
		$name = Input::get('tags');
		Debugbar::info($name);
		return Tag::where('name','like','%' .$name .'%')->get();
	}
}