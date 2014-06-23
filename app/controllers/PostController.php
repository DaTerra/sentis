<?php

class PostController extends BaseController {

	
	public function getCreate() {
		return View::make('post.create');
	}

	public function postCreate() {
		$rules = array(
			'title' 			=> 'max:80',
			'content' 			=> 'max:500',
			'source_url' 		=> 'max:250|url',
			'media' => 'image|mimes:jpeg,bmp,png|max:500'
		);

		$validator = Validator::make(Input::all(), $rules);
		
		if ($validator->fails())
   	 	{
        	return Redirect::route('posts-create')
        		->withErrors($validator)
        		->withInput();
    	} else {

			//Post user data
			$user 			 = Auth::user();
			$anonymous 		 = Input::get('anonymous', 0);
			$user_ip_address = Request::getClientIp();
			$privacy 		 = Privacy::where('name', '=', 'Public');
			
			if($privacy->count()){
				$privacy = $privacy->first();
			}

			//PostContent Data
			$title 	 		 = Input::get('title');
			$content 		 = Input::get('content');
			$source_url 	 = Input::get('source_url');
			$media 			 = Input::file('media');

			$media_type 	 = Media::where('type', '=', 'image');

			if($media_type->count()){
				$media_type = $media_type->first();
			}
			
			//AT LEAST ONE FIELD MUST BE FILLED
			$custom_validator = !((empty($title)) && (empty($content)) && (empty($source_url)) && (empty($media)));
	
			if($custom_validator) {
				$post 						= new Post;
				$post->user_id 				= $user->id;
				$post->anonymous 			= $anonymous;
				$post->user_ip_address 		= $user_ip_address;
				$post->privacy_id 			= $privacy->id;
				
				if($post->save()){
					$post_content 				= new PostContent;
					$post_content->title 		= $title;
					$post_content->content 		= $content;
					$post_content->source_url 	= $source_url;
					
					//MEDIA URL
					$upload_success = true;
					if($media){
						$destinationPath = 'public/uploads/'.sha1(Auth::user()->id) .'/post/' .sha1($post->id);
						$filename  		 = $media->getClientOriginalName();
						$media_url 		 = URL::to('uploads/'.sha1(Auth::user()->id) .'/post/' .sha1($post->id) .'/'.$filename);
						$post_content->media_url = $media_url;	
						$post_content->media_id  = $media_type->id;
						//MEDIA UPLOAD
						
						$upload_success = $media->move($destinationPath, $filename);
					} 

					$post_content->post_id = $post->id;
					
					//after post page ready, change to post-page route	
					if($post_content->save() && $upload_success){
						return Redirect::route('home')
							->with('message', 'Your post was successfully created!');
					} else { 
						return Redirect::route('posts-create')
							->with('error', 'An error occured creating yout post or uploading your post media. Please try again later.')
							->withInput();
					}
				} else { 
					return Redirect::route('posts-create')
						->with('error', 'An error occured creating yout post or uploading your post media. Please try again later.')
						->withInput();
				}
			} else {
				return Redirect::route('posts-create')
	        		->with('error', 'At least one field needs to be filled')
	        		->withInput();
			}
		}
	}

	public function getPostPage($post){
		$post = Post::find($post);
		return View::make('post.single')
			->with('post', $post);
	}
}
