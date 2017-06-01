<?php
require_once("config.php");

use PHPChan\Zip;
use phpFastCache\CacheManager;
use PHPChan\Controller;
use PHPChan\View;



$cache = CacheManager::Files();
$controller = new Controller();
$view = new View($controller);

echo $view -> header();

$boardModel = new \PHPChan\Boards\BoardsModel($controller);
$threads = $boardModel->getThreads($boardModel->getBoard($controller->getBoard()), $controller->getPage());
$postModel = new \PHPChan\Posts\PostsModel($controller);
$threadView = new \PHPChan\Threads\ThreadsView($controller);

echo $view->drawBreadcrumb($boardModel->getBoard($controller->getBoard())->shortTitle(), $boardModel->getAllBoards());
echo $view->pagination($controller->getPage(),$controller->getBoard());

foreach ($threads as $thread) {
	$first = $postModel->getPosts($thread)->first();
	if ($first -> closed != 1) {

		$zip = new Zip();
		$saved = $zip->threadSaved($first->no);

	    echo $threadView->drawThreadLink($first);
	}
}


echo $view->pagination($_GET['p'],$_GET['b']);
