<?php
use phpFastCache\CacheManager;

require_once ("config.php");

$thread = $_GET['t'];
$threadID = $_GET['t'];
$board = $_GET['b'];

$url = 'http://a.4cdn.org/' . $board . '/thread/' . $thread . '.json';

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
echo '<a href="save.php?t='.$threadID.'&b='.$board.'">Save Thread</a>';

foreach ($thread->posts as $post) {
	if ($post->filename) {
		$url = new ImageUrl($post->tim, $threadID, $board);
	$url->setExt($post->ext);
		if ($post->ext != '.webm') {
			$gif->Add($view->drawThumb($url, $post->h, $post->w));
		} else {
			$webm->Add($view->drawThumb($url, $post->h, $post->w));
		}

		$count++;
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
