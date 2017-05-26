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

echo $view->drawBreadcrumb(json_decode($boards)->boards);
echo $view->pagination($_GET['p'],$_GET['b']);
echo '<div class="grid row">';
foreach ($array->threads as $thread) {

	$first = $thread -> posts[0];

	if ($first -> closed != 1) {
		
		$zip = new Zip();
		$saved = $zip->threadSaved($first->no);

		echo '<a href="thread.php?t=' . $first -> no . '&b=' . $_GET['b'] . '"><div class="well well-sm col-md-2 board">';

		if ($saved)
			echo '<i class="btn btn-default fa fa-floppy-o"></i>';

		echo '<div class="col-md-12 col-sm-2 col-xs-2"><img class="thumb" src="' . $controller -> genThumnailURL($first -> tim) . '" /></div>';
		echo '<div class="col-md-10 col-sm-10 col-xs-10">' . $first -> sub . '';
		//echo '<p>' . $first -> com . '</p>';
		echo '<br /><i class="fa fa-file-image-o"></i> ' . $first -> images;
		echo '</div></div></a>';
	}
}
echo '</div>';

echo $view->pagination($_GET['p'],$_GET['b']);
echo $view->footer();