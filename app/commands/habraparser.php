<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \RollingCurl\RollingCurl;

class habraparser extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'habraparser';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse habrahabr.ru.';

    protected $action;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '2G');
        gc_enable();
        $this->action = $this->argument('action');
        $last_id      = $this->option('last');
        $first_id     = $this->option('first');
        if ($last_id < $first_id)
            list($last_id, $first_id) = array($first_id, $last_id);
        if (in_array($this->action, array('file', 'database'))) {
            if ($this->action == 'file') {
                if (!$last_id) {
                    $this->error('Функция получения последнего id еще не готова');
                    exit;
                }
                if (!$first_id) {
                    $this->error('Функция получения первого id еще не готова');
                    exit;
                }
            } elseif ($this->action == 'database') {
                if (!$last_id) {
                    $this->error('Функция получения последнего id еще не готова');
                    exit;
                }
                if (!$first_id) {
                    $this->error('Функция получения первого id еще не готова');
                    exit;
                }
            }
            $this->getPosts($last_id, $first_id);
        } elseif (strtolower($this->action) == 'filetodb') {
            if (!$last_id) {
                $this->error('Функция получения последнего id еще не готова');
                exit;
            }
            if (!$first_id) {
                $this->error('Функция получения первого id еще не готова');
                exit;
            }
            $this->FileToDb($last_id, $first_id);

        }
    }

    protected function FileToDb($last_id, $first_id)
    {
        for ($id = $last_id; $id > $first_id; $id--) {
            $filePatch = __DIR__ . '/../habra_pages/' . $id . '.html';
            if (file_exists($filePatch)) {
                $post = Post::where('id', '=', $id)->first();
                if ($post and !Config::get('habraparser.update_posts'))
                    return false;
                $pageHtml = file_get_contents($filePatch);
                $size     = filesize($filePatch);
                $postData = $this->getPostData($id, $pageHtml, $size);
                $this->savePost($postData, $post);
                unset($postData, $post);

            }

        }
    }


    protected function getPosts($last_id, $first_id)
    {
        for ($i = $last_id; $i > $first_id; $i--) {
            $rollingCurl = new RollingCurl();
            $rollingCurl->get("http://habrahabr.ru/post/$i/");
            $i--;
            $rollingCurl->get("http://habrahabr.ru/post/$i/");
            $i--;
            $rollingCurl->get("http://habrahabr.ru/post/$i/");
            $i--;
            $rollingCurl->get("http://habrahabr.ru/post/$i/");
            $i--;
            $rollingCurl->get("http://habrahabr.ru/post/$i/");
            $i--;
            $rollingCurl->get("http://habrahabr.ru/post/$i/");
            $i--;
            $rollingCurl->get("http://habrahabr.ru/post/$i/");
            $rollingCurl->setCallback(function (\RollingCurl\Request $request, \RollingCurl\RollingCurl $rollingCurl) {
                $this->getPostsCallback($request);
                unset($request, $rollingCurl);
//        })->execute();
            })->setSimultaneousLimit(7)->execute();
            unset($rollingCurl);
        };


    }

    protected function getPostsCallback(\RollingCurl\Request $response)
    {
        try {
            if (!$id = $this->getIdByLink($response))
                return false;
            $http_code = $response->getResponseInfo()['http_code'];
            if ($http_code == 404) {
                $this->info("Пост #$id не найден");
                return false;
            } elseif ($http_code == 503) {
                $this->error("Пост #$id не найден (уменьшите количество потоков)");
                return false;
            };
            if ($this->action == 'file') {
                file_put_contents(__DIR__ . '/../habra_pages/' . $id . '.html', $response->getResponseText());
                echo get_file_size(memory_get_usage(true)) . "\n";
                $this->info("Пост #$id сохранен");
            } elseif ($this->action == 'database') {
                $post = Post::where('id', '=', $id)->first();
                if ($post and !Config::get('habraparser.update_posts'))
                    return false;
                $postData = $this->getPostData($id, $response->getResponseText(), $response->getResponseInfo()['size_download']);
                $this->savePost($postData, $post);
                unset($postData, $post);
            }
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

    }

    protected function savePost($postData, $post)
    {
        $update = false;
        if (!$post)
            $post = new Post();
        else
            $update = true;

        if ($update and !$postData) {
            $post->not_found = true;
            $post->save();
            return $post;
        } elseif (!$postData)
            return false;

        $post->id    = (int)trim($postData['id']);
        $post->title = trim($postData['title']);
//        $post->content   = trim($postData['content']);
        $post->views     = (int)trim($postData['views']);
        $post->favorite  = (int)trim($postData['favorite']);
        $post->size      = (int)trim($postData['size']);
        $post->not_found = false;
        $author_str      = trim($postData['author_str']);
        $author          = Author::where('username', '=', $author_str)->first();
        if (!$author)
            $author = Author::create(array('username' => $author_str));
        $post->author()->associate($author);
        $post->save();
        unset($author);
        $hubs = array();
        foreach ($postData['hubs_str'] as $hub_str) {
            $hub_str = trim($hub_str);
            $hub     = Hub::where('hub', '=', $hub_str)->first();
            if (!$hub)
                $hub = Hub::create(array('hub' => $hub_str));
            $hubs[] = $hub->id;
        }
        $post->hubs()->sync($hubs);
        unset($hubs);

        $tags = array();
        foreach ($postData['tags_str'] as $tag_str) {
            $tag_str = trim($tag_str);
            $tag     = Tag::where('tag', '=', $tag_str)->first();
            if (!$tag)
                $tag = Tag::create(array('tag' => $tag_str));
            $tags[] = $tag->id;
        }
        $post->tags()->sync($tags);

        foreach ($postData['comments'] as $commentData) {
            $comment = $post->comments()->where('id', '=', $commentData['id'])->first();
            if (!$comment)
                $comment = new Comment();
            $comment->id = $commentData['id'];
            $author_str  = trim($commentData['author_str']);
            $author      = Author::where('username', '=', $author_str)->first();
            if (!$author)
                $author = Author::create(array('username' => $author_str));
            $comment->author()->associate($author);
            unset($author);

            $comment->parent_id   = $commentData['parent_id'];
            $comment->message     = trim($commentData['message']);
            $comment->date_str    = trim($commentData['date_str']);
            $comment->score_total = (int)trim($commentData['score_total']);
            $comment->score_minus = (int)trim($commentData['score_minus']);
            $comment->score_plus  = (int)trim($commentData['score_plus']);

            $post->comments()->save($comment);
            unset($comment);
        }
        return $post;

    }

    protected function getPostData($id, $pageHtml, $pageSize)
    {
        $this->info("Получение данных поста #$id");
        $html = new Htmldom();
        $html->load($pageHtml);
        $post_html = $html->find('.post', 0);
        if (!$post_html) {
            $this->info('Пост в черновиках');
            $html->clear();
            unset($html);
            return false;
        }
        $data             = array();
        $data['size']     = $pageSize;
        $data['id']       = $id;
        $data['title']    = $post_html->find('span.post_title', 0)->plaintext;
        $data['hubs_str'] = array();
        foreach ($post_html->find('.hubs', 0)->find('.hub') as $hub)
            $data['hubs_str'][] = $hub->plaintext;
        $data['content']  = $post_html->find('.content', 0)->innertext;
        $data['tags_str'] = array();
        $ul_tags=$post_html->find('ul.tags', 0);
        echo $ul_tags->."\n";
        foreach ($ul_tags->find('a[rel=tag]') as $tag)
            $data['tags_str'][] = $tag->plaintext;

        $data['views']    = $post_html->find('.infopanel .pageviews', 0)->plaintext;
        $data['favorite'] = $post_html->find('.infopanel .favs_count', 0)->plaintext;
        $author_str       = $post_html->find('.infopanel .author a', 0);
        if (!$author_str) {
            $this->info('Статья не сохранена т.к. влом переделывать для rss постов');
            $html->clear();
            unset($html);
            return false;
        }

        $data['author_str'] = $author_str->plaintext;
        $post_html->clear();

        $data['comments'] = array();
        $comments_html    = $html->find('#comments', 0);
        if (!$comments_html) {
            $html->clear();
            unset($html);
            return $data;
        }
        foreach ($comments_html->find('.comment_body') as $comment_body) {
            try {
                if ($comment_body->find('.author_banned', 0)) continue;
                $author_str = $comment_body->find('.info .username', 0);
                if (!$author_str) new Exception();
                $coment_data['author_str'] = $author_str->plaintext;

                $c_id = $comment_body->find('.info', 0);
                if (!$c_id) new Exception();
                $coment_data['id'] = $c_id->rel;

                $date_str = $comment_body->find('.info time', 0);
                if (!$date_str) new Exception();
                $coment_data['date_str'] = $date_str->plaintext;

                $parent                   = $comment_body->find('.to_parent', 0);
                $coment_data['parent_id'] = 0;
                if ($parent)
                    $coment_data['parent_id'] = $parent->getAttribute('data-parent_id');

                $score = $comment_body->find('.score', 0);
                if (!$score) new Exception();
                $score_info = $score->title;
                preg_match('#\d+:.*?(\d+).*?(\d+)#', $score_info, $matches);
                $coment_data['score_plus']  = $matches[1];
                $coment_data['score_minus'] = $matches[2];
                $coment_data['score_total'] = $matches[1] - $matches[2];

                $message = $comment_body->find('.message', 0);
                if (!$message) new Exception();
                $coment_data['message'] = $comment_body->find('.message', 0)->innertext;
                $data['comments'][]     = $coment_data;
                $comment_body->clear();
                unset($comment_body);
//                echo $coment_data['date_str'];
            } catch (Exception $e) {
                $comment_body->clear();
                unset($comment_body);
            }
        }
        $comments_html->clear();
        $html->clear();
        unset($html);
        echo get_file_size(memory_get_usage(true)) . "\n";
        $this->info("Пост #$id сохранен");
        return $data;
    }


    protected function updatePost($post, \RollingCurl\Request $response_text)
    {

    }

    protected function getIdByLink(\RollingCurl\Request $response)
    {
        if (!preg_match('#/(\d+)/#', $response->getUrl(), $matches))
            return false;
        return $matches[1];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return array(
            array('action', InputArgument::REQUIRED, 'Выберите действие'),
        );
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return array(
            array('last', null, InputOption::VALUE_OPTIONAL, 'Введите id последнего поста', null),
            array('first', null, InputOption::VALUE_OPTIONAL, 'Введите id первого поста', null),
        );
    }

}

function get_file_size($size)
{
    $units = array('Bytes', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB');
    return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $units[$i];
}