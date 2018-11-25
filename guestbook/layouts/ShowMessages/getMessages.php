<?php
    namespace guestbook;
    
    require_once __DIR__.'/../../DataBase/DBConnect.php';
    require_once __DIR__.'/../../DataBase/DBObject.php';

    $recordsPerPage = $_SESSION['guestbook-recordsPerPage'];
    $currentPage = ( (int) $_GET['page'] > 0 ) ? $_GET['page'] : 1;
    $isMessageEditable = true;

    if($showOnlyNotModeratedMessages) {
        
        $result = DBObject::execQuery("SELECT * FROM messages WHERE message_is_moderated = false LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage");

        if(!$result) echo "Нет новых сообщений на модерацию.";

        return $result;

    }

    if($showOnlyCurrentUserMessages)  {

        $userName = $_SESSION['guestbook_userName'];

        $result = DBObject::execQuery("SELECT * FROM messages WHERE message_username = '$userName' LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage");

        if(!$result) echo "Вы не оставляли сообщения.";

        return $result;         

    }    
    
    if($showAllMessages) {

        $result = DBObject::execQuery("SELECT * FROM messages WHERE 1 LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage");

        if(!$result) echo "В гостевой книге сообщений нет.";

        return $result;

    }
     
    $isMessageEditable = false;

    $result = DBObject::execQuery("SELECT * FROM messages WHERE message_is_moderated = true LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage");

    if(!$result) echo "В гостевой книге сообщений нет.";

    return $result;