<?php

class ImageUrl
{
    private $tim;
    private $threadID;
    private $board;
    private $ext = null;
    public function __construct($tim, $threadID, $board = null)
    {
        $this->tim = $tim;
        $this->board = $board;
        $this->threadID = $threadID;
    }

    public function build($type = '')
    {
        $args = array('tim' => $this->tim, 'threadID' => $this->threadID, 'type'=>$type);

        if (null !== $this->board) {
            $args['board'] = $this->board;
        }

        if (null !== $this->ext)
          $args['ext'] = $this->ext;

        return 'image.php?'.http_build_query($args);
    }
    public function setExt($ext) {
      if (substr($ext, 0,1) == '.') {
        $this->ext = substr($ext, 1, strlen($ext));
      }
      else {

      $this->ext = $ext;
    }
    }
}
