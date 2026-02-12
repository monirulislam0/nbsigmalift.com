<?php 

namespace app\http\controllers\backend;

use app\http\models\User;


class HomeController 
{

    public function index():void
    {
      
        view('/backend/index');
    }

    public function login(){

        view("/backend/login");

    }
}
