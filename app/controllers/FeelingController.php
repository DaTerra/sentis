<?php

class FeelingController extends BaseController {
    
    public function getFeelingsByName(){
        $name = Input::get('feelings');
        return Feeling::where('name','like','%' .$name .'%')->get();
    }
    public function getFeelings(){
        $feelings = Feeling::All();
        return View::make('feeling.index')
            ->with('feelings', $feelings);
    }

    public function getFeelingPage($id){
        $order = Input::get('order');
        $feeling = Feeling::find($id);
        
        if($order === 'activity'){
            $posts = Post::getLastActivityPostsByFeeling($feeling->id);
        } else if ($order === 'newest') {
            $posts = Post::getNewestPostsByFeeling($feeling->id);
        } else {
            $posts = Post::getMostPopularPostsByFeeling($feeling->id);
            $order = 'popular';
        }
        
        $feeling->posts = $posts;
        
        return View::make('feeling.single')
            ->with('feeling', $feeling)
            ->with('order', $order);
    }
}