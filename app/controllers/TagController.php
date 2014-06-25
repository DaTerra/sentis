<?php

class TagController extends BaseController {
	public function getTagByName($name){
		return Tag::where('name','like','%$name%')->get();
	}
}