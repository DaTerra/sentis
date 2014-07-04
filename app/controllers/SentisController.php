<?php

class SentisController extends BaseController {
    public function getCreate($postId) {
        //trazer feelings baseado em?
        $feelings = Feeling::all();
        return View::make('sentis.create')
            ->with('feelings', $feelings);
    }

    public function postCreate($postId) {
        
        $feelings = json_decode(Input::get('feelingsJSON'), true);

        if(!$feelings){
            return Redirect::route('sentis-create', $postId)
                            ->with('error', 'At least one feeling must be filled.');           
         
        //verificar se existe cookie e nao permitir caso esteja invalido    
        } else if (Cookie::get('sentis_cookie') == $postId) {
            return Redirect::route('sentis-create', $postId)
                            ->with('error', 'You recently created sentis for this post! Try again later.');
        }

        $sentis = new Sentis;
        
        if(Auth::user()){
            $sentis->user_id = Auth::user()->id;
        } 
        
        $sentis->post_id = $postId;
        $sentis->user_ip_address = Request::getClientIp();

        if(($sentis->save()) && ($sentis->feelings()->sync($feelings) )) {
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