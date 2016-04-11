<?php
use phpFastCache\CacheManager;

require_once("config.php");

$cache = CacheManager::Files();
$controller = new Controller();
$view = new View();

echo $view -> header();

if (!isset($_GET['p']))
	$_GET['p'] = 1;


$json = $controller -> multiEx();
$array = json_decode($json);
$thumbs = $controller -> getThumbnails($json);

$boards = $cache->get('boards');

foreach(json_decode($boards)->boards as $board) {

	if ($board->board == $_GET['b'])
		echo '<h2><a href=".">Boards</a> <i class="fa fa-angle-double-right"></i> '.$board->title.'</h2>';

}
echo $view->pagination($_GET['p'],$_GET['b']);

foreach ($array->threads as $thread) {

	$first = $thread -> posts[0];

	if ($first -> closed != 1) {

		echo '<a href="thread.php?t=' . $first -> no . '&b=' . $_GET['b'] . '"><div class="well well-sm row board">';
		echo '<div class="col-md-2 col-sm-2 col-xs-2"><img class="thumb" src="' . $controller -> genThumnailURL($first -> tim) . '" /></div>';
		echo '<div class="col-md-10 col-sm-10 col-xs-10"><h3>' . $first -> sub . '</h3>';
		echo '<p>' . $first -> com . '</p>';
		echo '<br /><i class="fa fa-file-image-o"></i> ' . $first -> images;
		echo '</div></div></a>';
	}
}


echo $view->pagination($_GET['p'],$_GET['b']);
