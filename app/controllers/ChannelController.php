<?php

class ChannelController extends BaseController {

	public function getChannels(){
		return View::make('channel.index')
			->with('channels', Channel::orderBy('updated_at', 'DESC')
									  ->where('status', '=', 1)
								  	  ->get());
	}

	public function getCreate() {
		$topics = Topic::orderBy('updated_at', 'DESC')
				   ->where('status', '=', 1)
				   ->get();
		return View::make('channel.create')
				   ->with('topics', $topics);
	}

	public function getChannelPage($id){
		$feelingsByPosts = null;
		$channel = Channel::find($id);
		$channelPosts = [];
		
		foreach($channel->topics as $topic){
			$posts = Post::getMostPopularPostsByTopic($topic);
			foreach ($posts as $post) {
				if(!in_array($post, $channelPosts)){
					array_push($channelPosts, $post);	
				}
            }
		}
		
		$postIds = [];
  		foreach ($channelPosts as $post) array_push($postIds, $post->id);
  		$feelingsByPosts = Post::feelingsByPosts($postIds);	
		
		return View::make('channel.single')
			->with('channel', $channel)
			->with('posts', $channelPosts)
			->with('feelingsByPosts', $feelingsByPosts);
	}

	public function getDelete($id) {
		$channel = Channel::find($id);
		if(Auth::user()->canEditChannel($channel)){
			return View::make('channel.delete')
				->with('channel', $channel);
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");
		}
	}

	public function postDelete($id){
		$channel = Channel::find($id);
		$channel->status = 0;
		if($channel->save()){
			return Redirect::to('/channels')
				->with('message', 'Successfully deleted channel!');	
		} else{
			return Redirect::to('/')
				->with('message', 'We could not delete your channel. Please try again later.');	
		}
	}

	public function getEdit($id) {
		$channel = Channel::find($id);

        if(Auth::user()->canEditChannel($channel)){
        	return View::make('channel.edit')
				->with('channel', $channel);
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");
		}
	}
	
	public function postCreate() {
		$rules = array(
			'name' 	=> 'required|max:80'
		);

		$validator = Validator::make(Input::all(), $rules);
		$topicsAsArray = json_decode(Input::get('selectedTopics'), true);
		
		if ($validator->fails())
   	 	{	return Redirect::route('channels-create')
        		->withErrors($validator)
        		->withInput()
        		->with('topicsSelected', $topicsAsArray);
    	} elseif (empty($topicsAsArray)) {
    		return Redirect::route('channels-create')
	        		->with('error', 'At least one topic needs to be selected')
	        		->withInput();
    	} else {
			
			$user 	 = Auth::user();
			$name 	 = Input::get('name');
			$channel = new Channel;

			$channel->user_id = $user->id;
			$channel->name 	  = $name;
			if($channel->save()){
				$channel_topics = [];
				if($topicsAsArray){
					foreach ($topicsAsArray as $topic) {
						if(Topic::find($topic)){
							array_push($channel_topics, $topic);
						}
					}
				}
				//saving topic tags
				$channel->topics()->sync($channel_topics);	

				return Redirect::route('channels')
					->with('message', 'Your channel was successfully created!');
				
			} else {
				return Redirect::route('channels-create')
					->with('error', 'An error occured creating yout channel. Please try again later.')
					->withInput();
			}
		}
	}

	public function postEdit($id) {

		$channel = Channel::find($id);
		
		if(Auth::user()->canEditChannel($channel)){
			$rules = array(
				'name' 			=> 'required|max:80',
			);

			$validator = Validator::make(Input::all(), $rules);
			
			if ($validator->fails()){
	        	return Redirect::route('channels-edit', $channel->id)
	        		->withErrors($validator)
	        		->withInput();
			} else {
				$name = Input::get('name');
				
				$channel->name = $name;
				if($channel->save()){
					return Redirect::route('channels')
							->with('message', 'Your channel was successfully updated!');
					
				} else {
					return Redirect::route('channels-edit', $channel->id)
						->with('error', 'An error occured updating yout channel. Please try again later.')
						->withInput();
				}
			}
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");	
		}
	}
}