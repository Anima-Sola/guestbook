<?php
    /*
        Главный класс гостевой книги.
        Для работы необходимы сохраненные в сессии переменные, которые должны устанавливаться при авторизации пользователя:
        $_SESSION['guestbook_userName']
        $_SESSION['guestbook_userEmail']
        $_SESSION['guestbook_adminName']
        Гостевая книга имеет три состояния:
        1) Если пользователь не авторизован, то выводится форма добавления нового сообщения и список сообщений
        2) Если пользователь авторизован, и это не admin, т.е. $_SESSION['guestbook_userName'] != $_SESSION['guestbook_adminName']
        то выводится состояние состоящее из двух вкладок, первая - как в п.1, вторая - сообщения пользователя с этим именем с возможностью
        редактирования
        3) Если пользователь авторизован, и это админ, т.е. $_SESSION['guestbook_userName'] == $_SESSION['guestbook_adminName']
        то выводится состояние состоящее из двух вкладок, первая - не модерированные сообщения, вторая - все сообщения, с возможностью редактирования
    */
    namespace guestbook;

    class GuestBook {
        
        protected $filesPaths;
        
        //Подключение к БД, инициализация параметров
        function __construct() {

            require_once __DIR__.'/DataBase/DBConnect.php';
            
            $this->filesPaths = require_once __DIR__.'/config/FilesPaths.php';

            $otherParams = require_once __DIR__.'/config/otherParams.php';

            $_SESSION['guestbook_recordsPerPage'] = $otherParams['recordsPerPage'];
            
        }
        
        //Вставка ссылок на файлы css стилей гостевой книги
        public function insertCssLinks() {
            
            foreach($this->filesPaths['css'] as $value) {
                $cssLinks .= '<link rel="stylesheet" href="'.$value.'">';
            }
            
            return $cssLinks;
        }    
        
        //Вставка ссылок на файлы js гостевой книги
        public function insertJsLinks() {
            
            foreach($this->filesPaths['js'] as $value) {
                $jsLinks .= '<script src="'.$value.'"></script>';
            }
            
            return $jsLinks;
        }
        
        //Вывод гостевой книги
        public function showGuestBook() {
            
            //Получение параметра get 'page' для пагинации. Текущая страница
            $_SESSION['guestbook_currentPage'] = ( (int) $_GET['page'] > 0 ) ? $_GET['page'] : 1;
            
            if(isset($_SESSION['guestbook_userName']) && isset($_SESSION['guestbook_userEmail']) && isset($_SESSION['guestbook_adminName'])) {

                $_SESSION['guestbook_isAdmin'] = ($_SESSION['guestbook_userName'] == $_SESSION['guestbook_adminName']) ? true : false;
                
                if($_SESSION['guestbook_isAdmin']) {
                    
                    require_once __DIR__.'/layouts/AdminUserCabinet/AdminCabinet.php';
                    
                } else {
                
                    require_once __DIR__.'/layouts/AdminUserCabinet/UserCabinet.php';
                    
                }
                
                return false;
            
            }
            
            require_once __DIR__.'/layouts/NewMessageForm/NewMessageForm.php';
            require_once __DIR__.'/layouts/ShowMessages/ShowMessages.php';
        
        }
        
    }
?>