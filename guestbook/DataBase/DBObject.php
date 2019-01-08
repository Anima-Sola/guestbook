<?php
    namespace guestbook;
    
    use PDO;

    class DBObject {

        static public $db; //PDO var

        public static function execQuery($query = "") {
            
            $qResult = [];

            try {
                $query = DBObject::$db->prepare($query);
                $qResult['execSuccess'] = $query->execute();
                $qResult['data'] = $query->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                $qResult['execSuccess'] = false;
                $qResult['errorMsg'] = $e->getMessage();
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
                                                                       `message_date` INT(11) DEFAULT NULL ,  
                                                                       `message_userIP` VARCHAR(39) NULL DEFAULT NULL , 
                                                                       `message_user_browser` TEXT NULL DEFAULT NULL ,  
                                                                       `message_is_moderated` TINYINT(1) DEFAULT '0' ,    
                                                                       PRIMARY KEY  (`message_id`)) ENGINE = InnoDB;");
        }
        
        
        protected static function createNewDataBase() {
            
            DBObject::execQuery("CREATE DATABASE guestbook;");
            
            DBObject::useExistsDatabase();

        }

        public static function connectToDB($dsn, $user, $password) {
                        
            try {
                
                DBObject::$db = new PDO($dsn, $user, $password);
                $isDataBaseExists = DBObject::execQuery("SHOW DATABASES LIKE 'guestbook';")['data'];

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
        
        protected static function updateMessage($params = []) {
                          
            $updatingFields = [];

            foreach($params as $param => $value) {
                $updatingFields[] = $param.'="'.$value.'"';
            }
             
            $strUpdatingFields = implode(", ", $updatingFields);
             
            $query = "UPDATE messages SET ".$strUpdatingFields." WHERE message_id=".$params['message_id'].";";
             
            $result = DBObject::execQuery($query)['execSuccess'];

            if($result) return true;

            return false;

        }

        protected static function insertMessage($params = []) {
  
            $columns = [];
            $values = [];

            foreach($params as $param => $value) {
                $columns[] = $param;
                $values[] = $value;
            }

            $strColumns = implode(", ", $columns);
            $strValues = '"'.implode('", "', $values).'"';

            $query = "INSERT INTO messages (".$strColumns.") VALUES (".$strValues.");";
      
            $result = DBObject::execQuery($query)['execSuccess'];
            
            if($result) return true;

            return false;

        }

        public static function saveMessage($params = []) {

            return ($params['message_id']) ? DBObject::updateMessage($params) : DBObject::insertMessage($params);

        }
        f
}
