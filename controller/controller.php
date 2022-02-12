<?php
class Controller
{
    public static function  autoload($className)
    {
        $path = "model/";
        $extention = ".class.php";
        $fullPath = $path . $className . $extention;
        if (!file_exists($fullPath)) {
            return false;
        }
        include_once $fullPath;
    }
}
