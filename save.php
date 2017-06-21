<?php

use phpFastCache\CacheManager;

require_once 'config.php';
set_time_limit(0);

$thread = $_GET['t'];
$threadID = $_GET['t'];
$board = $_GET['b'];

$url = 'http://a.4cdn.org/'.$board.'/thread/'.$thread.'.json';

$controller = new \PHPChan\Controller();
$view = new \PHPChan\View($controller);

echo $view->header();

$cache = CacheManager::files();

$thread = $cache->get($_GET['t']);
$tmp = $thread;

if ($thread === null) {
    $thread = json_decode($controller->get($url));
    $cache->set($_GET['t'], $thread, 600);
}

$count = 0;

$gif = new \PHPChan\Content();
$webm = new \PHPChan\Content();

$boards = $cache->get('boards');

echo $view->drawBreadcrumb(json_decode($boards)->boards);

 function parseResponseHeaders(array $headers)
 {
     $arr = array();
     foreach ($headers as $header) {
         $chunks = explode(':', $header);
         if (count($chunks) > 1) {
             $arr[$chunks[0]] = $chunks[1];
         }
     }

     return $arr;
 }


if (!is_dir('./saved') || !file_exists('./saved')) {
    mkdir('./saved/');
}

if (!is_writable('./saved'))
  chmod('./saved/',0777);

$zip = new ZipArchive();
$res = $zip->open('./saved/'.$threadID.'.zip', ZipArchive::CREATE);
foreach ($thread->posts as $post) {
    $curl = new Curl\Curl();
    $curl2 = new Curl\Curl();

    $image = new \PHPChan\ImageSource\ImageSource($controller);
    $thumb = new \PHPChan\ImageSource\ThumbnailSource($controller);
    $image->get($board,$post->tim,$post->ext, $curl);
    $thumb->get($board, $post->tim, $post->ext, $curl2);



    $curl->response_headers = parseResponseHeaders($curl->response_headers);
    $curl2->response_headers = parseResponseHeaders($curl2->response_headers);

    if ($res === true) {
        if ($zip->locateName($post->tim.$post->ext) === false && strlen(trim($post->ext)) > 0) {
            $zip->addFromString($post->tim.$post->ext, $curl->response);
            $zip->addFromString('thumbs/'.$post->tim.'.jpg', $curl2->response);
        }
    }

    if ($post->filename) {
      $img = new \PHPChan\ImageUrl($post->tim, $threadID, $board);
      $img->filename = $name;

        if ($post->ext != '.webm') {
            $gif->Add($view->drawThumb($img, $post->w, $post->h, 'image'));
        } else {
            $webm->Add($view->drawThumb($img, $post->w, $post->h, 'video'));
        }
    }
}
$zip->close();

$DB = new \PHPChan\DB();
$DB->insert('threads', array('ID'=>$threadID, 'board'=>$board));


echo '<div class="gallery">';
echo '<h3>WebM</h3>';
echo '<div>'.$webm.'</div>';
echo '<h3>Other</h3>';

echo '<div>'.$gif;
echo '</div>';
echo $view->modal();
echo $view->footer();
