<?php
    namespace guestbook;
?>

<div class="edit-message-form">
    <div class="edit-message-form__title"><p>Редактирование/модерация сообщения</p></div>
    <div class="edit-message-form__info-field"><p>Имя пользователя: <span><?= $message['message_username'] ?></span></p></div>
    <div class="edit-message-form__info-field"><p>Email пользователя: <span><?= $message['message_useremail'] ?></span></p></div>
    <div class="edit-message-form__info-field"><p>Дата сообщения: <span><?= $message['message_date'] ?></span></p></div>
    <div class="edit-message-form__info-field"><p>Сайт пользователя: <span><?= $message['message_userurl'] ?></span></p></div>
    <div class="edit-message-form__info-field"><p>IP адрес пользователя: <span><?= $message['message_userIP'] ?></span></p></div>
    <div class="edit-message-form__info-field"><p>Браузер пользователя: <span><?= $message['message_user_browser'] ?></span></p></div><br>
    <div class="edit-message-form__info-field"><p>Сообщение пользователя:</p></div>
    <textarea class="edit-message-form__textarea"><?= $message['message_messagetext'] ?></textarea>
    <div class="edit-message-form__info-field"><p>Ответ администратора:</p></div>
    <textarea class="edit-message-form__textarea"><?= $message['message_adminreply'] ?></textarea>

</div>