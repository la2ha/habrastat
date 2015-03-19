<?php

class Tag extends Eloquent
{
    public  $timestamps = false;

    protected $guarded = array();

    public static $rules = array();

    public function posts()
    {
        return $this->belongsToMany('Post');
    }
}
