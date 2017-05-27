<?php
require_once 'config.php';

use PHPChan\Content;
use PHPChan\Controller;
use PHPChan\View;

$controller = new Controller();
$view = new View($controller);

$boardsObject = new \PHPChan\Boards\BoardsModel($controller);
$boardsView = new View\BoardsView();

$boards = new Content();
$boards->add('<h2>Work Safe</h2>');
$boards->add($boardsView->drawTable($boardsObject->getSafeBoards()));
$boards->add('<h2>NSFW</h2>');
$boards->add($boardsView->drawTable($boardsObject->getUnsafeBoards()));


echo $view->header();
echo $boards;
