<?php


namespace app\core;

use app\core\db\DbModel;


/**
 * Class UserModel Model
 * 
 * @author JD Simpkins <jd@huntingtonwebsolutions.com>
 * @package app\models
 */
abstract class UserModel extends DbModel {

    abstract public function getDisplayName(): string;


}