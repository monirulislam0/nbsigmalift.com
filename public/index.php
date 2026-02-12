<?php 
// error_reporting(E_ALL);
// ini_set('display_errors', 1);
error_reporting(0);
session_start();

use core\Router;

const BASE_PATH = __DIR__.'/../';


// Functions PHP is the file of universel for methods and other functinality !!
// This file also for Autoload Functionality 
// If anything implements later don't forget to link this file  top of the php file 
require  __DIR__.'/../functions.php';


require __DIR__."/../boostrap.php";



// Initial Routing Functionalities !!! By creating instance of Router !!
require __DIR__.'/../routes/web.php';


//It is run routing algorithm 

Router::route();


session_flashed();