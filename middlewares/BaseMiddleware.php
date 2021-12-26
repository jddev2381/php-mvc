<?php


namespace jddev2381\phpmvc\middlewares;


/**
 * Class BaseMiddleware
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc\middlewares
 */

abstract class BaseMiddleware {

    abstract public function execute();

}