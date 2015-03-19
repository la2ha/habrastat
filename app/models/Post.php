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

    public static function countPosts($time = false)
    {
        $cacheKey = 'countPosts_time-' . $time;
        if (!$time)
            $cacheTime = 60 * 24;

//        if (Cache::has($cacheKey))
//            return Cache::get($cacheKey);
        $count = self::count();
        Cache::put($cacheKey, $count, $cacheTime);

        return $count;

    }
}
