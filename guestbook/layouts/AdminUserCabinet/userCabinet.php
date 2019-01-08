<?php
    namespace guestbook;
?>
<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Вкладка 1" onclick="return guestbook.saveCurrentTab(this);">Гостевая книга</label>
 
    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Вкладка 2" onclick="return guestbook.saveCurrentTab(this);">Редактировать сообщения</label>
 
    <section id="content-tab1">
        <p>
            <?php

                $showOnlyCurrentUserMessages = false;
                
                require_once __DIR__.'/../NewMessageForm/NewMessageForm.php';

                require __DIR__.'/../ShowMessages/ShowMessages.php';

            ?>
        </p>
    </section>  
    <section id="content-tab2">
        <p>
            <?php
            
                $showOnlyCurrentUserMessages = true;

                require __DIR__.'/../ShowMessages/ShowMessages.php';

            ?>
        </p>
    </section> 

</div>