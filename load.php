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

echo $view->drawBreadcrumb(json_decode($boards)->boards);


$result = $mysqli->query("SELECT * FROM images WHERE threadID = ".$threadID);
var_dump($result,$threadID);
if ($result->num_rows > 0) {

while ($row = $result->fetch_assoc()) {
  var_dump($row);
    if ($post->filename) {
        if ($post->ext != '.webm') {
            $gif->Add('<div class="thumb-cell well well-sm">');
            $gif->Add('<a class="popup-trigger" data-type="image" data-height="'.$post->h.'" data-width="'.$post->w.'"  data-img="'.$controller->genImageUrl($post).'">
				<img class="thumb" src="'.$controller->genThumnailURL($post->tim).'" /></a>
			');
            $gif->Add('</div>');
        } else {
            $id = md5($post->filename);

            $webm->Add('<div class="thumb-cell well well-sm">');
            $webm->Add('<a class="popup-trigger" data-type="video" data-height="'.$post->h.'" data-width="'.$post->w.'"  data-img="'.$controller->genImageUrl($post).'"><img class="thumb" src="'.$controller->genThumnailURL($post->tim).'" /></a>');
        //	$webm->Add('<div style="display: none"><div id="'.$id.'"><video src="' . $controller->genImageUrl($post) . '" controls></video></div></div>');
            $webm->Add('</div>');
        }

        ++$count;
    }
}
}
echo '<div class="gallery">';
echo '<h3>WebM</h3>';
echo '<div>'.$webm.'</div>';
echo '<h3>Other</h3>';

echo '<div>'.$gif;
echo '</div>';
echo $view->modal();
echo $view->footer();
