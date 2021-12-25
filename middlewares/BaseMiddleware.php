<?php


namespace app\core\middlewares;


/**
 * Class BaseMiddleware
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package app\core\middlewares
 */

abstract class BaseMiddleware {

    abstract public function execute();

}