<?php

require_once 'config.php';

$controller = new Controller();
$view = new View();

$array = json_decode($controller->get('http://a.4cdn.org/boards.json'));

$boards = new Content();

$boards->add('<ul class="list-group">');
foreach ($array->boards as $board) {
    $boards->add('<li class="list-group-item"><a href="board.php?b='.$board->board.'">'.$board->title.'</a></li>');
}

$boards->add('</ul>');

echo $view->header();
echo $boards;
