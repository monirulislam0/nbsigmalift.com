<?php 

namespace core;

use core\Validation;

use core\Session;

class Request extends Validation
{
    protected $data = [];

    protected $old = [];

    protected $errors = [];

    protected $media = [];

    protected $file =  null;

    public function __construct($arr = null){

        $this->data = $_REQUEST;

        $this->media = $_FILES;

        $this->old = $this->data;

     try {
        
        $this->validate($this->rules(), $this->errors());

     } catch (\Throwable $th) {
        
     }

    }

    public function request($key = null){

        return $this->data[$key] ?? null;

    }

    public function file($key = null){

    if(! array_key_exists($key, $this->media)) return false;
    
     $this->file = $this->media[$key];

     return $this;

    }
    public function get_file(){
        return $this->file ;
    }
    public function has_file($key) {

        if( is_array($this->media[$key]['name'])) return (bool) ($this->media[$key]['name'][0]);

        return  (bool)($this->media[$key]['name']);
    }
    public function getClientOriginalName(){

        return $this->file['name'];

    }

    public function getClientOriginalExtension(){

        return pathinfo($this->file['name'], PATHINFO_EXTENSION);

    }

    public function save($path, $name){
        $tmp_name = $this->file['tmp_name'];
        $name = $path."/".$name;

        if(! is_dir($path)) mkdir($path);
    
     if( ! move_uploaded_file($tmp_name, $name)) return false;

     return true;

    }
    public function validate($attributes = [], $errors=[]){
       
        foreach($attributes as $key => $value){

          

              $funcs = explode("|", $value );

                foreach($funcs as $fn){
                    
                    if(array_key_exists($key, $this->errors)) continue;
                    
                    $slice = explode(":", $fn);

                    if(method_exists($this, $fn)){
                     
                        call_user_func([$this, $fn], [$key, $fn , $this->request($key)], $errors);

                    }elseif(method_exists($this, $slice[0])){
                       
                        call_user_func([$this, $slice[0]], [$key, $fn , $this->request($key), $slice[1] ], $errors);

                    }else{

                       echo "<h1>$fn is not Validate type !!! See the Documentation !!</h1>";

                       die();
                        
                    }

                }

        }



        if(count($this->errors) > 0) {
            Session::flash('errors', $this->errors);

            Session::flash('old', $this->old);
            return back();
        } 

       
        $this->old = [];
    }



}
