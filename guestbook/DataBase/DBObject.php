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

        public static function getMessageById($id) {

            $query = "SELECT * FROM messages WHERE message_id=$id";

            $result = DBObject::execQuery($query);

            return $result;

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
        
        /*protected function getMessageById () {

            $id = 1;

            $query = "SELECT * FROM messages WHERE message_id=$id";

            $result = DBObject::execQuery($query);

            return $result;

        }*/
}
