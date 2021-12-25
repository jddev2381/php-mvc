<?php

namespace app\core\exceptions;

/**
 * Class NotFoundException
 *
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package app\core\exceptions
 */
class NotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Page Not Found';


    public function __construct()
    {

    }
}