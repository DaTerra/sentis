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
			'media' 			=> 'image|mimes:jpeg,bmp,png|max:500',
			'tags'  			=> 'required'
		);

		$validator = Validator::make(Input::all(), $rules);
		$tagsAsArray = json_decode(Input::get('tagsJSON'), true);
		
		$tag_validator = count($tagsAsArray) >= 1;

		if ($validator->fails())
   	 	{
        
        	return Redirect::route('posts-create')
        		->withErrors($validator)
        		->withInput();
    	
    	} elseif (!$tag_validator){
    	
    		return Redirect::route('posts-create')
        		->with('error', 'At least ONE tag must be informed.')
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
					$post_tags_ids = [];
					foreach ($tagsAsArray as $tag) {
						if(Tag::find($tag['id'])){
							array_push($post_tags_ids, $tag['id']);
						} else {
							$new_tag = new Tag;
							$new_tag->name = $tag['text'];
							$new_tag->save();
							array_push($post_tags_ids, $new_tag->id);
						}
					}

					//saving post tags
					$post->tags()->sync($post_tags_ids);	
					$post_content 				= new PostContent;
					$post_content->title 		= $title;
					$post_content->content 		= $content;
					$post_content->source_url 	= $source_url;
					
					//MEDIA URL
					$upload_success = true;
					if($media){
						$destinationPath = public_path() .'/uploads/' .sha1(Auth::user()->id) .'/post/' .sha1($post->id);
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

	public function getPostPage($id){
		$post = Post::find($id);
		
		return View::make('post.single')
			->with('post', $post);
	}

	public function getDelete($id) {
		$post = Post::find($id);
		if(Auth::user()->canEdit($post)){
			return View::make('post.delete')
				->with('post', $post);
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");
		}
	}
	
	public function postDelete($id){
		$post = Post::find($id);
		$post->status = 0;
		if($post->save()){
			return Redirect::to('/')
				->with('message', 'Successfully deleted post!');	
		} else{
			return Redirect::to('/')
				->with('message', 'We could not delete your post. Please try again later.');	
		}
	}

	public function getEdit($id) {
		$post = Post::find($id);

        if(Auth::user()->canEdit($post)){
			return View::make('post.edit')
				->with('post', $post);
		} else {
			return Redirect::to('/')
				->with('error', "Unauthorized operation");
		}
	}

	public function postEdit($id) {

		$post = Post::find($id);
		$post_content = $post->post_content;

		if(Auth::user()->canEdit($post)){
			$rules = array(
				'title' 			=> 'max:80',
				'content' 			=> 'max:500',
				'source_url' 		=> 'max:250|url',
				'media'             => 'image|mimes:jpeg,bmp,png|max:500',
                'tags'  			=> 'required'
			);

			$validator = Validator::make(Input::all(), $rules);

            $tagsAsArray = json_decode(Input::get('tagsJSON'), true);

            $tag_validator = count($tagsAsArray) >= 1;

			if ($validator->fails())
	   	 	{
	        	return Redirect::route('posts-edit', $post->id)
	        		->withErrors($validator)
	        		->withInput();
            } elseif (!$tag_validator){

                return Redirect::route('posts-edit', $post->id)
                    ->with('error', 'At least ONE tag must be informed.')
                    ->withInput();

            } else {

				$anonymous 		 = Input::get('anonymous', 0);
				$user_ip_address = Request::getClientIp();
				
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
				$custom_validator = !((empty($title)) 		&& 
									  (empty($content)) 	&& 
									  (empty($source_url)) 	&& 
									  (empty($media)) 		&&
									  (empty($post_content->media_url)));
		
				if($custom_validator) {
					$post->anonymous 			= $anonymous;
					$post->updated_at       	= date("Y-m-d H:i:s");
					$post->user_ip_address 		= $user_ip_address;
					$post_content->title		= $title;
					$post_content->content 		= $content;
					$post_content->source_url 	= $source_url;

                    $post_tags_ids = [];
                    foreach ($tagsAsArray as $tag) {
                        if(Tag::find($tag['id'])){
                            array_push($post_tags_ids, $tag['id']);
                        } else {
                            $new_tag = new Tag;
                            $new_tag->name = $tag['text'];
                            $new_tag->save();
                            array_push($post_tags_ids, $new_tag->id);
                        }
                    }

                    //MEDIA URL
					$upload_success = true;

					if($media){
						$destinationPath = public_path() .'/uploads/' .sha1(Auth::user()->id) .'/post/' .sha1($post->id);
						$filename  		 = $media->getClientOriginalName();
						$media_url 		 = URL::to('uploads/'.sha1(Auth::user()->id) .'/post/' .sha1($post->id) .'/'.$filename);
						$post_content->media_url = $media_url;	
						$post_content->media_id  = $media_type->id;
						
						//MEDIA UPLOAD
						$upload_success = $media->move($destinationPath, $filename);
						
						//REMOVE LAST MEDIA IF EXISTS
					} 
					
					//BEFORE UPDATE, SAVE THE OLD VALUES TO HISTORY TABLE

					if( ($post->save()) && ($post_content->save()) && ($post->tags()->sync($post_tags_ids)) && ($upload_success))	{
						return Redirect::route('home')
							->with('message', 'Your post was successfully edited!');
					} else { 
						return Redirect::route('posts-edit', $post->id)
							->with('error', 'An error occured creating yout post or uploading your post media. Please try again later.')
							->withInput();
					}
					
				} else {
					return Redirect::route('posts-edit', $post->id)
		        		->with('error', 'At least one field needs to be filled')
		        		->withInput();
				}
			}	
		}
	}
}
