<?php


namespace app\core;


/**
 * Class Response
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package app\core
 */

 class Response {


    public function setStatusCode(int $code) {
        http_response_code($code);
    }

    public function redirect($url) {
        header("Location: " . $url);
    }


 }