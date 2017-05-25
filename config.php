<?php
session_start();

error_reporting(0);
if ($_GET['debug'] == 1 || $_COOKIE['debug'] == 1) {
    define("DEBUG",1);
    error_reporting(E_ALL & ~E_NOTICE);
} else {
    define("DEBUG", 0);
}

require_once('vendor/autoload.php');


