<?php

class FeelingController extends BaseController {

    public function getFeelings(){
        $feelings = Feeling::All();
        return View::make('feeling.index')
            ->with('feelings', $feelings);
    }

    public function getFeelingPage($id){

        $feeling = Feeling::find($id);

        return View::make('feeling.single')
            ->with('feeling', $feeling);
        
    }

}