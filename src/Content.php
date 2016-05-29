<?php

class Content {

	//::Content array to store content in. simple.
	private $_content = array();

	public function __construct() {

	}

	public function add($html) {
		array_push($this->_content,$html);
	}
	public function build() {
		return implode("\n", $this->_content);
	}
	public function __toString() {
		return $this->build();
	}
	public function isEmpty() {
		return empty($this->_content);
	}
}
