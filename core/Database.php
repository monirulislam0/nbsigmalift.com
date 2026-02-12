<?php 

namespace core;

use PDO;

final class Database 
{

    protected $db_name  ;

    protected $db_user ;

    protected $password  ;

    protected $db_host ;

    protected $driver ;

    protected $port;

    protected $pdo;

    public function __construct (){
        // Ensure environment variables are correctly set
        $this->db_name = getenv("DATABASE");
        $this->db_user = getenv("USER");
        $this->password = getenv("PASSWORD");
        $this->db_host = getenv("HOST");
        $this->driver = getenv('DRIVER');
        $this->port = getenv('PORT');

        $this->connect();
    }


    protected function connect(){

        try {

            $dsn="$this->driver:host=$this->db_host;port=$this->port;dbname=$this->db_name;charset=utf8mb4";

            $this->pdo = new PDO($dsn, $this->db_user, $this->password,[
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_PERSISTENT => false,
            ]);
        } catch (\PDOException $e) {
           // echo phpinfo();
            die("Database connection failed: " . $e->getMessage());

        }

    }

    public function getConnection(){

        return $this->pdo;
        
    }
}