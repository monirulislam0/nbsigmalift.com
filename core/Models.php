<?php 

namespace core;

use core\App;

use core\Response;

use core\Database;

class Models {

    private $table;

    private static $instance;

    private $connection = [];

    private $getInsertId = null;

    private $insert = false ;

    private static $sql = "";

    private static $statement ;

    private static $query_results;

    private function __construct() {
        $this->initializeTable();

        $this->connection = App::resolve(Database::class);
    }

    private function initializeTable() {

        $class = get_called_class(); 

        $className = basename(str_replace('\\', '/', $class)); 

        $this->table = strtolower($className);
    }

    public static function getInstance(){

        if(self::$instance == null){
            self::$instance = new static ;
        }

        return self::$instance ;
    }

    public static function insert($attributes = []) {

        $instance = new static ;

        $parse_sql = self::builder($attributes);


        $sql = "INSERT INTO " . $instance->table . " ($parse_sql[0]) VALUES ($parse_sql[1])";

        self::query($sql, $attributes);

        (self::getInstance())->insert = true ;

        return $instance ;
    }

    protected static function builder($attributes) {

        $keys = array_keys($attributes);

        $columns = implode(', ', $keys);

        $values = ":" . implode(", :", $keys);

        return [$columns, $values];
    }

    public static function query($sql, $values){

       
        
       try {
        $connection =  self::getInstance()->connection; 

        $statement =  $connection->prepare($sql);

        $statement->execute($values);

        self::$statement = $statement;
        
       } catch (\Exception $e) {
         dd($e->getMessage());
       }

        return new static ;

    }
    public static function create($attributes = []){

        return self::insert($attributes);
    
    }

    public function getInsertId(){
        
       $connection =  self::getInstance()->connection;

       return $connection->lastinsertid();

    }

    public static function find($value, $column= 'id'){

        $instance = new static ;

        self::$sql = "SELECT * FROM $instance->table WHERE $column = ?";

        self::query(self::$sql, [$value]);

        self::$query_results = self::$statement->fetch();

        return new static;
    }

    public static function where($value, $column = "id"){

        $instance = new static ;

        self::$sql = "SELECT * FROM $instance->table WHERE $column = ?";

        self::query(self::$sql, [$value]);

        self::$query_results = self::$statement->fetchAll();

        return new static;

    }

    public static function findOrFail($value, $column = 'id'){

       $item =  self::find($value, $column);

       if(! $item) abort(Response::NOT_FOUND);

        return $item ;

    }

    public static function paginate($limit_per_page = 15, $page_number = 1){

        $instance = new static ;

        $page_number = $page_number; 

        $rows_per_page = (int) $limit_per_page;

        $offset = (int) (($page_number - 1) * $rows_per_page);


        self::$sql = "SELECT * FROM $instance->table LIMIT $rows_per_page OFFSET $offset";

       
        self::query(self::$sql, []);

        self::$query_results = self::$statement->fetchAll();

        return self::$query_results;        
    }
    public function get(){

        return self::$query_results;

    }

    public static function all(){
        
        $instance = new static ;

        $sql = "SELECT * FROM $instance->table";

        self::query($sql, []);

        self::$query_results = self::$statement->fetchAll();

        return new static;
    }

    public function first(){

        $results = self::$query_results;

        if(! empty($results)){

             self::$query_results = $results[0];

             return $this;
        }

       abort(Response::NOT_FOUND);
    }

    public static function orderBy($column = 'id', $parameters){

        $static = new static;

        $sql = "SELECT * FROM $static->table ORDER BY $column $parameters";

        self::query($sql, []);

        self::$query_results = self::$statement->fetchAll();

        return new static;

    }
    
    private static function UpdateBuilder($attributes, $id){

        $static = new Static ;

        $fields = implode(', ', array_map(fn($key) => "$key = :$key", array_keys($attributes)));
       
        $sql = "UPDATE ".$static->table." SET $fields WHERE id = :id";

        $values = array_merge($attributes , ['id' => $id]);

        return [$sql, $values];
     
    }

    public function update($attributes){

        $id = self::$query_results['id'];

         $sql = self::UpdateBuilder($attributes, $id);

        self::query($sql[0], $sql[1]);

        return true;
    }

    public function Delete(){

       $static = new static; 

       $id =  self::$query_results['id'];

       $sql = "DELETE FROM $static->table WHERE id = $id";

      (bool) $status = self::query($sql, []);
     
      return $status;

    }
    
    public static function search($search_key = ''){
        
        $instance = new static ;

        self::$sql = "SELECT * FROM $instance->table WHERE product_title LIKE :product_title";

        self::query(self::$sql, [":product_title" => "%$search_key%"]);

        self::$query_results = self::$statement->fetchAll();

        return new static;
    }

}
