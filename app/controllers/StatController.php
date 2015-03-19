<?php

class StatController extends BaseController
{

    public function all()
    {
        $coutComments=Comment::countComments();
        $data['coutComments']  = number_format($coutComments, 0, '.', ' ');
        $data['averageComments'] = number_format($coutComments/Post::countPosts(), 2, '.', ' ');
        $data['avgScoreTotalComments'] = number_format(Comment::avgScoreTotal(), 2, '.', ' ');
        $data['sumScorePlusComments'] = number_format(Comment::sumScorePlus(), 0, '.', ' ');;
        $data['sumScoreMinusComments'] = number_format(Comment::sumScoreMinus(), 0, '.', ' ');;
        $data['maxScorePlusComments'] = number_format(Comment::maxScorePlus(), 0, '.', ' ');;
        $data['maxScoreMinusComments'] = number_format(Comment::maxScoreMinus(), 0, '.', ' ');;
        return View::make('stat.all', $data);
    }

}