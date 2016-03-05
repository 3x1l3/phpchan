<?php
error_reporting(E_ALL);
$board = 's';
$url = 'http://a.4cdn.org/' . $board . '/1.json';

function curlget($url) {
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, $url);

	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	$response = curl_exec($ch);
	

	curl_close($ch);

	return $response;
}

$response = curlget($url);

$array = json_decode($response);

foreach ($array->threads as $thread) {
	
	foreach ($thread->posts as $post) {
		
		if (isset($post->tim))
		echo '<img src="http://t.4cdn.org/'.$board.'/'.$post->tim.'s.jpg " />';
		
	}
	
}
