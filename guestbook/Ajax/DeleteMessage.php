<?php
    namespace guestbook;

    if(isset($_POST) && isset($_POST['message_id'])) {

        require_once __DIR__.'/../DataBase/DBConnect.php';

        $respond['isSuccess'] = DBObject::execQuery("DELETE FROM messages WHERE message_id = ".$_POST['message_id']);

        echo json_encode($respond);
    
    } else {

        $respond['isSuccess'] = false;

        echo json_encode($respond);

    }