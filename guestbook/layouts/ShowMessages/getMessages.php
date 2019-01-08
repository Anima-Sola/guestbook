<?php
    namespace guestbook;
    
    require_once __DIR__.'/../../DataBase/DBConnect.php';
    require_once __DIR__.'/../../DataBase/DBObject.php';

    $recordsPerPage = $_SESSION['guestbook_recordsPerPage'];
    $currentPage = $_SESSION['guestbook_currentPage'];
    $isMessageEditable = true;

    if($showOnlyNotModeratedMessages) {
        
        $result = DBObject::execQuery("SELECT * FROM messages WHERE message_is_moderated = false ORDER BY message_date DESC LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage")['data'];
        
        $_SESSION['guestbook_numOfRecords'] = (int) DBObject::execQuery("SELECT COUNT(*) FROM messages WHERE message_is_moderated = false;")['data'][0]["COUNT(*)"];

        if(!$result) echo "Нет новых сообщений на модерацию.";

        return $result;

    }

    if($showOnlyCurrentUserMessages)  {

        $userName = $_SESSION['guestbook_userName'];

        $result = DBObject::execQuery("SELECT * FROM messages WHERE BINARY message_username = '$userName' ORDER BY message_date DESC LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage")['data'];

        $_SESSION['guestbook_numOfRecords'] = (int) DBObject::execQuery("SELECT COUNT(*) FROM messages WHERE BINARY message_username = '$userName';")['data'][0]["COUNT(*)"];

        if(!$result) echo "Вы не оставляли сообщения.";

        return $result;         

    }    
    
    if($showAllMessages) {

        $result = DBObject::execQuery("SELECT * FROM messages WHERE 1 ORDER BY message_date DESC LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage")['data'];

        $_SESSION['guestbook_numOfRecords'] = (int) DBObject::execQuery("SELECT COUNT(*) FROM messages WHERE 1;")['data'][0]["COUNT(*)"];

        if(!$result) echo "В гостевой книге сообщений нет.";

        return $result;

    }
     
    $isMessageEditable = false;

    $result = DBObject::execQuery("SELECT * FROM messages WHERE message_is_moderated = true ORDER BY message_date DESC LIMIT ".($currentPage - 1) * $recordsPerPage.", $recordsPerPage")['data'];

    $_SESSION['guestbook_numOfRecords'] = (int) DBObject::execQuery("SELECT COUNT(*) FROM messages WHERE message_is_moderated = true;")['data'][0]["COUNT(*)"];

    if(!$result) echo "В гостевой книге сообщений нет.";

    return $result;