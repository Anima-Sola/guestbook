<?php
    namespace guestbook;

    require_once __DIR__.'/dataValidation.php';

    function getUserIP() {
        
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        
        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;
        
        return $ip;
        
    }

    function addMessageToDB($data) {

        require_once __DIR__.'/../DataBase/DBConnect.php';

        $dbObject = new DBObject();
        
        $messageDate = date("H:i d-m-Y");
        $userIp = getUserIp();
        $userBrowser = $_SERVER["HTTP_USER_AGENT"];
        $text = trim(strip_tags($data['guestbook-message'],'<a><code><i><strike><strong>'));

        $params = array("message_username" => trim($data['guestbook-username']),
                        "message_useremail" => trim($data['guestbook-email']),
                        "message_userurl" => trim($data['guestbook-url']),
                        "message_messagetext" => $text,
                        "message_date" => $messageDate,
                        "message_userIP" => $userIp,
                        "message_user_browser" => $userBrowser,
                        "message_is_moderated" => "false"
                       );

        $isSuccess = $dbObject->newMessage = $params;

        return $isSuccess;

    }
    
    if(isset($_POST)) {
                
        $respond = validateData($_POST);

        $respond['isMessageAdded'] = false;

        if($respond['validationSuccess']) $respond['isMessageAdded'] = addMessageToDB($_POST);

        echo json_encode($respond);
    
    }
?>