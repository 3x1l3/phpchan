<?php

namespace PHPChan\Threads;

use PHPChan\Boards\Board;

class Thread
{
    private $data;
    private $parentBoard;

    public function __construct(\stdClass $data)
    {
        $this->data = $data;
    }

    public function __get($name)
    {
        if (isset($this->data->$name)) {
            return $this->data->$name;
        }
    }

    public function setParent(Board $board)
    {
        $this->parentBoard = $board;
    }

    public function getParent()
    {
        return $this->parentBoard;
    }

    /**
     * Overwrite this one per instance
     * @return mixed
     */
    public function getID()
    {
        return $this->data->no;
    }

}