<?php 

namespace core;

use core\Constant;

final class Helper
{

    public static function abort($error_code){

        return view($error_code);

    }
}