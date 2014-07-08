<?php

class SentisController extends BaseController {
    public function getCreate($postId) {
        //trazer feelings baseado em?
        $feelings = Feeling::all();
        return View::make('sentis.create')
            ->with('feelings', $feelings);
    }

    public function postCreate($postId) {
        
        $tagsAsArray = json_decode(Input::get('tagsJSON'), true);
        
        $feelings = json_decode(Input::get('feelingsJSON'), true);
        
        if(!$feelings){
            return Redirect::route('sentis-create', $postId)
                            ->with('error', 'At least one feeling must be filled.')
                            ->withInput();

         
        //verificar se existe cookie e nao permitir caso esteja invalido    
        } else if (Cookie::get('sentis_cookie') == $postId) {
            return Redirect::route('sentis-create', $postId)
                            ->with('error', 'You recently created sentis for this post! Try again later.')
                            ->withInput();
        }

        $sentis = new Sentis;
        
        if(Auth::user()){
            $sentis->user_id = Auth::user()->id;
        } 
        
        $sentis->post_id = $postId;
        $sentis->user_ip_address = Request::getClientIp();
        
        //creating tags
        $sentis_tags_ids = [];
        foreach ($tagsAsArray as $tag) {
            if(Tag::find($tag['id'])){
                array_push($sentis_tags_ids, $tag['id']);
            } else {
                $new_tag = new Tag;
                $new_tag->name = $tag['text'];
                $new_tag->save();
                array_push($sentis_tags_ids, $new_tag->id);
            }
        }
        //save sentis, sentis_feelings and sentis_tags
        if(($sentis->save()) && ($sentis->feelings()->sync($feelings) ) && ($sentis->tags()->sync($sentis_tags_ids)) ) {
            return Redirect::route('posts-page', $postId)
                            ->with('message', 'Your post was successfully created!')
                            ->withCookie(Cookie::make('sentis_cookie', $postId, 60));;
        } else {
            return Redirect::route('sentis-create', $postId)
                            ->with('error', 'An error occured creating yout sentis. Please try again later.')
                            ->withInput();
        }
    }
}