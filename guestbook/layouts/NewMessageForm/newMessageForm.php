<!-- Форма добавления нового сообщения в гостевую книгу -->
<div class="guestbook-title">Гостевая книга</div>
<div class="guestbook-new-message">
    <div id="guestbook-new-message-input-form" class='guestbook-new-message__input-form'>
        <div class="form-group">
            <p class="input-title">Ваше имя*:</p>
            <?php
                if(isset($_SESSION['guestbook_userName'])) {
                    echo '<input class="input-field" type="text" dataForSending="true" name="message_username" placeholder="Введите свое имя..." value="'.$_SESSION['guestbook_userName'].'" Disabled>';
                } else {
                    echo '<input class="input-field" type="text" dataForSending="true" name="message_username" placeholder="Введите свое имя..." autofocus>';
                }
            ?>
            <span class="warning-text hidden-warning">Введите Ваше имя</span>
        </div>
        <div class="form-group">
            <p class="input-title">Ваш e-mail*:</p>
            <?php
                if(isset($_SESSION['guestbook_userEmail'])) {
                    echo '<input class="input-field" type="text" dataForSending="true" name="message_useremail" placeholder="Введите cвой e-mail..." value="'.$_SESSION['guestbook_userEmail'].'" Disabled>';
                } else {
                    echo '<input class="input-field" type="text" dataForSending="true" name="message_useremail" placeholder="Введите cвой e-mail...">';
                }
            ?>
            <span class="warning-text hidden-warning">Введите корректный email</span>
        </div>
        <div class="form-group">
            <p class="input-title">Ваш сайт:</p>
            <input class="input-field" type="text" dataForSending="true" name="message_userurl" placeholder="Введите адрес Вашего сайта" autofocus>
            <span class="warning-text hidden-warning">Введите корректный url</span>
        </div>
        <div class="form-group form-group__textarea">
            <p class="input-title form-group__textarea">Сообщение*:</p>
            <textarea class="textarea-field" dataForSending="true" name="message_messagetext" placeholder="Введите текст сообщения (не более 1000 символов)..."></textarea>
            <span class="warning-text hidden-warning">Введите Ваше сообщение</span>
        </div>
        <div class="form-group form-group__captcha">
            <p class="input-title form-group__captcha">Введите символы*:</p>
            <div class="captcha-group">
                <span class="captcha-img" id="captcha"><!-- Здесь будет каптча --></span>
                <span class="refresh-captcha-link" onclick="return guestbook.getCaptcha();" id="refresh-captcha-link">Обновить изображение</span>
            </div>
            <div class="input-field-captcha">
                <input class="captcha-field" type="text" dataForSending="true" name="message_captcha">
                <span class="warning-text warning-text__captcha hidden-warning">Неправильные символы</span>  
            </div>
        </div>
        <div class="form-group">
            <input onclick="return guestbook.validateData();" class="submit-button" type="button" value="ОТПРАВИТЬ">
        </div>
    </div>
</div>
