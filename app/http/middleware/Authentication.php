<?php 

namespace app\http\Middleware;

use core\Middleware ;

use core\Auth;


class Authentication extends Middleware 
{

    public function handle(){

        $this->rules();
    }

    protected function rules (){

        if(! Auth::user() ) redirect('/session/create');
    }

}