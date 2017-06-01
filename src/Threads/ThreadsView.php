<?php
/**
 * Created by PhpStorm.
 * User: exile
 * Date: 31/05/17
 * Time: 10:37 PM
 */

namespace PHPChan\Threads;


use PHPChan\Posts\Post;
use PHPChan\Posts\PostsModel;

class ThreadsView
{
    private $controller;
    public function __construct($controller)
    {
        $this->controller = $controller;
    }

    public function drawThreadLink(Post $first)
    {
        $postModel = new PostsModel($this->controller);
        $out = '<a  href="thread.php?t=' . $first->no . '&b=' . $first->getParent()->getParent()->shortTitle() . '"><div data-toggle="tooltip" data-html="true" title="<i class=\'fa fa-file-image-o\'></i> ' . $first->images . '<br/>' . str_replace('"', "\'", $first->com) . '" class="col-md-2 col-sm-3 col-xs-6 board">';

        if ($saved)
            echo '<i class="btn btn-default fa fa-floppy-o"></i>';

        $thumb = new \PHPChan\ImageSource\ThumbnailSource($this->controller);
        $out .= '<div class="well well-sm" ><div style="background-image: url(' . $postModel->getThumbEP($first->getParent()->getParent()->shortTitle(), $first->tim, $first->getExt()) . ')">';
        //. '<img class="thumb" src="' . $controller -> genThumnailURL($first -> tim) . '" />';
        //echo '' . $first -> sub . '';
        //echo '<p>' . $first -> com . '</p>';
        //echo '<br /><i class="fa fa-file-image-o"></i> ' . $first -> images;
        $out .=  '</div></div></div></a>';
        return $out;
    }
}