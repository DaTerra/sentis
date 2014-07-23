<?php

class TopicController extends BaseController {

	public function getTopics(){
		return View::make('topic.index')
			->with('topics', Topic::all());
	}

	public function getCreate() {
		// if(Auth::user()->hasRole('ADM')){
			return View::make('topic.create');
		// } else {
		// 	return Redirect::to('/')
		// 		->with('error', "Unauthorized operation");
		// }
	}

	public function postCreate() {
		// if(!Auth::user()->hasRole('ADM')){
			// return Redirect::to('/')
				// ->with('error', "Unauthorized operation");
		// }

		$rules = array(
			'title' 			=> 'required|max:80',
			'content' 			=> 'required|max:500'
		);

		$validator = Validator::make(Input::all(), $rules);
		$tagsAsArray = json_decode(Input::get('tagsJSON'), true);
		$feelingsAsArray = json_decode(Input::get('feelingsJSON'), true);
		$keywordsAsArray = json_decode(Input::get('keywordsJSON'), true);
		
		if ($validator->fails())
   	 	{
        	return Redirect::route('topics-create')
        		->withErrors($validator)
        		->withInput();
    	} else {
			
			$user 			 = Auth::user();
			$title 	 		 = Input::get('title');
			$content 		 = Input::get('content');
			
			//AT LEAST ONE FIELD MUST BE FILLED
			$custom_validator = !((empty($feelingsAsArray)) && (empty($tagsAsArray)) && (empty($keywordsAsArray)));
	
			if($custom_validator) {
				$topic 			= new Topic;
				$topic->user_id = $user->id;
				$topic->title 	= $title;
				$topic->content	= $content;

				if($topic->save()){
					
					$topic_tags_ids = [];
					foreach ($tagsAsArray as $tag) {
						if(Tag::find($tag['id'])){
							array_push($topic_tags_ids, $tag['id']);
						}
					}
					//saving topic tags
					$topic->tags()->sync($topic_tags_ids);	

					$topic_feelings_ids = [];				
					foreach ($feelingsAsArray as $feeling) {
						if(Feeling::find($feeling['id'])){
							array_push($topic_feelings_ids, $feeling['id']);
						}
					}
					//saving topic feelings
					$topic->feelings()->sync($topic_feelings_ids);	

					//saving topic keywords
					$topic_keywords = [];				
					foreach ($keywordsAsArray as $keyword) {
						$newKeyword = new Keyword;
						$newKeyword->keyword = $keyword['text'];
						$newKeyword->topic_id = $topic->id;
						$newKeyword->save();
					}

					return Redirect::route('topics')
						->with('message', 'Your topic was successfully created!');
				
				} else {
					return Redirect::route('topics-create')
						->with('error', 'An error occured creating yout topic. Please try again later.')
						->withInput();
				}
			} else {
				return Redirect::route('topics-create')
	        		->with('error', 'At least one filter needs to be filled')
	        		->withInput();
			}
		}
	}

	public function getTopicPage($id){
		$topic = Topic::find($id);
		return View::make('topic.single')
			->with('topic', $topic);
	}
}