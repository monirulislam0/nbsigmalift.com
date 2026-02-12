<?php

namespace app\http\requests;

use core\Request; 

class FaqRequest extends Request
{

    protected function rules(){
     return   [
        'page_content'  => 'required',
        'page_title'    => 'required'
     ];
    }

    protected function errors(){
        return [
           'page_content.required' => 'Page content are essential , You cannot move next without me !!',
           'page_title.required' => 'Page content are essential , You cannot move next without me !!'
        ];
    }
}