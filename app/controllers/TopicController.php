<?php

class TopicController extends BaseController {

	public function getTopics(){
		return View::make('topic.index')
			->with('topics', Topic::all());
	}

	public function getCreate() {
		return View::make('topic.create');
	}
	
}