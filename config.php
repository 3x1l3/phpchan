<?php
error_reporting(0);
if ($_GET['debug'] == 1)
    error_reporting(E_ALL & ~E_NOTICE);

require_once('vendor/autoload.php');


if ($_GET['debug'] == 1)
    error_reporting(E_ALL & ~E_NOTICE);
