<?php

class Comment extends Eloquent
{
    public $incrementing = false;
    public $timestamps = false;

    protected $guarded = array();

    public static $rules = array();


    public function author()
    {
        return $this->belongsTo('Author');
    }


    public function post()
    {
        return $this->belongsTo('Post');
    }
}
