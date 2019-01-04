<?php
    namespace guestbook;

    if(isset($_POST) && isset($_POST['message_id'])) {

        require_once __DIR__.'/../DataBase/DBConnect.php';

        $message = DBObject::getMessageById($_POST['message_id']);

        if($message['execSuccess'] && $message['data']) {

            $respond['isSuccess'] = true;
            $respond['data'] = $message['data'];

        } else {

            $respond['isSuccess'] = false;

        }

        echo json_encode($respond);
    
    } else {

        $respond['isSuccess'] = false;

        echo json_encode($respond);

    }