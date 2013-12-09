<?php

class Post extends Eloquent
{
    public $incrementing = false;

    protected $guarded = array();

    public static $rules = array();

    public function author()
    {
        return $this->belongsTo('Author');
    }

    public function comments()
    {
        return $this->hasMany('Comment');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag');
    }

    public function hubs()
    {
        return $this->belongsToMany('Hub');
    }
}
