<?php
include('config.php');

$db = new DB();
$var = $db->select('threads', array('ID'=>'=123'));
var_dump($var);
