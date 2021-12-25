<?php


namespace app\core\exceptions;


/**
 * Class ForbiddenException
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package app\core\exceptions
 */

class ForbiddenException extends \Exception {

    protected $code = 403;
    protected $message = 'You don\'t have permission to access this content.';

}