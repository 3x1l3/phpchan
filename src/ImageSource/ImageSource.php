<?php

namespace PHPChan\ImageSource;


use Curl\Curl;

class ImageSource
{
    private $controller;

    public function __construct($controller)
    {
        $this->controller = $controller;

    }

    public function get($board, $tim, $ext)
    {
        $curl = new Curl();

        $endpoints = $this->controller->getEndpoint('images');

        foreach ($endpoints as $endpoint) {
            $endpoint = str_replace('[board]', $board, $endpoint);
            $endpoint = str_replace('[tim]', $tim, $endpoint);
            $endpoint = str_replace('[ext]', $ext, $endpoint);

            $curl->get($endpoint);
            if ($curl->http_status_code == 200) {
                return file_get_contents($endpoint);
            }
        }


    }
}
