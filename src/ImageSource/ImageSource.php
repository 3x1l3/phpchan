<?php
namespace ImageSource;


class ImageSource extends ImageSourceAbstract
{

    public function __construct($tim, $board, $ext) {
      $this->_board = $board;
      $this->_tim = $tim;
      $this->_ext = $ext;

    }
    public function getQuery() {
        return $this->_board.'/'.$this->_tim.'.'.$this->_ext;
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
        return 'http://i.4cdn.org/';
    }
}
