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

    public static function countComments($time = false)
    {
        $cacheKey = 'countComments_time-' . $time;
        if (!$time)
            $cacheTime = 60 * 24;

//        if (Cache::has($cacheKey))
//            return Cache::get($cacheKey);
        $count = self::count();
        Cache::put($cacheKey, $count, $cacheTime);

        return $count;

    }

    public static function avgScoreTotal($time = false)
    {
        $cacheKey = 'avgScoreTotalComments_time-' . $time;
        if (!$time)
            $cacheTime = 60 * 24;

//        if (Cache::has($cacheKey))
//            return Cache::get($cacheKey);
        $average = self::avg('score_total');
        Cache::put($cacheKey, $average, $cacheTime);

        return $average;

    }

    public static function sumScorePlus($time = false)
    {
        $cacheKey = 'sumScorePlusComments_time-' . $time;
        if (!$time)
            $cacheTime = 60 * 24;

//        if (Cache::has($cacheKey))
//            return Cache::get($cacheKey);
        $sum = self::sum('score_plus');
        Cache::put($cacheKey, $sum, $cacheTime);

        return $sum;
    }

    public static function sumScoreMinus($time = false)
    {
        $cacheKey = 'sumScoreMinusComments_time-' . $time;
        if (!$time)
            $cacheTime = 60 * 24;

//        if (Cache::has($cacheKey))
//            return Cache::get($cacheKey);
        $sum = self::sum('score_minus');
        Cache::put($cacheKey, $sum, $cacheTime);

        return $sum;
    }

    public static function maxScoreMinus($time = false)
    {
        $cacheKey = 'maxScoreMinusComments_time-' . $time;
        if (!$time)
            $cacheTime = 60 * 24;

//        if (Cache::has($cacheKey))
//            return Cache::get($cacheKey);
        $max = self::max('score_minus');
        Cache::put($cacheKey, $max, $cacheTime);

        return $max;
    }

    public static function maxScorePlus($time = false)
    {
        $cacheKey = 'maxScorePlusComments_time-' . $time;
        if (!$time)
            $cacheTime = 60 * 24;

//        if (Cache::has($cacheKey))
//            return Cache::get($cacheKey);
        $max = self::max('score_plus');
        Cache::put($cacheKey, $max, $cacheTime);

        return $max;
    }
}
