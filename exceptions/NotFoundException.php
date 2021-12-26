<?php

namespace jddev2381\phpmvc\exceptions;

/**
 * Class NotFoundException
 *
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package jddev2381\phpmvc\exceptions
 */
class NotFoundException extends \Exception
{
    protected $code = 404;
    protected $message = 'Page Not Found';


    public function __construct()
    {

    }
}