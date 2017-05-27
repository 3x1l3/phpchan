<?php

namespace PHPChan\Boards;

use PHPChan\Controller;

class BoardsModel
{
    private $controller;

    private $boards;

    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
        $boardsJSON = $controller->getCache()->get('boards');

        if ($boardsJSON === null || $_GET['nocache'] == 1 || $_COOKIE['nocache'] == 1) {
            $boardsJSON = $controller->get($controller->getEndpoint('boards'));
            $controller->getCache()->set('boards', $boardsJSON, 3600 * 24);
        }
        $objs = json_decode($boardsJSON);

        foreach ($objs as $obj) {
            $this->boards[] = new BoardModel($obj);
        }

    }

    public function getAllBoards()
    {
        return $this->boards;
    }

    public function getSafeBoards()
    {
        $temp = [];
        foreach ($this->boards as $board) {
            if ($board->sfw == 1)
                $temp[] = $board;
        }
        return $temp;
    }

    public function getUnsafeBoards()
    {
        $temp = [];
        foreach ($this->boards as $board) {
            if ($board->sfw == 0)
                $temp[] = $board;
        }
        return $temp;
    }

    public function getBoard($name)
    {
        foreach ($this->boards as $board) {
            if ($board->uri == $name)
                return $board;
        }
        return new \stdClass();
    }

    public function getThreads(BoardModel $board)
    {
        return str_replace('[board]', $board->shortTitle(), $this->controller->getEndpoint('threads'))  ;
    }


}