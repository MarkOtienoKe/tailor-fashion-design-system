<?php

/**
 * Created by PhpStorm.
 * User: mark
 * Date: 25/01/2018
 * Time: 20:57
 */
 namespace app\Helpers;

class IpAddress
{
 public static function getIpAddress(){
     return $_SERVER['REMOTE_ADDR'];
 }
}