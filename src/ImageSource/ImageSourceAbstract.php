<?php
namespace ImageSource;

abstract class ImageSourceAbstract
{
    private $_thumbnail_endpoint = 'http://t.4cdn.org/';
    private $_image_endpoint = 'http://i.4cdn.org/';

    protected $_tim;
    protected $_ext;
    protected $_board;

    public function setTim($tim)
    {
        $this->_tim = $tim;
    }

    public function setExt($ext)
    {
        $this->_ext = $ext;
    }

    public function setBoard($board)
    {
        $this->_board = $board;
    }

    abstract public function getURL();
    abstract public function getQuery();
    abstract public function getData();
    abstract protected function getEndpoint();
}
