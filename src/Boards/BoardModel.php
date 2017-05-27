<?php

namespace PHPChan\Boards;

class BoardModel
{
    private $data;

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



    /**
     * NEEDS TO BE DEFINED CUSTOM
     * @return mixed
     */
    public function shortTitle()
    {
        return $this->uri;
    }

    /**
     * NEEDS TO BE DEFINED PER TYPE OF BOARD
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }


}