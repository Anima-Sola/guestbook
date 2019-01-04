<?php
    namespace guestbook;

    if(isset($_POST) && isset($_POST['message_id'])) {

        require_once __DIR__.'/../DataBase/DBConnect.php';

        $params = [];

        foreach($_POST as $key => $value) {
            $params[$key] = $value;
        }

        $respond['isSuccess'] = DBObject::saveMessage($params);

        echo json_encode($respond);
    
    } else {

        $respond['isSuccess'] = false;

        echo json_encode($respond);

    }