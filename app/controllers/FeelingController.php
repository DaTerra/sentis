<?php

class FeelingController extends BaseController {

    public function getFeelings(){
        $feelings = Feeling::All();
        return View::make('feeling.index')
            ->with('feelings', $feelings);
    }

    public function getFeelingPage($id){

        $postsByFeeling = 
        DB::select(
            DB::raw('SELECT s.post_id id
                     FROM sentis_feelings sf, sentis s, posts p
                     WHERE sf.sentis_id = s.id
                     AND p.id = s.post_id
                     AND p.status = 1
                     AND sf.feeling_id =' .$id 
                     .' group by s.post_id')
        );
        
        $postIds = [];
        foreach ($postsByFeeling as $feeling) {
            array_push($postIds, $feeling->id);    
        }
        
        $posts = Post::find($postIds);
        $feeling = Feeling::find($id);

        return View::make('feeling.single')
            ->with('feeling', $feeling)
            ->with('posts', $posts);
    }

}