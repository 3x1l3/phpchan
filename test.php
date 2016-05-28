<?php
require_once('config.php');

$result = $mysqli->query("SELECT * FROM images WHERE ID = 276");

if ($result->num_rows > 0) {
$data = $result->fetch_assoc();
  header('Content-Type: '.$data['image_type']);
  echo $data['image'];
  $result->close();

}
