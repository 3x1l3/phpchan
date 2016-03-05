<?php

class View {

	public function __construct() {

	}

	public function header() {
		$html[] = '<!DOCTYPE html>';
		$html[] = '<html><head>';
		$html[] = '<meta name="viewport" content="width=device-width,initial-scale=1.0">';
		$html[] = '<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" />';
		$html[] = '<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" />';

		$html[] = '<link rel="stylesheet" href="./css/styles.css" />';
		$html[] = '<link rel="stylesheet" href="./css/jquery.fancybox.css" />';
		$html[] = '</head>';
		$html[] = '<body>';
		$html[] = '<div class="container">';

		return implode("\n", $html);
	}

	public function footer() {
		$html[] = '</div>';

		$html[] = '<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>';
		$html[] = '<script src="./js/jquery.fancybox.js"></script>';

		$html[] = '<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>';
		$html[] = '<script src="./js/site.js"></script>';

		$html[] = '</body>';
		$html[] = '</html>';
		return implode("\n", $html);
	}

}
