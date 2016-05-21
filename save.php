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

$cache = CacheManager::files();

$thread = $cache->get($_GET['t']);
$tmp = $thread;

if ($thread === null) {
    $thread = json_decode($controller->get($url));
    $cache->set($_GET['t'], $thread, 600);
}

$count = 0;

$gif = new Content();
$webm = new Content();

$boards = $cache->get('boards');

echo $view->drawBreadcrumb(json_decode($boards)->boards);

 function parseResponseHeaders(array $headers)
 {
     $arr = array();
     foreach ($headers as $header) {
         $chunks = explode(':', $header);
         if (count($chunks) > 1) {
             $arr[$chunks[0]] = $chunks[1];
         }
     }

     return $arr;
 }

$result = $mysqli->query("SELECT * FROM threads WHERE threadID = ".$threadID);


foreach ($thread->posts as $post) {
    $curl = new Curl\Curl();
    $curl2 = new Curl\Curl();

    $image = new ImageSource\ImageSource($post->tim, $board, $post->ext);
    $thumb = new ImageSource\ThumbnailSource($post->tim, $board);

    $curl->get($image->getURL());
    $curl2->get($thumb->getURL());

    $curl->response_headers = parseResponseHeaders($curl->response_headers);
    $curl2->response_headers = parseResponseHeaders($curl2->response_headers);
    $query = "SELECT * FROM images WHERE threadID = '".$threadID."' AND tim = '".$post->tim."'";
    $result = $mysqli->query($query);

    if ($result->num_rows == 0) {
        $stmt = $mysqli->prepare('INSERT INTO images (threadID, tim, thumb, image, thumb_type, image_type, thumb_size, image_size) VALUES(?,?,?,?,?,?,?,?)');
        $null = null;
        $image_type = $curl->response_headers['Content-Type'];
        $image_size = (int) $curl->response_headers['Content-Length'];
        $thumb_size = (int) $curl2->response_headers['Content-Length'];
        $thumb_type = 'image/jpeg';
        $tim = (int) $post->tim;
        $stmt->bind_param('sibbssss', $threadID, $tim, $null, $null, $thumb_type, $image_type, $thumb_size, $image_size);
        $stmt->send_long_data(2, $curl2->response);
        $stmt->send_long_data(3, $curl->response);
        $stmt->execute();
        $result->close();
    }

    if ($post->filename) {
        if ($post->ext != '.webm') {
            $gif->Add('<div class="thumb-cell well well-sm">');
            $gif->Add('<a class="popup-trigger" data-type="image" data-height="'.$post->h.'" data-width="'.$post->w.'"  data-img="'.$controller->genImageUrl($post).'">
				<img class="thumb" src="'.$controller->genThumnailURL($post->tim).'" /></a>
			');
            $gif->Add('</div>');
        } else {
            $id = md5($post->filename);

            $webm->Add('<div class="thumb-cell well well-sm">');
            $webm->Add('<a class="popup-trigger" data-type="video" data-height="'.$post->h.'" data-width="'.$post->w.'"  data-img="'.$controller->genImageUrl($post).'"><img class="thumb" src="'.$controller->genThumnailURL($post->tim).'" /></a>');
        //	$webm->Add('<div style="display: none"><div id="'.$id.'"><video src="' . $controller->genImageUrl($post) . '" controls></video></div></div>');
            $webm->Add('</div>');
        }

        ++$count;
    }
}
echo '<div class="gallery">';
echo '<h3>WebM</h3>';
echo '<div>'.$webm.'</div>';
echo '<h3>Other</h3>';

echo '<div>'.$gif;
echo '</div>';
echo $view->modal();
echo $view->footer();
