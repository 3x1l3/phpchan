<?php     
require_once("config.php");

$controller = new Controller();
$view = new View();

echo $view -> header();

$array = json_decode($controller -> get("http://a.4cdn.org/boards.json"));

echo '<ul class="list-group">';
foreach ($array->boards as $board) {

	echo '<li class="list-group-item"><a href="board.php?b='.$board->board.'">'.$board->title.'</a></li>';

}

echo '</ul>';
