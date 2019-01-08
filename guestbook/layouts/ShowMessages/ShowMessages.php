<?php
    namespace guestbook;

    $messages = require __DIR__.'/getMessages.php';
?>
<? foreach($messages as $message) { ?>
    <div class="message">
        <div class="message__wrapper">
            <div class="message__header">
                <div class="user-name">
                    <p><?= $message['message_username'] ?></p>
                </div>
                <div class="message-date">
                    <p><?= date("d.m.Y H:i", $message['message_date']) ?></p>
                </div>
                <div class="user-url">
                    <p><?= $message['message_userurl'] ?></p>
                </div>

                <?php
                    if($isMessageEditable) {

                        $messageId = $message['message_id'];
                        $editButtonValue = ($showOnlyNotModeratedMessages) ? "Модерация сообщения" : "Редактирование сообщения";

                        echo "<input class='message-edit-button' type='button' value='$editButtonValue' onclick='return guestbook.showEditingMessage($messageId)'>";

                    }
                ?>

            </div>
            <div class="message__body">
                <div class="user-message-title">
                    <p>Сообщение посетителя:</p>
                </div>
                <div class="message-text">
                    <p><?= str_replace(array("\r\n", "\r", "\n"), '<br>', $message['message_messagetext']); ?></p>
                </div>
                <?php
                    if(isset($message['message_adminreply']) && $message['message_adminreply']) {
                        echo "<p class='admin-reply-title'>Ответ администратора:</p>";
                        echo "<div><p>";
                            echo str_replace(array("\r\n", "\r", "\n"), '<br>', $message['message_adminreply']);
                        echo "</p></div>";
                    }

                    if($isMessageEditable) {

                        echo "<div class='message__userdata'>";
        
                            echo "<p class='user-data-title'>Данные посетителя:</p>";
        
                            echo "<div class='user-email'>";
                                echo "<p>";
                                    echo "Email: ".$message['message_useremail'];
                                echo "</p>";
                            echo "</div>";
        
                            echo "<div class='user-userIP'>";
                                echo "<p>";
                                    echo "IP:".$message['message_userIP'];
                                echo "</p>";
                            echo "</div>";
        
                            echo "<div class='user-userbrowser'>";
                                echo "<p>";
                                    echo "Браузер: ".$message['message_user_browser'];
                                echo "</p>";
                            echo "</div>";
        
                            echo "<div class='user-ismessagemoderated'>";
                                echo "<p>";
                                    echo ( $message['message_is_moderated'] == "1") ? "Сообщение модерировано и опубликовано" : "Сообщение не модерировано или скрыто"; 
                                echo "</p>";
                            echo "</div>";
        
                        echo "</div>";
                    }
                ?>
            </div>
        </div>
    </div>

<? 
}
require_once __DIR__.'/../../modules/Pagination/Pagination.php';
new Pagination($_SESSION['guestbook_numOfRecords'], $_SESSION['guestbook_currentPage'], $_SESSION['guestbook_recordsPerPage']);
?>
