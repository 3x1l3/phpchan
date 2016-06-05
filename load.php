<?php

require_once 'config.php';

$thread = $_GET['t'];
$threadID = $_GET['t'];

$controller = new Controller();
$view = new View();

echo $view->header('loaded');

$count = 0;

$gif = new Content();
$webm = new Content();

echo '<h3>Saved Thread '.$threadID.'<a href="delete.php?threadID='.$threadID.'" class="btn btn-default pull-right"><i class="fa fa-trash"></i></a></h3>';
echo '';

$zip = new Zip($threadID);

if ($zip->hasResource()) {
    for ($i = 0; $i <= $zip->getNumFiles(); ++$i) {
        $name = $zip->getNameAtIndex($i);
        $file = $zip->getFileAtIndex($i);

        $res = imagecreatefromstring($file);
        $width = imagesx($res);
        $height = imagesy($res);

        $img = new ImageUrl(null, $threadID);
        $img->filename = $name;

        $chunks = explode('.', $name);
        $extension = $chunks[1];

        if ($name != 0) {
            if ($extension != 'webm') {
                $gif->Add($view->drawThumb($img, $width, $height, 'image'));
            } else {
                $webm->Add($view->drawThumb($img, $width, $height, 'video'));
            }
        }
    }
}
echo '<div class="gallery">';

if (!$webm->isEmpty()) {
    echo '<h3>WebM</h3>';
    echo '<div>'.$webm.'</div>';
}

if (!$gif->isEmpty()) {
    echo '<h3>Other</h3>';
    echo '<div>'.$gif;
    echo '</div>';
}

echo $view->blankModal();
echo $view->footer();
