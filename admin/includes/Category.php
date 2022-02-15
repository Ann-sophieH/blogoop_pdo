<?php
    class Category extends Db_object{
        /*** PROPERTIES ****/
        protected static $db_table = "categories";
        protected static $db_table_fields= array('name');
        public $id;
        public $name;


        /*** METHODS ****/

    }
?>
