<?php 

namespace core;

class App 
{
    private static  $container;

    public static function setContainer($instance = []){
      
     self::$container = $instance;

    }

    public static function getContainer(){
        
        return static::$container ;
    }
    public static function resolve($key){

        return static::getContainer()->resolver($key);
    
    }


}