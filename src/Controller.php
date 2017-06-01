<?php

namespace PHPChan;

use phpFastCache\CacheManager;

class Controller
{
    private $board;
    private $page;

    private $hash;

    public $thumbnail_endpoint = 'image.php?board=[board]&tim=[tim]&type=thumb&ext=[ext]';
    private $image_endpoint = 'image.php?board=[board]&tim=[tim]&ext=[ext]&type=full';
    private $endpoints = [
        'boards' => 'http://8ch.net/boards.json',
        'threads' => 'http://8ch.net/[board]/threads.json',
        'posts' => 'http://8ch.net/[board]/res/[thread].json ',
        'thumbs' => [
            'http://media.8ch.net/[board]/thumb/[tim].[ext]',
            'http://media.8ch.net/file_store/thumb/[tim].[ext]',
            'http://media.8ch.net/file_store/thumb/[tim].jpg',
            'http://media.8ch.net/[board]/thumb/[tim].jpg'
        ],
        'images' => [
            'http://media.8ch.net/[board]/[tim].[ext]',
            'http://media.8ch.net/file_store/[tim].[ext]',
            'http://media.8ch.net/file_store/[tim].jpg',
            'http://media.8ch.net/[board]/[tim].jpg'
        ]
    ];

    public function __construct()
    {
        $this->board = $_GET['b'];
        $this->page = $_GET['p'];

        if (!$this->page) {
            $this->page = 1;
        }

        $this->hash = md5($this->board . $this->page);

        if ($_GET['theme'] == 'toggle') {
            $this->setTheme((int)!$this->getTheme());
        }

    }

    public function getPage()
    {
        return $this->page;
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function get($url)
    {
        $response = file_get_contents($url);
        return $response;
    }

    public function getCache()
    {
        return CacheManager::Files();

    }
    public function nocache() {
        return $_GET['nocache'] == 1 || $_COOKIE['nocache'] == 1;
    }

    public function getEndpoint($key)
    {
        if (isset($this->endpoints[$key])) {
            return $this->endpoints[$key];
        }
    }

    /**
     * Get the theme. 0 = light 1= dark
     * @return int
     */
    public function getTheme()
    {
        $theme = $_SESSION['phpchan']['theme'];

        if (!$theme) {
            return 0;
        }
        return $theme;
    }

    public function setTheme($val)
    {
        $_SESSION['phpchan']['theme'] = $val;
    }

    /**
     * Get the current Uri
     */
    public function getUrl()
    {

        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    }

    public function curlEnabled()
    {
        return function_exists('curl_version');
    }

    private function buildURL($page = null)
    {
        if ($page === null) {
            $page = $this->page;
        }

        return 'http://a.4cdn.org/' . $this->board . '/' . $page . '.json';
    }

    public function exec()
    {
        return $this->get($this->buildURL());
    }

    public function multiEx()
    {
        $cache = CacheManager::Files();

        $result = array();
        for ($i = 1; $i <= 10; ++$i) {
            $result[$i] = $cache->get($this->board . '-' . $i);
            if ($result[$i] === null || $_GET['resetcache'] == 1) {
                $result[$i] = $this->get($this->buildURL($i));
                $cache->set($this->board . '-' . $i, $result[$i], 600);
            }
        }

        return $result[$this->page];
    }

    public function genThumnailURL($tim)
    {
        $tmp = $this->thumbnail_endpoint;
        $tmp = str_replace('[board]', $this->board, $tmp);
        $tmp = str_replace('[tim]', $tim, $tmp);

        return $tmp;
    }

    public function genImageUrl($post)
    {
        $tmp = $this->image_endpoint;
        $post->ext = preg_replace('/[^a-z]/', '', $post->ext, -1);
        $tmp = str_replace('[board]', $this->board, $tmp);
        $tmp = str_replace('[tim]', $post->tim, $tmp);
        $tmp = str_replace('[ext]', $post->ext, $tmp);

        return $tmp;
    }

    public function getThumbnails($json)
    {
        $thumbs = array();
        $obj = json_decode($json);
        if (isset($obj->threads)) {
            foreach ($obj->threads as $thread) {
                if (isset($thread->posts)) {
                    foreach ($thread->posts as $post) {
                        if (isset($post->tim) && isset($post->replies)) {
                            $thumbs[] = $this->genThumnailURL($post->tim);
                        }
                    }
                }
            }
        }

        return $thumbs;
    }
}
