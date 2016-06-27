<?php

use phpFastCache\CacheManager;

require_once 'config.php';

$thread = $_GET['t'];
$threadID = $_GET['t'];
$board = $_GET['b'];

$url = 'http://a.4cdn.org/'.$board.'/thread/'.$thread.'.json';

$controller = new Controller();
$view = new View();

echo $view->header();

$cache = CacheManager::files();

$thread = $cache->get($_GET['t']);

$tmp = $thread;

if ($thread === null) {
    $thread = json_decode($controller->get($url));
    $cache->set($_GET['t'], $thread, 600);
}

$count = 0;

$gif = new Content();
$webm = new Content();

$boards = $cache->get('boards');

echo $view->drawBreadcrumb($board, json_decode($boards)->boards, $threadID);
echo '';
foreach ($thread->posts as $post) {
    if ($post->filename) {
        $url = new ImageUrl($post->tim, $threadID, $board);
        $url->setExt($post->ext);
        $saved = false;
        if (file_exists('./saved/'.$threadID.'.zip')) {
            $zip = new ZipArchive();
            $res = $zip->open('./saved/'.$threadID.'.zip');
            if ($res) {
                $saved = (bool) $zip->getFromName($post->tim.''.$post->ext);
            }
        }

        if ($post->ext != '.webm') {
            $gif->Add($view->drawThumb($url, $post->h, $post->w, 'image', $saved, $count));
        } else {
            $webm->Add($view->drawThumb($url, $post->h, $post->w, 'video', $saved, $count));
        }

        ++$count;
    }
}

echo '<div class="gallery">';

if (!$webm->isEmpty()) {
    echo $webm;
}

if (!$gif->isEmpty()) {
    echo $gif;
}
echo $view->blankModal();
echo $view->footer();
