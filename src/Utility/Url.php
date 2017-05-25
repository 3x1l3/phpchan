<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Utility;

class Url
{

    private $string;

    public function __construct($urlString)
    {
        $this->string = $urlString;
    }

    public static function createFromGlobal()
    {
        return new self($_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']);
    }

    /**
     * Determine how to add a query variable to the URL string. Look for ?
     * @param type $key
     * @param type $value
     */
    public function appendVar($key, $value)
    {
        if (strstr($this->string, '?') === false) {
            $this->string .= '?' . $key . '=' . $value;
        } else {
            $this->string .= '&' . $key . '=' . $value;
        }
        return $this;
    }

    public function __toString()
    {
        return $this->string;
    }
}
