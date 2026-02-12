<?php

namespace app\http\requests;

use core\Request; 

class LoginRequest extends Request
{

    protected function rules(){
     return   [
        "email"     => 'required|email',
        "password"  => 'required|min:6|max:18',
     ];
    }

    protected function errors(){
        return [
            "email.required" =>"Email is required !!",
            "email.email" =>"This field supposed to be an email !!",
            "password.required" => "Password is required",
            "password.min:6" => "Password is minimum 6 charecters",
            "password.max:12" => "Password is max 12 Charecters",
        ];
    }
}