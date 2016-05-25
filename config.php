<?php
error_reporting(0);
if ($_GET['debug'] == 1)
    error_reporting(E_ALL & ~E_NOTICE);

require_once('vendor/autoload.php');


if ($_GET['debug'] == 1)
    error_reporting(E_ALL & ~E_NOTICE);



$mysqli = mysqli_connect('localhost','phpchan','phpchan','phpchan');

	if (!$mysqli)
		die("Can't connect to MySQL: ".mysqli_connect_error());
