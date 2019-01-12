<?php
    //Сохранение нового сообщения в базу. Вызывается ajax запросом. Возвращается флаг isSuccess=true и данные в случае успеха.
    namespace guestbook;

    //Получаем IP-адрес пользователя
    function getUserIP() {
        
        $client  = @$_SERVER['HTTP_CLIENT_IP'];
        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
        $remote  = @$_SERVER['REMOTE_ADDR'];
        
        if(filter_var($client, FILTER_VALIDATE_IP)) $ip = $client;
        elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip = $forward;
        else $ip = $remote;
        
        return $ip;
        
    }

    //Сохраняем сообщение в БД
    function saveMessageToDB($data) {

        require_once __DIR__.'/../DataBase/DBConnect.php';
        
        $messageDate = time();
        $userIp = getUserIp();
        $userBrowser = $_SERVER["HTTP_USER_AGENT"];
        $text = substr( $data['message_messagetext'], 0, 10000).'...';
        $text = trim( strip_tags( $text, '<a><code><i><strike><strong>') );
        $text = addslashes($text);

        $params = array("message_username" => trim($data['message_username']),
                        "message_useremail" => trim($data['message_useremail']),
                        "message_userurl" => trim($data['message_userurl']),
                        "message_messagetext" => $text,
                        "message_date" => $messageDate,
                        "message_userIP" => $userIp,
                        "message_user_browser" => $userBrowser,
                       );

        $isSuccess = DBObject::saveMessage($params);

        return $isSuccess;

    }
    
    if(isset($_POST)) {

        $respond['isSuccess'] = saveMessageToDB($_POST);

        echo json_encode($respond);
    
    } else {
        
        $respond['isSuccess'] = false;

        echo json_encode($respond);

    }
?>