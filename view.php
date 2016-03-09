<?php

class View {

	public function __construct() {

	}

	public function header() {
		
		$content = new Content();
		$content->add( '<!DOCTYPE html>');
		$content->add( '<html><head><title>PHPChan</title>');
		$content->add( '<meta name="viewport" content="width=device-width,initial-scale=1.0">');
		$content->add( '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />');
		$content->add( '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />');

		$content->add( '<link rel="stylesheet" href="./css/styles.css" />');
		$content->add( '<link rel="stylesheet" href="./css/jquery.fancybox.css" />');
		$content->add( '</head>');
		$content->add( '<body>');
$content->add('<h1>PHPChan</h1>');
		$content->add( '<div class="container-fluid">');

		return $content;
	}

	public function footer() {
		$content = new Content();
		$content->add( '</div>');

		$content->add( '<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>');
		$content->add( '<script src="./js/jquery.fancybox.js"></script>');

		$content->add( '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>');
		$content->add( '<script src="./js/site.js"></script>');

		$content->add( '</body>');
		$content->add( '</html>');
		return $content;
	}

}
