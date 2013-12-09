<?php

class HomeController extends BaseController
{

    public function index()
    {
        Comment::where('habr_id', '=', '7068306')->get();
        return View::make('home');
    }

}