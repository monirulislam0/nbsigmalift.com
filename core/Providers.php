<?php 

namespace core;

use app\http\middleware\Authentication;
use app\http\middleware\Guest;

class Providers 
{

    public static function authService(){
        return [
            'auth'  => Authentication::class,
            'guest' => Guest::class,
        ];
    }
}