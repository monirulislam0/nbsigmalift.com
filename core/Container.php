<?php 

namespace core;

class Container {

    private $bindings = [];

    public function bind($key, $func){

        $this->bindings[$key] = $func;
    }

    public function resolver($key){

        if( ! array_key_exists($key, $this->bindings)) {

            throw new \Exception("Container did not find for $key", 1);
            
        }

        $func = $this->bindings[$key];

        return call_user_func($func);
    }
}
