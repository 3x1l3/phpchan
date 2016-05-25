<?php

class ImageUrl
{
    private $tim;
    private $threadID;
    private $board;

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

        return 'image.php?'.http_build_query($args);
    }
}
