<?php
    require_once("config.php");
    class Database{
        /** class properties **/
        public $connection;
        /** class methods **/
        public function open_db_connection(){
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=UTF8"; //params voor connectie db
            try{
                $this->connection = new PDO($dsn, DB_USER, DB_PASSWORD);
                if ($this->connection){
                    echo "Connected to the " . DB_NAME . " database successfully!"; //
                }
            } catch (PDOException $e){
                echo $e->getMessage();
            }
        }
        public function query($sql, $properties = NULL){
            if (!$properties){
                $result =  $this->connection->query($sql); //
                return $result;
            }
            $result = $this->connection->prepare($sql);

            $result->execute($properties); //binding & uitvoeren sql
            $this->confirm_query($result);
            return $result;
        }
       /* public function query($sql){
            $result = $this->connection->query($sql);
            $this->confirm_query($result);
            return $result;
        } */
        private function confirm_query($result){
            if(!$result){
                die("Query kan niet worden uitgevoerd " . $this->connection->error);
            }
        }
        /*public function escape_string($string){
            $escaped_string = $this->connection->real_escape_string($string);
            return $escaped_string;
        }*/
        public function the_insert_id(){
            return $this->connection->lastInsertId();
        }

        function __construct(){
            $this->open_db_connection();
        }
    }
    $database = new Database();
?>
