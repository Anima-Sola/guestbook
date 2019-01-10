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

            DBObject::execQuery("CREATE TABLE `messages` ( `message_id` int(11) NOT NULL,
                                                           `message_username` varchar(100) DEFAULT NULL,
                                                           `message_useremail` varchar(100) DEFAULT NULL,
                                                           `message_userurl` varchar(100) DEFAULT NULL,
                                                           `message_messagetext` text,
                                                           `message_adminreply` text,
                                                           `message_date` int(11) DEFAULT NULL,
                                                           `message_userIP` varchar(39) DEFAULT NULL,
                                                           `message_user_browser` text,
                                                           `message_is_moderated` tinyint(1) DEFAULT '0'
                                                        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;");


            DBObject::execQuery("ALTER TABLE `messages` ADD PRIMARY KEY (`message_id`);");

            DBObject::execQuery("ALTER TABLE `messages` MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; COMMIT;");

            DBObject::execQuery("CREATE TABLE `users` ( `id` int(11) UNSIGNED NOT NULL,
                                                        `login` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                                        `email` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                                                        `password` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL
                                                      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            DBObject::execQuery("ALTER TABLE `users` ADD PRIMARY KEY (`id`);");

            DBObject::execQuery("ALTER TABLE `users` MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1; COMMIT;");

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
        
}
