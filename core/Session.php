<?php 

namespace core;

class Session 
{
    public static function put($key, $arr){

        $_SESSION[$key] = $arr ;

        return new static ;

    }

    public static function get($key) {

        return $_SESSION[$key] ?? $_SESSION['_flash'][$key] ?? [];
    }

    public static function getError($key){

        return $_SESSION["_flash"]['errors'][$key] ?? null;
        
    }

    public static function getOld($key){

        return $_SESSION["_flash"]['old'][$key] ?? null;

    }
    public static function flash($key, $arr){

        $_SESSION["_flash"][$key] = $arr;

    }

    public static function flashed(){

       unset($_SESSION['_flash']);

    }

    public static function destroy(){

        session_destroy();

        return true;
    }
}