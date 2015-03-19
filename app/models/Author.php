<?php

class Author extends Eloquent
{
    public  $timestamps = false;

    protected $guarded = array();

    public static $rules = array();


    public function post()
    {
        return $this->hasMany('Post');
    }

    public function comments()
    {
        return $this->hasMany('Comment');
    }
}
