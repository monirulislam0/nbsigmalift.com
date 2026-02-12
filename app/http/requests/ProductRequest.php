<?php

namespace app\http\requests;

use core\Request; 

class ProductRequest extends Request
{

    protected function rules(){
     return   [
        'productName' => 'required',
       'productCategory' => 'required',
       'productPrice' => 'required',
       'productShortDescription' => 'required',
       'productLongDescription' => 'required',
     ];
    }

    protected function errors(){
        return [
            "productName.required" => "Product name is required !! ",
            "productCategory.required" => "Product category is required !! ",
            "productPrice.required" => "Product price is required !! ",
            "productShortDescription.required" => "Product Short Description  is required !! ",
            "productLongDescription.required" => "Product Long Description  is required !! ",
        ];
    }
}