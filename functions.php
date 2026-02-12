<?php 

use config\Enviorment;
use core\Helper;
use core\Session;
use core\Auth;
const DIR = __DIR__ ."/";


spl_autoload_register(function ($path) {

    $path = str_replace('\\', '/', $path);

    $filePath = __DIR__ . '/' . $path . '.php';

    if (!file_exists($filePath)) {

        throw new Exception("\"Error: $filePath does not exist\"", 1);
        
    }

    require_once $filePath;

});

// Database Initial to make sure everyfile get the database;



// This new instance of inviourment will available all .env configuration everywhere  !!
new Enviorment ;

// =================================================================

// Die and Dump 

function dd($val){

    echo "<pre>";

    var_dump($val);

    echo "</pre>";

    die();

}

function abort($code = 404){

    Helper::abort($code);

    die();

}


function view($path, $attributes = []){

    // Extract Your array data like a variable !!
    
    extract($attributes);

    require_once __DIR__."/resources/views/$path.view.php";
    
}


function assets($path = null):string
{

    return "$path";

}

function base_url(){
    $site_url = null;
  if(getenv('SITE_URL'))
     {

        $site_url =  getenv('SITE_URL') ;

    } else {

        $site_url =  $_SERVER["HTTP_HOST"];

   }

   if( !filter_var($site_url, FILTER_VALIDATE_URL) ){
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https://" : "http://";
    $site_url = $protocol . $site_url;
   }

   return $site_url;

}

function base_path($path = null):string{
    return __DIR__."$path";
};

 function template_include($path, $attributes = []){
    extract($attributes);
    require_once base_path("/resources/views".$path.".php");

}

//Redirect 

function redirect($path = null , $forced = false){

    if($forced){
        header("Location: $path");
        exit;
    }

    $currentUrl = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    
    $targetUrl = rtrim(base_url(), '/') . '/' . ltrim($path, '/');

    if ($currentUrl === $targetUrl) {
        error_log("Redirect prevented to avoid a loop: $targetUrl");
        exit; // Avoid the redirect
    }

    header("Location: $targetUrl");

    exit;

}
//Slug Builder
function makeSlug($string) {
    $string = strtolower($string);
    $string = strip_tags($string);
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = preg_replace('/[^a-z0-9\s-]/', '', $string);
    $string = preg_replace('/[\s-]+/', '-', $string);
    $string = trim($string, '-');
    return $string;
}

function back()
{
    return redirect($_SERVER['HTTP_REFERER'], true) ;
}

function errors(){

   return Session::get("errors");

}

function error($key = null){

    return Session::getError($key);

}

function old($key = null){

    if($key == null){
        return Session::get("old");
    }

     return Session::getOld($key);

   
}


function session_flashed(){

    Session::flashed();

}

function attempt($arr = null){
  
    return Auth::attempt($arr);

}


function hash_make($value) {

    return hash("sha256", $value);

}

function hash_match($value, $hashed): bool {

    return hash_make($value) === $hashed;

}

function session_get($key){

    return Session::get($key);
    
}

function logout(){

    return Auth::logout();
}

function public_path($path = null){

    return base_path("/public".$path);
}