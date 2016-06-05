<?php

$threadID = $_POST['threadID'];

$filepath = '../saved/'.$threadID.'.zip';
$result = unlink($filepath);

echo $result;
