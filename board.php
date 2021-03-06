<?php
use phpFastCache\CacheManager;

require_once("config.php");

$cache = CacheManager::Files();
$controller = new Controller();
$view = new View($controller);

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

		echo '<a  href="thread.php?t=' . $first -> no . '&b=' . $_GET['b'] . '"><div data-toggle="tooltip" data-html="true" title="<i class=\'fa fa-file-image-o\'></i> ' . $first -> images.'<br/>' . str_replace('"', "\'", $first -> com) .'" class="col-md-2 col-sm-3 col-xs-6 board">';

		if ($saved)
			echo '<i class="btn btn-default fa fa-floppy-o"></i>';

		echo '<div class="well well-sm" ><div style="background-image: url(' . $controller -> genThumnailURL($first -> tim) . ')">';
                //. '<img class="thumb" src="' . $controller -> genThumnailURL($first -> tim) . '" />';
		//echo '' . $first -> sub . '';
		//echo '<p>' . $first -> com . '</p>';
		//echo '<br /><i class="fa fa-file-image-o"></i> ' . $first -> images;
		echo '</div></div></div></a>';
	}
}
echo '</div>';

echo $view->pagination($_GET['p'],$_GET['b']);
echo $view->footer();