<?php
session_start();
use phpFastCache\CacheManager;

require_once ("config.php");

//error_reporting(E_ALL);

$thumbnail_endpoint = 'http://t.4cdn.org/';
$image_endpoint = 'http://i.4cdn.org/';

$board = $_GET['board'];
$tim = $_GET['tim'];
$ext = $_GET['ext'];



$type = isset($_GET['type'])?$_GET['type']:null; //::Thumb or full

if (isset($board) && isset($tim)) {
  $cache = CacheManager::Files();

  if ($type == 'thumb' || is_null($type)) {
    $query = $board.'/'.$tim.'s.jpg';
    $data = $cache->get($query);

    if ($data === null) {
      $data = file_get_contents($thumbnail_endpoint.$query);
      $cache->set($query, $data, 3600*24);
    }

    $ctype = 'jpg';

  } else {
    $query = $board.'/'.$tim.'.'.$ext;
    $data = $cache->get($query);

    if ($data === null) {
      $data = file_get_contents($image_endpoint.$query);
      $cache->set($query, $data, 3600*24);
    }

    switch( $ext ) {
        case "gif": $ctype="image/gif"; break;
        case "png": $ctype="image/png"; break;
        case "jpeg":
        case "jpg": $ctype="image/jpeg"; break;
        case 'webm': $ctype="video/webm"; break;
        default:
    }


  }



  header('Content-type: ' . $ctype);
  echo $data;
exit();
}




 ?>
