<?php

namespace PHPChan\Posts;

use PHPChan\Threads\Thread;

class Post
{
    private $data;
    private $parent;

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

    public function setParent(Thread $thread)
    {
        $this->parent = $thread;
    }

    public function getParent()
    {
        return $this->parent;
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