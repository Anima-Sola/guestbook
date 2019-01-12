<?php
    //Скрипт подключения к базе данных
    namespace guestbook;

    require_once __DIR__.'/DBObject.php';

    $DBConnectionParams = require_once __DIR__.'/../config/DBConnectionParams.php';

    DBObject::connectToDB( $DBConnectionParams['DBConnection']['dsn'], 
                           $DBConnectionParams['DBConnection']['username'], 
                           $DBConnectionParams['DBConnection']['password'] );
                               
?>