<?php

namespace PHPChan\ImageSource;

use Curl\Curl;
use PHPChan\Controller;
use PHPChan\Posts\Post;

class ThumbnailSource
{
    private $controller;
    public function __construct(Controller $controller)
    {
        $this->controller = $controller;
    }

    public function getUrl(Post $post) {
        $curl = new Curl();

        $endpoints = $this->controller->getEndpoint('images');

        foreach ($endpoints as $endpoint) {
            $endpoint = str_replace('[board]',$post->getParent()->getParent()->shortTitle(), $endpoint);
            $endpoint = str_replace('[tim]',$post->tim, $endpoint);
            $endpoint = str_replace('[ext]',$post->getExt(), $endpoint);

            $curl->get($endpoint);
            if ($curl->http_status_code == 200)
                return $endpoint;
        }


    }


}
