<?php
/**
 * Created by PhpStorm.
 * User: exile
 * Date: 28/05/17
 * Time: 12:08 AM
 */

namespace PHPChan\Posts;


use PHPChan\Boards\Board;
use PHPChan\Controller;
use PHPChan\Posts\PostCollection;
use PHPChan\Threads\Thread;

class PostsModel
{
    private $controller;
    private $posts;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;

    }

    public function getEndpoint(Thread $thread)
    {
        $url = str_replace('[board]', $thread->getParent()->shortTitle(), $this->controller->getEndpoint('posts'));
        $url = str_replace('[thread]', $thread->getID(), $url);
        return $url;
    }

    public function getThumbEP($board, $tim, $ext)
    {
        $url = $this->controller->thumbnail_endpoint;
        $url = str_replace('[board]', $board, $url);
        $url = str_replace('[tim]', $tim, $url);
        $url = str_replace('[ext]', $ext, $url);

        return $url;
    }

    public function getPosts(Thread $thread)
    {
        $postsJSON = $this->controller->getCache()->get('posts-' . $thread->getID());
        if ($postsJSON === null || $this->controller->nocache()) {
            $postsJSON = $this->controller->get($this->getEndpoint($thread));
            $this->controller->getCache()->set('posts-' . $thread->getID(), $postsJSON, 3600 * 24);
            var_dump($postsJSON);

        }

        $objs = json_decode($postsJSON);
        $collection = new PostCollection();
        if ($objs)
            $collection->fromStdClass($objs, $thread);

        return $collection;
    }

    public function getFirstPost(Thread $thread)
    {

    }
}