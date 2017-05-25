<?php

namespace ImageSource;

class ThumbnailSource extends ImageSourceAbstract
{

    public function __construct($tim, $board, $ext = 'jpg')
    {
        $this->_tim = $tim;
        $this->_board = $board;
        $this->_ext = $ext;
    }

    public function getURL()
    {
        return $this->getEndpoint() . $this->getQuery();
    }

    public function getQuery($alt = false)
    {
        return ($alt ? 'file_store' : $this->_board) . '/thumb/' . $this->_tim . '.'.$this->_ext;
    }

    public function getData()
    {
        $data = file_get_contents($this->getURL());
        if (!$data) {
            return file_get_contents($this->getEndpoint() . $this->getQuery(true));
        }
    }

    protected function getEndpoint()
    {
        return 'https://media.8ch.net/';
    }
}
