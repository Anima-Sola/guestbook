<?php
    //Обновление сообщения в базе по id. Вызывается ajax запросом. Возвращается флаг isSuccess=true и данные в случае успеха.
    namespace guestbook;

    if(isset($_POST) && isset($_POST['message_id'])) {

        require_once __DIR__.'/../DataBase/DBConnect.php';

        $params = [];

        foreach($_POST as $key => $value) {
            $params[$key] = addslashes($value);
        }

        $respond['isSuccess'] = DBObject::saveMessage($params);

        echo json_encode($respond);
    
    } else {

        $respond['isSuccess'] = false;

        echo json_encode($respond);

    }