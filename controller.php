<?php
use phpFastCache\CacheManager;

class Controller
{
    private $board;
    private $page;

    private $hash;

    private $thumbnail_endpoint = 'image.php?board=[board]&tim=[tim]&type=thumb';
    private $image_endpoint = 'image.php?board=[board]&tim=[tim]&ext=[ext]&type=full';

    public function __construct()
    {
        $this->board = $_GET['b'];
        $this->page = $_GET['p'];

        if (!$this->page) {
            $this->page = 1;
        }

        $this->hash = md5($this->board.$this->page);
    }

    public function get($url)
    {

        if ($this->curlEnabled()) {
            if ($response == null) {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);
                $cache->set($url, $response, 600);
            }
        } else {
            $response = file_get_contents($url);
        }

        return $response;
    }

    public function curlEnabled()
    {
        return function_exists('curl_version');
    }

    private function buildURL($page = null)
    {
        if ($page === null)
          $page = $this->page;

        return 'http://a.4cdn.org/'.$this->board.'/'.$page.'.json';
    }

    public function exec()
    {
        return $this->get($this->buildURL());
    }

    public function multiEx()
    {

        $cache = CacheManager::Files();

        $result = array();
        for ($i = 1; $i<=10; $i++) {
          $result[$i] = $cache->get($this->board."-".$i);
          if ($result[$i] === null || $_GET['resetcache'] == 1 ) {
          	$result[$i] = $this->get($this->buildURL($i));
			$cache->set($this->board.'-'.$i, $result[$i], 600);
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
        $post->ext = preg_replace("/[^a-z]/","", $post->ext, -1);
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
