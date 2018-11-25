<?php
    namespace guestbook;
    
    use PDO;

    class DBObject {

        static public $db; //PDO var

        public static function execQuery($query = "") {
            
            $qResult = [];

            try {
                $query = DBObject::$db->prepare($query);
                $query->execute();
                $qResult = $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Операция не удалась: ' . $e->getMessage();
                var_dump($e->getMessage());
            }

            return $qResult;

        }
        
        protected static function useExistsDatabase() {
            
            DBObject::execQuery("USE guestbook;");

            DBObject::execQuery("CREATE TABLE `guestbook`.`messages` ( `message_id` INT NOT NULL AUTO_INCREMENT ,   
                                                                       `message_username` VARCHAR(100) NULL DEFAULT NULL ,  
                                                                       `message_useremail` VARCHAR(100) NULL DEFAULT NULL ,  
                                                                       `message_userurl` VARCHAR(100) NULL DEFAULT NULL ,  
                                                                       `message_messagetext` TEXT NULL DEFAULT NULL ,
                                                                       `message_adminreply` TEXT NULL DEFAULT NULL ,  
                                                                       `message_date` VARCHAR(16) NULL DEFAULT NULL ,  
                                                                       `message_userIP` VARCHAR(15) NULL DEFAULT NULL , 
                                                                       `message_user_browser` TEXT NULL DEFAULT NULL ,  
                                                                       `message_is_moderated` BOOLEAN NULL DEFAULT NULL ,    
                                                                       PRIMARY KEY  (`message_id`)) ENGINE = InnoDB;");
        }
        
        
        protected static function createNewDataBase() {
            
            DBObject::execQuery("CREATE DATABASE guestbook;");
            
            DBObject::useExistsDatabase();

        }

        public static function connectToDB($dsn, $user, $password) {
                        
            try {
                
                DBObject::$db = new PDO($dsn, $user, $password);
                $isDataBaseExists = DBObject::execQuery("SHOW DATABASES LIKE 'guestbook';");

            } catch (PDOException $e) {
                
                echo 'Подключение к базе данных не удалось: ' . $e -> getMessage();
                exit();

            }

            ($isDataBaseExists) ? DBObject::useExistsDatabase() : DBObject::createNewDataBase();

        }
        
        public function __get($name)
        {
            $funcName = 'get'.ucfirst($name);
            if (method_exists($this,$funcName ))
                return $this->$funcName();

            return null;
        }

        public function __set($name, $params = [])
        {            
            $funcName = 'set'.ucfirst($name);
            if (method_exists($this,$funcName ))
                return $this->$funcName($params);

            return null;
        }
                
        
         protected function updateRecord($params = []) {
                          
            $updatingFields = [];

            foreach($params as $param => $value) {
                if($value) $updatingFields[] = $param."='".$value."'";
            }
             
            array_shift($updatingFields);
            
            $strUpdatingFields = implode(", ", $updatingFields);
             
            $query = "UPDATE messages SET ".$strUpdatingFields." WHERE message_id=".$params['message_id'].";";
             
            $result = DBObject::execQuery($query);

            if($result) return true;

            return false;


        }

        protected function addRecord($params = []) {
  
            $columns = [];
            $values = [];

            foreach($params as $param => $value) {
                if($value) {
                    $columns[] = $param;
                    $values[] = $value;
                }
            }

            $strColumns = implode(", ", $columns);
            $strValues = "'".implode("', '", $values)."'";

            $query = "INSERT INTO messages (".$strColumns.") VALUES (".$strValues.");";
      
            $result = DBObject::execQuery($query);

            if($result) return true;

            return false;

        }

        public function saveRecord($params = []) {

            return ($params['message_id']) ? $this->updateRecord($params) : $this->addRecord($params);

        }
        
        protected function setNewMessage ($params = []) {

            return $this->saveRecord($params);

        }
        
        /*
        
        protected function getCatalog() {
         
            $result = $this->execQuery("SELECT * FROM ".self::TableName()." WHERE master_id=$master_id AND service_id=$service_id");
            return $result;

        }

        protected function setCatalogItem($params = []) {

            return $this->saveRecord($params);

        }   
        
        
        
        protected $params =[];

        public function __construct( $params = [])
        {
            $className = get_called_class();
            foreach ($params as $param_name => $param_value){
                if (property_exists($className, $param_name ))
                    $this->$param_name = $param_value;
                elseif(method_exists($this,'set'.ucfirst($param_name) )){
                    $name = 'set'.ucfirst($param_name);
                    $this->$name($param_value);
                }

            }
        }

        public function __get($name)
        {
            $sFuncName = 'get'.ucfirst($name);
            if (method_exists($this,$sFuncName ))
                return $this->$sFuncName();

            return null;
        }

        public function __set($name, $params = [])
        {
            $sFuncName = 'set'.ucfirst($name);
            if (method_exists($this,$sFuncName ))
                return $this->$sFuncName($params);

            return null;
        }

        public function execQuery($query = "") {

            $qResult = [];

            try {
                $query = Object::$db->prepare($query);
                $query->execute();
                $qResult = $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                echo 'Операция не удалась: ' . $e->getMessage();
                var_dump($e->getMessage());
            }

            return $qResult;

        }

        protected function updateRecord($params = []) {

            $class = get_called_class();
            $table = $class::TableName();
            $id = array_shift($params);
            $query = "UPDATE $table SET ";
            foreach($params as $param => $value) $query.="$param='$value', ";
            $query = substr($query, 0, -2);        
            $query.=" WHERE ".$table."_id = ".$id;
            $this->execQuery($query);

        }

        protected function addRecord($params = []) {
            $class = get_called_class();
            $table = $class::TableName();
            $query = "INSERT INTO $table (";
            $columns = "";
            $values = "";
            foreach($params as $param => $value) {
                $columns.="$param, ";
                $values.="'$value', ";
            }
            $columns = substr($columns, 0, -2);  
            $values = substr($values, 0, -2);        
            $query.=$columns.") VALUES (".$values.")";
            $this->execQuery($query);
        }

        protected function saveRecord($params = []) {
            $class = get_called_class();
            $id = $class::TableName()."_id";
            $isIdExist = (isset($params[$id])) ? $class::findById($params[$id]) : false;
            ($isIdExist) ? $this->updateRecord($params) : $this->addRecord($params);
            return $this;

        }

        public static function findById($id){

            $class = get_called_class();
            $table = $class::TableName();

            $oQuery = Object::$db->prepare("SELECT * FROM $table WHERE ".$table."_id=:need_id");
            $oQuery->execute(['need_id' => $id]);
            $aRes = $oQuery->fetch(PDO::FETCH_ASSOC);
            return $aRes;
        }*/
     
}
