<?php 

use core\Container;
use core\Database;
use core\App;

use core\Providers;

$container = new Container;

$container->bind(Database::Class, function (){

    return (new Database)->getConnection();

});

foreach ( Providers::authService() as $key => $value) {
    
    $container->bind($key, function () use($value) {

       return new $value ;
       
    });
}




//Binding to App 
App::setContainer($container);