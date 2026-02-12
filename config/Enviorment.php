<?php 
// This Class Set the Enviorment Attributes to Enviorment so that will available to everywhere
namespace config;


final class Enviorment 
{
    public function __construct(){
        $this->loadEnv(__DIR__."/../.env");
    }

    protected function loadEnv($filePath){

        if(!file_exists($filePath)){

            throw new \Exception("File not found with Giving file path '$filePath'!! ", 2);

        }
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines as $line) {
            
            if(strpos(trim($line), "#") === 0 ) continue ;

            list($key, $value) = explode("=", $line , 2);

            $key = trim($key);

            $value = trim($value);

            putenv("$key=$value");

            $_ENV[$key] = $value;

            $_SERVER[$key] = $value;

        }
    }
}