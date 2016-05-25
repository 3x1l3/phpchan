<?php

session_start();
require_once 'config.php';
use phpFastCache\CacheManager;
use ImageSource\ImageSource;
use ImageSource\ThumbnailSource;

//error_reporting(E_ALL);

$thumbnail_endpoint = 'http://t.4cdn.org/';
$image_endpoint = 'http://i.4cdn.org/';

$board = $_GET['board'];
$tim = $_GET['tim'];
$ext = $_GET['ext'];
$threadID = $_GET['threadID'];

$type = isset($_GET['type']) ? $_GET['type'] : null; //::Thumb or full

if (isset($board) && isset($tim)) {
    $cache = CacheManager::Files();

    if ($type == 'thumb' || is_null($type)) {
        $thumb = new ThumbnailSource($tim, $board);
        $data = $cache->get($thumb->getQuery());
        if ($data === null) {
            $data = $thumb->getData();
            $cache->set($thumb->getQuery(), $data, 3600 * 24);

        }

        $ext = 'jpg';
    } else {
        $image = new ImageSource($tim, $board, $ext);
        $data = $cache->get($image->getQuery());
        if ($data === null) {
            $data = $image->getData();
            $cache->set($image->getQuery(), $data, 3600 * 24);

        }

        switch ($ext) {
        case 'gif': $ctype = 'image/gif'; break;
        case 'png': $ctype = 'image/png'; break;
        case 'jpeg':
        case 'jpg': $ctype = 'image/jpeg'; break;
        case 'webm': $ctype = 'video/webm'; break;
        default:
    }
    }
} elseif (isset($threadID) && isset($tim)) {

    $result = $mysqli->query("SELECT * FROM images WHERE threadID = '".$threadID."' AND tim = '".$tim."'");

    if ($result->num_rows > 0) {
      $info = $result->fetch_assoc();

    if ($type == 'thumb') {
        $data = $info['thumb'];
        $ctype = $info['thumb_type'];


    } else {
      $data = $info['image'];
      $ctype = $info['image_type'];
    }


    }
    }


header('Content-type: '.$ctype);
echo( $data);
    exit();
}
