<?php
require_once ("config.php");

$thread = $_GET['t'];
$board = $_GET['b'];

$url = 'http://a.4cdn.org/' . $board . '/thread/' . $thread . '.json';

$controller = new Controller();
$view = new View();

echo $view->header();

$thread = json_decode($controller->get($url));


$count = 0;

$gif = array();
$webm = array();

foreach ($thread->posts as $post) {
	if ($post->filename) {
		if ($post->ext != '.webm') {
			$gif[] = '<div class="thumb-cell well well-sm">';
			$gif[] = '<a class="image" href="' . $controller->genImageUrl($post) . '"><img class="thumb" src="' . $controller->genThumnailURL($post->tim) . '" /></a>';
			$gif[] =  '</div>';
		} else {
			$id = md5($post->filename);
			
			$webm[] =  '<div class="thumb-cell well well-sm">';
			$webm[] = '<a class="webm"  href="#' .$id. '"><img class="thumb" src="' . $controller->genThumnailURL($post->tim) . '" /></a>';
			$webm[] =  '<div style="display: none"><div id="'.$id.'"><video src="' . $controller->genImageUrl($post) . '" controls></video></div></div>';
			$webm[] =  '</div>';
		}

		$count++;
	}

}
echo '<div class="gallery">';
echo '<h3>WebM</h3>';
echo implode('',$webm);
echo '<h3>Other</h3>';
echo implode('', $gif);
echo '</div>';

echo $view->footer();
