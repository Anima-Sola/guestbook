<?php
    //Вывод списка сообщений
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
                    
                    //Если зарегистрирован пользователь или администратор, то вывести кнопку для вызова формы редактирования
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

                    //Если на сообщение ответил администратор, то выводим его
                    if(isset($message['message_adminreply']) && $message['message_adminreply']) {

                        echo "<p class='admin-reply-title'>Ответ администратора:</p>
                                <div><p> {${str_replace(array('\r\n', '\r', '\n'), '<br>', $message['message_adminreply'])}} </p>
                              </div>";

                    }

                    //Если зарегистрирован пользователь или администратор, то выводим дополнительно полную информацию о сообщении
                    if($isMessageEditable) {

                        echo "<div class='message__userdata'>
                                <p class='user-data-title'>Данные посетителя:</p>
                                <div class='user-email'><p>Email: {$message['message_useremail']}</p></div>
                                <div class='user-userIP'><p>IP: {$message['message_userIP']}</p></div>
                                <div class='user-userbrowser'><p>Браузер: {$message['message_user_browser']}</p></div>
                                <div class='user-ismessagemoderated'><p>
                                    {${( $message['message_is_moderated'] == "1") ? "Сообщение модерировано и опубликовано" : "Сообщение не модерировано или скрыто"}}
                                </p></div>
                              </div>";

                    }

                ?>
            </div>
        </div>
    </div>

<? 
}
//Вывод пагинации
require_once __DIR__.'/../../modules/Pagination/Pagination.php';
new Pagination($_SESSION['guestbook_numOfRecords'], $_SESSION['guestbook_currentPage'], $_SESSION['guestbook_recordsPerPage']);
?>
