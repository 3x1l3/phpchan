<?php
namespace PHPChan\ImageSource;

abstract class ImageSourceAbstract
{
    private $_thumbnail_endpoint = 'https://media.8chan.net/';
    private $_image_endpoint = 'https://media.8chan.net/';

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
