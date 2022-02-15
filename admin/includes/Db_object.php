<?php
    class Db_object{
        /*** METHODS ***/
        /**QUERY**/
        public static function find_this_query($sql){
            global $database;
            $result = $database->query($sql);
            $the_object_array = array();
            while($row = $result->fetch(PDO::FETCH_ASSOC)){ //fetch next row of results as associative array
                $the_object_array[] = static::instantie($row); //instantieren van object rij per rij in functie instantie()
            }
            return $the_object_array;
        }
        public static function find_all(){
            return static::find_this_query("SELECT * FROM " . static::$db_table . " ");
        }
        public static function find_by_id($id){
            $result = static::find_this_query("SELECT * FROM ". static::$db_table." WHERE id=$id"); //hier nog beveiliging opsteken ?
            return !empty($result) ? array_shift($result) : false;
            /* return static::find_this_query("SELECT * FROM users WHERE id=$user_id");*/
        }
        /**CLASS**/
        private function has_the_attribute($the_attribute){
            $object_properties = get_object_vars($this);
            return array_key_exists($the_attribute, $object_properties);
        }
        /**STATIC LATE BINDING
        Zorgt ervoor dat static methodes in overerving kunnen worden gebruikt.
         **/
        public static function instantie($result){
            $calling_class = get_called_class(); //static late binding (overervingproblematiek //Gets the name of the class the static method is called in.
            //wanneer je static late binding gebruikt.
            $the_object = new $calling_class;
            foreach($result as $the_attribute => $value){
                if($the_object->has_the_attribute($the_attribute)){
                    $the_object->$the_attribute = $value;
                }
            }
            return $the_object;
        }
        /**CRUD**/
        public function create(){
            global $database;
            //prepare the sql statement
            $properties = $this->properties();
            $sql = "INSERT INTO ". static::$db_table . " (" .implode(",",array_keys($properties)). ")";
            $sql .= " VALUES (:" . implode(",:", array_keys($properties)) . ")";
            $stmt = $database->connection->prepare($sql); //preps sql statement & stores w/o executing
            foreach($properties as $key => $value){ //loopt door properties en scheidt de kolomnaam (key) van de waarde (value)
                    $key_name = ":".$key; //bindingteken voor key plaatsen
                    $stmt->bindValue($key_name,$value); //Binds a value to a parameter
                }
            if($stmt->execute()){ //voer query uit
                $this->id = $database->the_insert_id(); //id ophalen van laatst gevormde query
                return true; //nodig?
            }else{
                return false;
            }
        }
        public function update(){
            global $database;
            $properties = $this->properties();
            $properties['id'] = $this->id;
            $properties_assoc = array();
            foreach($properties as $key => $value){ //hier moet $key => $key?
                $properties_assoc[] = "{$key}=:{$key}";//voor elke property de placeholder eraan binden om in sql te steken
            }//bv address=:address
            $sql = "UPDATE ". static::$db_table ." SET ";
            $sql .= implode(", ",$properties_assoc); //hier array met bv username=:username, address=:address
            $sql .= " WHERE id= :id"; // id ook met placeholder of gwn typecasting voldoende om sql injectie te vermijden
            // tc ->sneller?
            $stmt = $database->connection->prepare($sql);
            foreach($properties as $key => $value){
                $key_name = ":".$key;
                $stmt->bindValue($key_name,$value); //Binds a value to a parameter
            }
            $stmt->execute($properties);
            $db = $stmt->rowCount();
            return  $db == 1 ? true : false;
        }
        public function delete(){
            global $database;

            $sql = "DELETE FROM ". static::$db_table . " ";
            $sql .= "WHERE id= :id"; //. $this->id;
            $sql .= " LIMIT 1";

            $stmt = $database->connection->prepare($sql);
            $stmt->bindValue(':id',$this->id);
            $stmt->execute();
            //$affected_rows = $stmt->rowCount();
            return $stmt->rowCount()== 1;
            //return mysqli_affected_rows($database->connection) == 1 ? true : false;
        }
        public function save(){
            return isset($this->id) ? $this->update() : $this->create();
        }

        /**ABSTRACTION PROPERTIES**/
        protected function properties(){
            $properties = array();
            /**'username','password','first_name','last_name'**/
            foreach(static::$db_table_fields as $db_field){
                if(property_exists($this,$db_field)){
                    $properties[$db_field] = $this->$db_field;
                }
            }
            return $properties;
        }
       /* protected function clean_properties(){
            global $database;
            $clean_properties = array();
            foreach($this->properties()  ){
                $clean_properties[$key] = $database->escape_string($value);
            }
            return $clean_properties;
        }*/
        /**COUNT **/

        public static function count_all(){
            global $database;
            $sql = "SELECT COUNT(*) FROM " . static::$db_table;//10
            $result_set = $database->query($sql); // query is hier voldoende: er worden geen params meeggevn
            $row = $result_set->fetch(PDO::FETCH_ASSOC); //fetch het getal
            return array_shift($row); //checken wat binnenkomt in $row: wrm moet 1e van array eraf?
        }

    }
?>