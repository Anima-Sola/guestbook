<?php
    namespace guestbook;

    session_start();

    $isAdmin = ($_SESSION['guestbook_isAdmin']);
    $isMessageModerated = ($message['message_is_moderated'] == "1") ? true : false;
    $adminReply = $message['message_adminreply'];

?>

<div id="guestbook-edit-message-input-form" class="edit-message__input-form">

    <?php
        $title = ($isAdmin) ? "Редактирование/модерация сообщения" : "Редактирование сообщения";
    ?>
    
    <div class="edit-message__title"><p><?= $title ?></p></div>

    <div class="edit-message__info-block">
        <div class="edit-message__info-field"><p>Имя пользователя: <span><?= $message['message_username'] ?></span></p></div>
        <div class="edit-message__info-field"><p>Email пользователя: <span><?= $message['message_useremail'] ?></span></p></div>
        <div class="edit-message__info-field"><p>Дата сообщения: <span><?= date("d.m.Y H:i", $message['message_date']) ?></span></p></div>
        <div class="edit-message__info-field"><p>Сайт пользователя: <span><?= $message['message_userurl'] ?></span></p></div>
        <div class="edit-message__info-field"><p>IP адрес пользователя: <span><?= $message['message_userIP'] ?></span></p></div>
        <div class="edit-message__info-field"><p>Браузер пользователя: <span><?= $message['message_user_browser'] ?></span></p></div>
        <?php
            $messageModeratedText = ($isMessageModerated) ? "Сообщение модерировано и опубликовано" : "Сообщение не модерировано или скрыто"; 
        ?>
        <div class="edit-message__info-field"><p><span><?= $messageModeratedText ?></span></p></div>
    </div>
    
    <div class="edit-message__textarea-block">
        <div class="edit-message__info-field"><p>Сообщение пользователя:</p></div>
        <textarea class="edit-message__textarea" dataForSending="true" name="message_messagetext"><?= $message['message_messagetext'] ?></textarea>
    </div>
    <div class="edit-message__textarea-block">
        <div class="edit-message__info-field"><p>Ответ администратора:</p></div>
        <?php
            if($isAdmin) {

                echo "<textarea class='edit-message__textarea' dataForSending='true' name='message_adminreply'>$adminReply</textarea>";

            } else {

                echo "<br><textarea class='edit-message__textarea' disabled>$adminReply</textarea>";

            }
        ?>
    </div>

    <div class="edit-message__buttons-block">
        <?php
            $messageId = $message['message_id'];
            
            if($isAdmin) {
                
                if($isMessageModerated) {

                    echo "<span class='edit-message__info-field' onclick=\"return guestbook.editMessage($messageId, 'hide');\"><p>Скрыть</p></span>";
                
                } else {

                    echo "<span class='edit-message__info-field' onclick=\"return guestbook.editMessage($messageId, 'public');\"><p>Опубликовать</p></span>";
                
                }

                echo "<span class='edit-message__info-field' onclick=\"return guestbook.editMessage($messageId, 'save');\"><p>Сохранить</p></span>";
                               
            } else {
                
                echo "<span class='edit-message__info-field' onclick=\"return guestbook.editMessage($messageId, 'send');\"><p>Отправить</p></span>";
                
            }

        ?>
        <span class="edit-message__info-field" onclick="return guestbook.editMessage(<?= $messageId ?>, 'delete');"><p>Удалить</p></span>
        <span class="edit-message__info-field" onclick="return modalWindow.closeModalWindow();"><p>Закрыть окно</p></span>
    </div>

</div>
