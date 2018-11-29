<?php
    namespace guestbook;

    if(isset($_POST) && isset($_POST['message_id'])) {

        require_once __DIR__.'/../DataBase/DBConnect.php';

        $messageId = $_POST['message_id'];

        $respond['data'] = DBObject::getMessageById($messageId);

        $respond['is_error'] = false;

        echo json_encode($respond);
    
    } else {

        $respond['is_error'] = true;

        echo json_encode($respond);

    }