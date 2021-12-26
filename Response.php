<?php


namespace jddev2381\phpmvc;


/**
 * Class Response
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc
 */

 class Response {


    public function setStatusCode(int $code) {
        http_response_code($code);
    }

    public function redirect($url) {
        header("Location: " . $url);
    }


 }