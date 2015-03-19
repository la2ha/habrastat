<?php

class HomeController extends BaseController
{

    public function index()
    {
        Comment::where('post_id', '=', '85009')->get();
        return View::make('home');
    }

}