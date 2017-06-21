<?php
require_once 'config.php';
use PHPChan\ImageSource\ImageSource;
use PHPChan\ImageSource\ThumbnailSource;
use phpFastCache\CacheManager;

$board = $_GET['board'];
$tim = $_GET['tim'];
$ext = $_GET['ext'];
$controller = new \PHPChan\Controller();

$threadID = $_GET['threadID'];

$filename = $_GET['filename'];

$type = isset($_GET['type']) ? $_GET['type'] : null; //::Thumb or full
$controller = new \PHPChan\Controller();
if (isset($board) && isset($tim)) {
    $cache = CacheManager::Files();
    $hash = md5($board.$tim.$ext.$type);

    if ($type == 'thumb') {
        $thumb = new ThumbnailSource($controller);
        //$url = $thumb->get($board, $tim, $ext);
        $data = $cache->get($hash);
        if ($data === null || $data === false || $controller->nocache()) {
            $data = $thumb->get($board, $tim, $ext);

            $cache->set($hash, $data, 3600 * 24);
        }



    } else {
        $image = new ImageSource($controller);
        $data = $cache->get($hash);
        if ($data === null || $data === false || $controller->nocache()) {
            $data = $image->get($board,$tim,$ext);
            $cache->set($hash, $data, 3600 * 24);
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
    $res = $zip->open('./saved/' . $threadID . '.zip');

    if ($res) {
        if ($type == 'thumb') {
            $data = $zip->getFromName('thumbs/' . $chunks[0] . '.jpg');
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
    case 'gif':
        $ctype = 'image/gif';
        break;
    case 'png':
        $ctype = 'image/png';
        break;
    case 'jpeg':
    case 'jpg':
        $ctype = 'image/jpeg';
        break;
    case 'webm':
        $ctype = 'video/webm';
        break;
    default:
}

if ($_GET['base64'] == 1) {
    echo base64_encode($data);
} else {
    header('Content-type: ' . $ctype);
    echo $data;
}
exit();
