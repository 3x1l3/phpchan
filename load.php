<?php
require_once 'config.php';


$thread = $_GET['t'];
$threadID = $_GET['t'];

$controller = new Controller();
$view = new View();

echo $view->header();

$count = 0;

$gif = new Content();
$webm = new Content();

echo $view->drawBreadcrumb(json_decode($boards)->boards);

$result = $mysqli->query("SELECT * FROM images WHERE threadID = ".$threadID);

$zip = new ZipArchive();
$res = $zip->open('./saved/'.$threadID.'.zip');



if ($res) {

for ($i=0; $i <= $zip->numFiles; $i++ ) {

  $name = $zip->getNameIndex($i);
$data =  $zip->getStream($name);
  var_dump($data);
  die();

  $img = new ImageUrl($row['tim'], $threadID);
  if ($res === true) {
      $zip->addFromString($row['tim'].'.jpg', $row['image']);
  }
        if ($post->ext != '.webm') {
            $gif->Add('<div class="thumb-cell well well-sm">');
            $gif->Add('<a class="popup-trigger" data-type="image" data-height="'.$row['image_height'].'" data-width="'.$row['image_width'].'"  data-img="'.$img->build().'">
				<img class="thumb" src="'.$img->build('thumb').'" /></a>
			');
            $gif->Add('</div>');
        } else {
            $id = md5($post->filename);

            $webm->Add('<div class="thumb-cell well well-sm">');
            $webm->Add('<a class="popup-trigger" data-type="video" data-height="'.$post->h.'" data-width="'.$post->w.'"  data-img="'.$img->build().'">
            <img class="thumb" src="'.$img->build('thumb').'" /></a>');
        //	$webm->Add('<div style="display: none"><div id="'.$id.'"><video src="' . $controller->genImageUrl($post) . '" controls></video></div></div>');
            $webm->Add('</div>');
        }

        ++$count;


}
$zip->close();
}
echo '<div class="gallery">';
echo '<h3>WebM</h3>';
echo '<div>'.$webm.'</div>';
echo '<h3>Other</h3>';

echo '<div>'.$gif;
echo '</div>';
echo $view->modal();
echo $view->footer();
