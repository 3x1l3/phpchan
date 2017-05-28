<?php

namespace PHPChan\Threads;

use PHPChan\Boards\Board;
use PHPChan\Controller;

class ThreadsModel
{
    private $controller;
    private $threads;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;

    }
    public function getEndpoint($boardName) {
        return str_replace('[board]',$boardName, $this->controller->getEndpoint('threads'));
    }

    public function getThreads(Board $board)
    {
        $threadsJSON = $this->controller->getCache()->get('threads-'.$board->shortTitle());

        if ($threadsJSON === null || $_GET['nocache'] == 1 || $_COOKIE['nocache'] == 1) {
            $threadsJSON = $this->controller->get($this->getEndpoint($board->shortTitle()));
            $this->controller->getCache()->set('threads-'.$board->shortTitle(), $threadsJSON, 3600 * 24);
        }
        $objs = json_decode($threadsJSON);

        $collection = new ThreadCollection();
        $collection->fromStdClass($objs[0], $board);

        return $collection;
    }
}