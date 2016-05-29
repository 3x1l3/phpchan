<?php

session_start();
require_once 'config.php';
use phpFastCache\CacheManager;
use ImageSource\ImageSource;
use ImageSource\ThumbnailSource;

$board = $_GET['board'];
$tim = $_GET['tim'];
$ext = $_GET['ext'];

$threadID = $_GET['threadID'];

$filename = $_GET['filename'];

$type = isset($_GET['type']) ? $_GET['type'] : null; //::Thumb or full

if (isset($board) && isset($tim)) {
    $cache = CacheManager::Files();

    if ($type == 'thumb') {
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
    }
} elseif (isset($filename) && isset($threadID)) {
    $chunks = explode('.', $filename);
    $ext = $chunks[1];

    /*
   * Load from Zip Archive.
   * @var ZipArchive
   */
    $zip = new ZipArchive();
    $res = $zip->open('./saved/'.$threadID.'.zip');

    if ($res) {
        if ($type == 'thumb') {
            $data = $zip->getFromName('thumbs/'.$chunks[0].'.jpg');
            $ext = 'jpg';

            //::if no thumbnail file was found use original.
            if ($data === false) {
              $data = $zip->getFromName($filename);
              $ext = $chunks[1];
            }

        } else {
          $data = $zip->getFromName($filename);
      }
    }
    $zip->close();
}

switch ($ext) {
case 'gif': $ctype = 'image/gif'; break;
case 'png': $ctype = 'image/png'; break;
case 'jpeg':
case 'jpg': $ctype = 'image/jpeg'; break;
case 'webm': $ctype = 'video/webm'; break;
default:
}
header('Content-type: '.$ctype);
echo  $data;
    exit();
