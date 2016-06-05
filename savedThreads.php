<?php


require_once 'config.php';

$thread = $_GET['t'];
$threadID = $_GET['t'];
$board = $_GET['b'];

$controller = new Controller();
$view = new View();

echo $view->header('loaded');

$files = scandir('./saved/');
$bad = array('.', '..');
foreach ($files as $file) {
    if (!in_array($file, $bad)) {
        $chunks = explode('.', $file);

        $ext = $chunks[1];

        if ($ext == 'zip') {
            $threadID = $chunks[0];

            $zip = new Zip($threadID);

            $name = $zip->getNameAtIndex(0);


            $img = new ImageUrl(null, $threadID);
            $img->filename = $name;

            echo '
    <div class="thumb-cell well well-sm">
    <a href="load.php?t='.$threadID.'">  '.$threadID.' </a> <a data-toggle="modal" data-target="#'.$threadID.'">
      <i class="fa fa-trash"></i>
      </a>
  <a href="load.php?t='.$threadID.'">  <img class="thumb" src="'.$img->build('thumb').'" /></a>

'.$view->modal($threadID, 'Delete Thread '.$threadID,
$view->alert('<i class="fa fa-exclamation-circle"></i> Are you sure you want to delete this thread?', 'There is no going back after this.
<form method="POST"><br />
<p><button name="submit" class="btn btn-success delete-button" value="'.$threadID.'"><i class="fa fa-check"></i> Yes</button></p>
</form>', 'info')).'
    </div>';
        }
    }
}

echo $view->footer();
