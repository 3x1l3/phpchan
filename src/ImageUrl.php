<?php

class ImageUrl
{
    private $tim;
    private $threadID;
    private $board;
    private $ext = null;

    private $_args = array();

    public function __construct($tim = null, $threadID = null, $board = null)
    {
        if (null !== $tim)
          $this->_args['tim'] = $tim;
        if (null !== $threadID)
          $this->_args['threadID'] = $threadID;
        if (null !== $board)
          $this->_args['board'] = $board;
    }

    public function build($type = '')
    {
        if ($type != '')
          $this->type = $type;

        return 'image.php?'.http_build_query($this->_args);
    }
    public function setExt($ext)
    {
        if (substr($ext, 0, 1) == '.') {
            $this->_args['ext'] = substr($ext, 1, strlen($ext));
        } else {
            $this->_args['ext'] = $ext;
        }
    }

    public function __set($key, $val) {
      $this->_args[$key] = $val;

    }

    public function __get($key) {
      if (key_exists($key, $this->_args))
      $this->_args[$key];
    }
}
