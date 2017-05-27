<?php

namespace PHPChan\Threads;

use PHPChan\Controller;

class ThreadsModel
{
    private $controller;

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
}