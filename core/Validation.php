<?php

namespace core;

class Validation{

    public function required ($arr, $errors = []){

        if(empty($arr[2])){


           $this->errors[$arr[0]] = $errors["$arr[0].$arr[1]"]?? "$arr[0] field is required !!" ;

        }

        return true;
    }

    public function string ($arr, $errors = []){
       
        if(!is_string($arr[2])){

            $this->errors[$arr[0]] = $errors["$arr[0].$arr[1]"]?? "$arr[0] files is string !!" ;

        }

        return true;
    }

    public function email($arr, $errors = []){

        if(! filter_var($arr[2], FILTER_VALIDATE_EMAIL)){

            $this->errors[$arr[0]] = $errors["$arr[0].$arr[1]"]?? "$arr[0] field is should be email !!" ;

        }

        return true;
    }

    public function min($arr, $errors = []){

        if( strlen($arr[2]) < $arr[3]){

            $this->errors[$arr[0]] = $errors["$arr[0].$arr[1]"] ?? "$arr[0] filed length is greater than  $arr[3] Charecters !!"; ;

        }

        return true;
    }

    public function max($arr, $errors = []){
        if( strlen($arr[2]) > $arr[3]){

            $this->errors[$arr[0]] = $errors["$arr[0].$arr[1]"] ?? "$arr[0] filed length is less than  $arr[3] Charecters !!"; ;

        }

        return true;
    }

}

