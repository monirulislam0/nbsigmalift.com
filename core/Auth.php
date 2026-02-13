<?php 



namespace core;



use core\Session;



use app\http\models\User;



use core\App;



class Auth {



    public static function user(){



        return Session::get('user') ?? false ;



    }



    public static function attempt($arr = []){



      return self::login($arr);



    }



    public static function login($arr = []){



       $email = $arr['email'];

       $password = $arr['password'];



      $user =  User::find($email,'email')->get();

    

      if(! $user ){



        return false;



      }

      

      if(! hash_match($password, $user['password'])){



        return false;

        

      }



      Session::put("user", $user);



      session_regenerate_id(true);



      return true ;



    }



    public static function logout(){



      Session::destroy();

      

      return true;



    }



}