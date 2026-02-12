<?php

namespace app\http\requests;

use core\Request; 

class SubCategoryRequest extends Request
{

    protected function rules(){
     return   [
        "subcategory_name"     => 'required|string',
     ];
    }

    protected function errors(){
        return [
            "subcategory_name.required" =>"Subcategory name is required !!",
        ];
    }
}