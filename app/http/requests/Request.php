<?php 

namespace app\http\requests;

class Request 
{
    public function __construct(){
       
    }

    public function add($a, $b){
        return $a+$b;
    }
}