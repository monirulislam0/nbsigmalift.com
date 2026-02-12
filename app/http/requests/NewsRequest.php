<?php

namespace app\http\requests;

use core\Request; 

class NewsRequest extends Request
{

    protected function rules(){
     return   [
        'news_name' => 'required',
       'content' => 'required',
     ];
    }

    protected function errors(){
        return [
            "news_name.required" => "News name is required !! ",
            "content.required" => "Content is required !! ",
        ];
    }
}