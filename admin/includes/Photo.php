<?php
    class Photo extends Db_object{
        protected static $db_table = "photos";
        protected static $db_table_fields = array('title','description', 'filename','alternate_text', 'type', 'size');
        public $id;
        public $title;
        public $description;
        public $filename;
        public $alternate_text;
        public $type;
        public $size;
        public $tmp_path;
        public $upload_directory = 'img';
        public $errors = array();

        public $upload_errors_array = array(
            UPLOAD_ERR_OK => "There is no error",
            UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload max_filesize from php.ini",
            UPLOAD_ERR_FORM_SIZE => "The upload file exceeds MAX_FILE_SIZE in php.ini voor een html form",
            UPLOAD_ERR_NO_FILE => "No file uploaded",
            UPLOAD_ERR_PARTIAL => "The file was partially uploaded",
            UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder",
            UPLOAD_ERR_CANT_WRITE => "Failed to write to disk",
            UPLOAD_ERR_EXTENSION => "A php extension stopped your upload",
        );

        /***methodes***/
        public function set_file($file){
            if(empty($file) || !$file || !is_array($file)){
                $this->errors[] = "No file uploaded";
                return false;
            }elseif($file['error'] != 0){
                $this->errors[] = $this->upload_errors_array['error'];
                return false;
            }else{
                $date = date('Y_m_d-H-i-s');
                $without_extension = pathinfo(basename($file['name']), PATHINFO_FILENAME);
                $extension = pathinfo(basename($file['name']), PATHINFO_EXTENSION);
                $this->filename = $without_extension.$date.'.'.$extension;
                $this->type = $file['type'];
                $this->size = $file['size'];
                $this->tmp_path = $file['tmp_name'];
            }
        }

        public function save(){
            $target_path = SITE_ROOT.DS."admin".DS. $this->upload_directory.DS.$this->filename;
            if($this->id){
                $this->update();
                if(move_uploaded_file($this->tmp_path,$target_path)){//upload in de images map
                    if($this->create()){//aanmaken in de database
                        unset($this->tmp_path);
                        return true;
                    }
                }
            }else{
                if(!empty($this->errors)){
                    return false;
                }
                if(empty($this->filename) || empty($this->tmp_path)){
                    $this->errors[] = "File not available";
                    return false;
                }

                if(file_exists($target_path)){
                    $this->errors[]= "File {$this->filename} EXISTS!";
                    return false;
                }
                if(move_uploaded_file($this->tmp_path,$target_path)){//upload in de images map
                    if($this->create()){//aanmaken in de database
                        unset($this->tmp_path);
                        return true;
                    }
                }else{
                    $this->errors[] = "This folder has no write rights";
                    return false;
                }
            }
        }
        public function picture_path(){
            return $this->upload_directory.DS.$this->filename;
        }
        public function delete_photo(){
            if($this->delete()){
                $target_path = SITE_ROOT.DS.'admin'.DS.$this->picture_path();
                return unlink($target_path) ? true : false;
            }else{
                return false;
            }
        }

        public static function attachCategories($photoId,$categoriesArray){
            global $database;
            foreach($categoriesArray as $categoryId){

                $sql =  "INSERT INTO `photos_categories` (`photo_id`, `category_id`) VALUES ($photoId,$categoryId)";
                $database->query($sql);

            }
        }
        public static function attachedCategories($photoId){
            global $database;
            $sql = "SELECT category_id FROM `photos_categories` WHERE photo_id=".$photoId;
            $result = $database->query($sql);
            $rows = [];

            while($row = $result->fetch_row()) {
                $rows[] = $row;
            }
            //Maakt van de rows nu een array naar de category namen.
            $categories = [];
            if($rows){
                foreach($rows as $eenCatId){
                    $catId = implode(', ', $eenCatId);
                    $category = Category::find_by_id($catId);
                    $categories[]= $category->name;
                }
            }
            return $categories;
        }

}
?>


