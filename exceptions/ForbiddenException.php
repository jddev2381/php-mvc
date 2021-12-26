<?php


namespace jddev2381\phpmvc\exceptions;


/**
 * Class ForbiddenException
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc\exceptions
 */

class ForbiddenException extends \Exception {

    protected $code = 403;
    protected $message = 'You don\'t have permission to access this content.';

}