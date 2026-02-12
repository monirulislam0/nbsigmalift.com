<?php 

namespace app\http\controllers;
use app\http\requests\Request;
use app\http\requests\Abc;
class User 
{
    public function index(){

       return view('home');

    }
    public function info(Request $request){

        return dd($request->add(5,7));

    }

    public function home(Abc $abc, Request $request ){
      
   
      
    }
}