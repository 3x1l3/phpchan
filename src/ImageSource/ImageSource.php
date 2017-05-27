<?php
namespace PHPChan\ImageSource;


class ImageSource extends ImageSourceAbstract
{

    public function __construct($tim, $board, $ext) {
      $this->_board = $board;
      $this->_tim = $tim;
      if (substr($ext, 0,1) == '.') {
        $this->ext = substr($ext, 1, strlen($ext));
      } else {
        $this->ext = $ext;
      }

    }
    public function getQuery() {
        return $this->_board.'/src/'.$this->_tim.'.'.$this->ext;
    }
    public function getURL()
    {

        return $this->getEndpoint().$this->getQuery();
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
