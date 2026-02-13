<?php 



namespace app\http\controllers\backend\authentication;

use app\http\models\User;
use app\http\requests\LoginRequest;



use core\Auth;
use core\Request;
use core\Session;



class SessionController 

{



    public function Hash(){



        echo hash_make("admin1234");



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

    public function ResetPassword(){
      
        return view('backend/reset_password');
    }

    public function StorePassword(Request $req){
      $data = $req->validate(
           [
             'password' => 'required|min:8',
             'old_password' => 'required',
           ]
       );

      $user = session_get('user');

      $user = User::find($user['email'], 'email')->get();

      if(!$user)  json_encode(['status' => 404, 'message', 'User not Found']);


      if(hash_make($req->request('old_password')) != $user['password']) {

        Session::flash('message', "Old Password Does not match !");

        return back();
      }

    $user = User::find($user['email'], 'email');

    $user->update(['password'=> hash_make(trim($req->request('password')))]);

     Session::flash('success', "Password has been successfully changed!!");

     return back();

    }




}