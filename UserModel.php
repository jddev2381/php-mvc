<?php


namespace jddev2381\phpmvc;

use jddev2381\phpmvc\db\DbModel;


/**
 * Class UserModel Model
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package app\models
 */
abstract class UserModel extends DbModel {

    abstract public function getDisplayName(): string;


}