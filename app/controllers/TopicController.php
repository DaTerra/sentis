<?php

class TopicController extends BaseController {

	public function getTopics(){
		return View::make('topic.index')
			->with('topics', Topic::orderBy('updated_at', 'DESC')
								  ->where('status','=',1)->get());
	}

	public function getCreate() {
		// if(Auth::user()->hasRole('ADM')){
			return View::make('topic.create');
		// } else {
		// 	return Redirect::to('/')
		// 		->with('error', "Unauthorized operation");
		// }
	}

	public function getTopicPage($id){
		$feelingsByPosts = null;
		$topic = Topic::find($id);
		
		//get dinamic posts
		$posts = Post::getMostPopularPostsByTopic($topic);

		//if static posts are selected
		if($topic->posts->count()){
			$postIds = [];
    		foreach ($topic->posts as $post) array_push($postIds, $post->id);
    		$feelingsByPosts = Post::feelingsByPosts($postIds);	
		} else if($posts->count()){
			$postIds = [];
    		foreach ($posts as $post) array_push($postIds, $post->id);
    		$feelingsByPosts = Post::feelingsByPosts($postIds);	
		}
		
		return View::make('topic.single')
			->with('topic', $topic)
			->with('posts', $posts)
			->with('feelingsByPosts', $feelingsByPosts);
	}

	public function getDelete($id) {
		$topic = Topic::find($id);
		if(Auth::user()->canEditTopic($topic)){
			return View::make('topic.delete')
				->with('topic', $topic);
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");
		}
	}

	public function postDelete($id){
		$topic = Topic::find($id);
		$topic->status = 0;
		if($topic->save()){
			return Redirect::to('/topics')
				->with('message', 'Successfully deleted topic!');	
		} else{
			return Redirect::to('/')
				->with('message', 'We could not delete your topic. Please try again later.');	
		}
	}

	public function changeStatus($topicId, $statusCode){
		$topic = Topic::find($topicId);
		$topic->status = $statusCode;
		$topic->save();
		return Redirect::route('topics-page', $topicId)
			->with('message', 'Status successfully changed!');
	}

	public function getEdit($id) {
		$topic = Topic::find($id);

        if(Auth::user()->canEditTopic($topic)){
			return View::make('topic.edit')
				->with('topic', $topic);
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");
		}
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
			$status 		 = Input::get('status', 0);
			//AT LEAST ONE FIELD MUST BE FILLED
			$custom_validator = !((empty($feelingsAsArray)) && (empty($tagsAsArray)) && (empty($keywordsAsArray)));
	
			if($custom_validator) {
				$topic 			= new Topic;
				$topic->user_id = $user->id;
				$topic->title 	= $title;
				$topic->content	= $content;
				$topic->status  = $status;
				
				if($topic->save()){
					$topic_tags_ids = [];
					if($tagsAsArray){
						foreach ($tagsAsArray as $tag) {
							if(Tag::find($tag['id'])){
								array_push($topic_tags_ids, $tag['id']);
							}
						}
					}
					//saving topic tags
					$topic->tags()->sync($topic_tags_ids);	

					$topic_feelings_ids = [];				
					if($feelingsAsArray){
						foreach ($feelingsAsArray as $feeling) {
							if(Feeling::find($feeling['id'])){
								array_push($topic_feelings_ids, $feeling['id']);
							}
						}
					}
					//saving topic feelings
					$topic->feelings()->sync($topic_feelings_ids);	

					//saving topic keywords
					$topic_keywords = [];				
					if($keywordsAsArray){
						foreach ($keywordsAsArray as $keyword) {
							$newKeyword = new Keyword;
							$newKeyword->keyword = $keyword['text'];
							$newKeyword->topic_id = $topic->id;
							$newKeyword->save();
						}
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

	public function postEdit($id) {

		$topic = Topic::find($id);
		
		if(Auth::user()->canEditTopic($topic)){
			$rules = array(
				'title' 			=> 'required|max:80',
				'content' 			=> 'required|max:500'
			);

			$validator = Validator::make(Input::all(), $rules);
			$tagsAsArray = json_decode(Input::get('tagsJSON'), true);
			$feelingsAsArray = json_decode(Input::get('feelingsJSON'), true);
			$keywordsAsArray = json_decode(Input::get('keywordsJSON'), true);
			
			if ($validator->fails()){
	        	return Redirect::route('topics-edit', $topic->id)
	        		->withErrors($validator)
	        		->withInput();
			} else {
				$title 	 		 = Input::get('title');
				$content 		 = Input::get('content');
				$status 		 = Input::get('status', 0);
				
				//AT LEAST ONE FIELD MUST BE FILLED
				$custom_validator = !((empty($feelingsAsArray)) && (empty($tagsAsArray)) && (empty($keywordsAsArray)));

				if($custom_validator) {
				
					$topic->title 	= $title;
					$topic->content	= $content;
					$topic->status  = $status;
				
					if($topic->save()){
						$topic_tags_ids = [];
						if($tagsAsArray){
							foreach ($tagsAsArray as $tag) {
								if(Tag::find($tag['id'])){
									array_push($topic_tags_ids, $tag['id']);
								}
							}
						}
						
						//saving topic tags
						$topic->tags()->sync($topic_tags_ids);	

						$topic_feelings_ids = [];				
						if($feelingsAsArray){
							foreach ($feelingsAsArray as $feeling) {
								if(Feeling::find($feeling['id'])){
									array_push($topic_feelings_ids, $feeling['id']);
								}
							}
						}
						//saving topic feelings
						$topic->feelings()->sync($topic_feelings_ids);	

						//saving topic keywords
						$topic_keywords = [];			

						if($keywordsAsArray){
							//creating new keywords
							foreach ($keywordsAsArray as $keyword) {
								if(Keyword::where('topic_id', '=', $topic->id)
								 		  ->where('keyword', '=', $keyword['text'])->count()){
									Debugbar::info('Keyword already exists: ' .$keyword['text']);
								} else {
									Debugbar::info('Creating new keyword: ' .$keyword['text']);
									$newKeyword = new Keyword;
									$newKeyword->keyword = $keyword['text'];
									$newKeyword->topic_id = $topic->id;
									$newKeyword->save();
								}
							}

							//deleting old keywords 
							$keywordsArrayAsString = [];
							foreach ($keywordsAsArray as $keyword) {
								array_push($keywordsArrayAsString, $keyword['text']);
							}
							Keyword::where('topic_id', $topic->id)->whereNotIn('keyword', $keywordsArrayAsString)->delete();
						}

						return Redirect::route('topics')
							->with('message', 'Your topic was successfully updated!');
					
					} else {
						return Redirect::route('topics-edit', $topic->id)
							->with('error', 'An error occured updating yout topic. Please try again later.')
							->withInput();
					}

				} else {
					return Redirect::route('topics-edit', $topic->id)
        				->with('error', 'At least one filter needs to be filled')
        				->withInput();
				} 
			}
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");	
		}
	}

	public function selectStaticPosts($id){
		$topic = Topic::find($id);
		$topicPosts = Input::get('topicPosts');
		if($topicPosts){
			$topicPosts =  explode(',', Input::get('topicPosts'));
		
			//saving topic posts
			$topic->posts()->sync($topicPosts);
			return Redirect::route('topics-page', $topic->id)
							->with('message', 'Your posts were successfully selected!');
		} else {
			return Redirect::route('topics-page', $topic->id)
        				->with('error', 'At least one post must be selected.')
        				->withInput();
		}
	}
}