<?php
    namespace guestbook;

    if(isset($_POST) && isset($_POST['message_id'])) {

        require_once __DIR__.'/../DataBase/DBConnect.php';

        $messageId = $_POST['message_id'];

        $message = DBObject::getMessageById($messageId);

        if($message['execSuccess'] && $message['data']) {

            ob_start();
            $message = $message['data'][0];
            require_once __DIR__.'/../layouts/EditMessageForm/EditMessageForm.php';
            $output = ob_get_contents(); 
            ob_end_clean();
            
            $respond['isSuccess'] = true;
            $respond['data'] = $output;

        } else {

            $respond['isSuccess'] = false;

        }

        echo json_encode($respond);
    
    } else {

        $respond['isSuccess'] = false;

        echo json_encode($respond);

    }