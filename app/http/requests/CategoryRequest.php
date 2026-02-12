<?php

namespace app\http\requests;

use core\Request; 

class CategoryRequest extends Request
{

    protected function rules(){
     return   [
        "category_name"     => 'required|string',
     ];
    }

    protected function errors(){
        return [
            "category_name.required" =>"Category name is required !!",
        ];
    }
}