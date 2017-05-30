<?php
use PHPChan\Zip;
use phpFastCache\CacheManager;
use PHPChan\Controller;
use PHPChan\View;

require_once("config.php");

$cache = CacheManager::Files();
$controller = new Controller();
$view = new View($controller);

echo $view -> header();

if (!isset($_GET['p']))
	$_GET['p'] = 1;


$boardModel = new \PHPChan\Boards\BoardsModel($controller);
$threads = $boardModel->getThreads($boardModel->getBoard($_GET['b']));
$postModel = new \PHPChan\Posts\PostsModel($controller);

echo $view->drawBreadcrumb($boardModel->getBoard($controller->getBoard())->shortTitle(), $boardModel->getAllBoards());
echo $view->pagination($_GET['p'],$_GET['b']);

foreach ($threads as $thread) {
	$first = $postModel->getPosts($thread)->first();
	if ($first -> closed != 1) {

		$zip = new Zip();
		$saved = $zip->threadSaved($first->no);

		echo '<a  href="thread.php?t=' . $first -> no . '&b=' . $_GET['b'] . '"><div data-toggle="tooltip" data-html="true" title="<i class=\'fa fa-file-image-o\'></i> ' . $first -> images.'<br/>' . str_replace('"', "\'", $first -> com) .'" class="col-md-2 col-sm-3 col-xs-6 board">';

		if ($saved)
			echo '<i class="btn btn-default fa fa-floppy-o"></i>';
        $thumb = new \PHPChan\ImageSource\ThumbnailSource($controller);
		echo '<div class="well well-sm" ><div style="background-image: url(' . $postModel->getThumbEP($first->getParent()->getParent()->shortTitle(), $first->tim, $first->getExt()) . ')">';
                //. '<img class="thumb" src="' . $controller -> genThumnailURL($first -> tim) . '" />';
		//echo '' . $first -> sub . '';
		//echo '<p>' . $first -> com . '</p>';
		//echo '<br /><i class="fa fa-file-image-o"></i> ' . $first -> images;
		echo '</div></div></div></a>';
	}
}


echo $view->pagination($_GET['p'],$_GET['b']);
