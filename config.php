<?php
error_reporting(0);

if ($_GET['debug'] == 1)
    error_reporting(E_ALL & ~E_NOTICE);

require_once('phpfastcache.php');
require_once('library/content.php');

include ('controller.php');
include ('view.php');
