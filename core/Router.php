<?php 

namespace core;

use core\Response;

use core\middleware;

use app\http\controllers\User;

use core\Request;

use Exception;

final class Router 
{
    public static $routes = [];

    protected $uri = null;

    protected $middleware = null;

    public function __construct (){

        $url =  preg_replace('/\/+/', '/', $_SERVER['REQUEST_URI']);
        
        $url = $sanitized_url = filter_var($url, FILTER_SANITIZE_URL);
        
        $trim = parse_url(rtrim($url, '/'))['path'];

        $url =  empty($trim) ? '/' : $trim;

        $this->uri = $url;
        
    }

    protected function router(){

        $request_route = $this->uri ;
        // If the given url does not match our registered url it will redirect to 404 pages
        $route = $this->parseRoute($this->uri);
        if(null != $route){
            if($route['route'] == 'product' OR $route['route'] == 'news' || $route['route'] == "products-categories" || $route['route'] == "blog"|| $route['route'] == "products-subcategories"){
             $request_route = "/".$route['route']. "/{slug}";
            }
        }
        if(! array_key_exists($request_route , self::$routes)) abort(Response::NOT_FOUND);
        
        $method = $_REQUEST["_method"] ?? $_SERVER['REQUEST_METHOD'];

       
        if( ! method_exists(self::$routes[$request_route][0][0], self::$routes[$request_route][0][1]) ) throw new Exception("This method __\"".self::$routes[$this->uri][0][1]."\"__ does not exists", 1);
        
        //Check the requested method support for this url ;;
 
        self::checkMethodIsValidate(self::$routes[$request_route], $method );


        //Check is authenticate or not  Middleware test !!

        $middleware = self::$routes[$request_route][2] ?? null;
        
       if(! is_null($middleware) ) App::resolve($middleware);

        if(isset($route['slug'])){

            $parameters = static::LoadAllDependencyClasses(self::$routes[$request_route], $route['slug']);

        }else{
            
          $parameters = static::LoadAllDependencyClasses(self::$routes[$request_route]);

        }

        call_user_func_array([ new self::$routes[$request_route][0][0], self::$routes[$request_route][0][1]],  $parameters);
    
    }
//Parse Route For Dynamic Route and Slug
    public function parseRoute($url) {

    // General pattern to match any route and dynamic slug
    $pattern = '#^/([^/]+)/([^/]+)$#';  // Matches /{route}/{slug}
    
    // If the URL matches the pattern, extract the route and slug
    if (preg_match($pattern, $url, $matches)) {
        return [
            'route' => $matches[1],  // The route part (e.g., product, news, blog)
            'slug' => $matches[2]    // The dynamic slug part
        ];
    }
    
    return null;  
    }


    protected function add($attributes){

        extract($attributes);


    }

    static function get($route, $attributes){

        self::$routes[$route]= [$attributes,'GET'] ;

        return new static;

    }
    static function post($route, $attributes){

        self::$routes[$route]= [$attributes,'POST'] ;

        return new static;
    }
    static function put($route, $attributes){

        self::$routes[$route]= [$attributes,'PUT'] ;

        return new static;
    }
    static function fetch($route, $attributes){

        self::$routes[$route]= [$attributes,'FETCH'] ;

        return new static;
    }
    
    static function update($route, $attributes){

        self::$routes[$route]= [$attributes,'UPDATE'] ;
        
        return new static;
    }

    static function delete($route, $attributes){

        self::$routes[$route]= [$attributes,'DELETE'] ;
        
        return new static;
    }
    public static function route(){

        $static = new static ;
      
        $static->router();

    }

    protected static function LoadAllDependencyClasses($attributes, $slug = null){

        $param = new \ReflectionMethod($attributes[0][0], $attributes[0][1]);

        $requests = [];

        foreach($param->getParameters() as $parameter => $value){

            $class = $value->getClass();

            

            if($class && is_subclass_of($class->name, Request::class) ){

                $requests[] = new $class->name;

            }

        }
        if($slug != null) $requests[] = $slug;
        $requests[] = new Request;

        return $requests;
    }

    private static function checkMethodIsValidate($route , $method){
      
        if($route[1] != strtoupper($method)) throw new \Exception("This method \"$method\" is not support for this route", 1);

       return true;
    }
    public function middleware($attributes = ''){

       $keys = array_key_last(self::$routes);

       self::$routes[$keys][] = $attributes ;
       
       return new static ;

    }

}


