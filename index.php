<?php

require_once 'config.php';
$controller = new Controller();
$view = new View();

$cache = phpFastCache\CacheManager::Files();
$boardsJSON = $cache->get('boards');

if ($boardsJSON === null || $_GET['nocache'] == 1) {
    $boardsJSON = $controller->get('http://a.4cdn.org/boards.json');
    $cache->set('boards', $boardsJSON, 3600 * 24);
}
$array = json_decode($boardsJSON);
$ws = array();
$nsfw = array();
foreach ($array->boards as $a) {

    if ($a->ws_board == 1) {
        $ws[] = $a;
    } else {
        $nsfw[] = $a;
    }
}

$boards = new Content();
$boards->add('<a href="savedThreads.php">Saved Threads</a>');
$boards->add('<h2>Work Safe</h2>');
$boards->add('<table  class="table table-bordered table-condensed">');
$chunks = array_chunk($ws, 5);

foreach ($chunks as $chunk) {
    $boards->add('<tr>');

    foreach ($chunk as $board) {
        $boards->add('<td class=""><a href="board.php?b='.$board->board.'">'.$board->title.'</a></td>');
    }
    $boards->add('</tr>');
}
$boards->add('</table>');
$boards->add('<h2>NSFW</h2>');
$boards->add('<table  class="boards table table-bordered table-condensed">');
$chunks = array_chunk($nsfw, 5);

foreach ($chunks as $chunk) {
    $boards->add('<tr>');

    foreach ($chunk as $board) {
        $boards->add('<td class=""><a href="board.php?b='.$board->board.'">'.$board->title.'</a></td>');
    }
    $boards->add('</tr>');
}
$boards->add('</table>');
echo $view->header();
echo $boards;
