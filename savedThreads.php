<?php

use phpFastCache\CacheManager;

require_once 'config.php';

$thread = $_GET['t'];
$threadID = $_GET['t'];
$board = $_GET['b'];

$url = 'http://a.4cdn.org/'.$board.'/thread/'.$thread.'.json';

$controller = new Controller();
$view = new View();

echo $view->header();

$result = $mysqli->query("SELECT * FROM threads");

if ($result->num_rows > 0) {

  while ($row = $result->fetch_assoc()) {

      echo '<a href="load.php?t='.$row['ID'].'">'.$row['ID'].'</a><br />';

  }


}

echo $view->footer();
