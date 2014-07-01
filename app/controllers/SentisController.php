<?php

class SentisController extends BaseController {
    public function getCreate($postId) {
        //trazer feelings baseado em?
        $feelings = Feeling::all();
        return View::make('sentis.create')
            ->with('feelings', $feelings);
    }

    public function postCreate($postId) {
        $feelings = Input::all();
        return $feelings;
//        foreach($feelings as $feeling) {
//            Debugbar::info("felling:" . $feeling);
//        }
//        return "oi";
    }
}