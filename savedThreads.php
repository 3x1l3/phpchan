<?php

use phpFastCache\CacheManager;

require_once 'config.php';

$thread = $_GET['t'];
$threadID = $_GET['t'];
$board = $_GET['b'];

$controller = new Controller();
$view = new View();

echo $view->header('saved');

$files = scandir('./saved/');
$bad = array('.','..');
foreach ($files as $file) {
  if (!in_array($file, $bad)) {
    $chunks = explode('.',$file);
    $threadID = $chunks[0];

    $zip = new Zip($threadID);
    $name = $zip->getNameAtIndex(0);
    $img = new ImageUrl(null, $threadID);
    $img->filename = $name;

    echo '<a href="load.php?t='.$threadID.'"><div class="thumb-cell well well-sm">
      '.$threadID.' <a href="delete.php?threadID='.$threadID.'" class=""><i class="fa fa-trash"></i></a>
    <img class="thumb" src="'.$img->build('thumb').'" />


    </div></a>';
  }

}





echo $view->footer();
