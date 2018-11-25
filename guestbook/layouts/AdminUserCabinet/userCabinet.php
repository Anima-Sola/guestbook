<?php
    namespace guestbook;
?>
<div class="tabs">
    <input id="tab1" type="radio" name="tabs" checked>
    <label for="tab1" title="Вкладка 1">Гостевая книга</label>
 
    <input id="tab2" type="radio" name="tabs">
    <label for="tab2" title="Вкладка 2">Редактировать сообщения</label>
 
    <!--<input id="tab3" type="radio" name="tabs">
    <label for="tab3" title="Вкладка 3">Вкладка 3</label>
 
    <input id="tab4" type="radio" name="tabs">
    <label for="tab4" title="Вкладка 4">Вкладка 4</label>-->
 
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
    <!--<section id="content-tab3">
        <p>
          Здесь размещаете любое содержание....
		</p>
    </section> 
    <section id="content-tab4">
        <p>
          Здесь размещаете любое содержание....
        </p>
    </section>    -->
</div>