<?php

namespace ImageSource;

class ThumbnailSource extends ImageSourceAbstract
{

  public function __construct($tim, $board) {
    $this->_tim = $tim;
    $this->_board = $board;
  }
    public function getURL()
    {
        return $this->getEndpoint().$this->getQuery();
    }
    public function getQuery()
    {
        return $this->_board.'/thumb/'.$this->_tim.'.jpg';
    }
    public function getData()
    {
        return file_get_contents($this->getURL());
    }

    protected function getEndpoint()
    {
        return 'https://media.8ch.net/';
    }
}
