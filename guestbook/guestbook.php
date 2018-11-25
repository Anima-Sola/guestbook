<?php
    namespace guestbook;

    class GuestBook {
        
        protected $filesPaths;
        
        function __construct() {
            
            $this->filesPaths = require_once __DIR__.'/config/FilesPaths.php';

            $otherParams = require_once __DIR__.'/config/otherParams.php';

            $_SESSION['guestbook-recordsPerPage'] = $otherParams['recordsPerPage'];
            
        }
        
        public function insertCssLinks() {
            
            foreach($this->filesPaths['css'] as $value) {
                $cssLinks .= '<link rel="stylesheet" href="'.$value.'">';
            }
            
            return $cssLinks;
        }    
        
        public function insertJsLinks() {
            
            foreach($this->filesPaths['js'] as $value) {
                $jsLinks .= '<script src="'.$value.'"></script>';
            }
            
            return $jsLinks;
        }
        
        public function showGuestBook() {
            
            $_SESSION['guestbook_userName'] = "admin";
            $_SESSION['guestbook_userEmail'] = "user@user.ru";
            $_SESSION['guestbook_adminName'] = "admin";
            
            /*unset($_SESSION['guestbook_userName']);
            unset($_SESSION['guestbook_userEmail']);
            unset($_SESSION['guestbook_adminName']);
            unset($_SESSION['guestbook_isAdmin']);*/
            
            if(isset($_SESSION['guestbook_userName']) && isset($_SESSION['guestbook_userEmail']) && isset($_SESSION['guestbook_adminName'])) {

                $_SESSION['guestbook_isAdmin'] = ($_SESSION['guestbook_userName'] == $_SESSION['guestbook_adminName']) ? true : false;
                
                if($_SESSION['guestbook_isAdmin']) {
                    
                    require_once __DIR__.'/layouts/AdminUserCabinet/adminCabinet.php';
                    
                } else {
                
                    require_once __DIR__.'/layouts/AdminUserCabinet/userCabinet.php';
                    
                }
                
                return false;
            
            }
            
            require_once __DIR__.'/layouts/NewMessageForm/NewMessageForm.php';
            require_once __DIR__.'/layouts/ShowMessages/ShowMessages.php';
            
        }
        
    }
?>