<?php
use phpFastCache\CacheManager;

require_once 'config.php';

$controller = new Controller();
$view = new View();


$cache = CacheManager::Files();
$boardsJSON = $cache->get('boards');

if ($boardsJSON !== null) {
  $boardsJSON = $controller->get('http://a.4cdn.org/boards.json');
  $array = json_decode($boardsJSON);
  $cache->set('boards',json_encode($array), 3600*24);
}
$array = json_decode($boardsJSON);


$boards = new Content();

$boards->add('<ul class="list-group">');
foreach ($array->boards as $board) {
    $boards->add('<li class="list-group-item"><a href="board.php?b='.$board->board.'">'.$board->title.'</a></li>');
}

$boards->add('</ul>');

echo $view->header();
echo $boards;
