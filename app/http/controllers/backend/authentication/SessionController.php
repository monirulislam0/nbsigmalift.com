<?php 

namespace app\http\controllers\backend\authentication;

use app\http\requests\LoginRequest;

use core\Auth;

use core\Session;

class SessionController 
{

    public function Hash(){

        echo hash_make("test");

    }

    public function Create(){
        return view('backend/login');
    }

    public function Store(LoginRequest $req){
        
        $arr = [
            'email' => $req->request('email'),
            'password' => $req->request('password'),
        ];

       $status =  attempt($arr);

    

       if (! $status){

            Session::flash('message', "Credential is not correct !! Try again with correct credential !!");

            return back();
        }

        redirect("/admin/dashboard");
    }

    public function Destroy(){

        // logout();
        Auth::logout();

        redirect("/session/create");

    }


}