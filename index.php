<?php
use phpFastCache\CacheManager;

require_once 'config.php';

$controller = new Controller();
$view = new View();


$cache = CacheManager::Files();
$boardsJSON = $cache->get('boards');

if ($boardsJSON === null) {
  $boardsJSON = $controller->get('http://a.4cdn.org/boards.json');
  $cache->set('boards',$boardsJSON, 3600*24);
}
$array = json_decode($boardsJSON);

$boards = new Content();

$boards->add('<table  class="table table-bordered table-condensed">');

$chunks = array_chunk($array->boards, 5);

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
