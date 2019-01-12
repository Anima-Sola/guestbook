;(function() {

    guestbook = {};
    
    //Загрузка изображения каптчи
    function getCaptcha() {
        $('#captcha').load('/guestbook/modules/Captcha/BuildCaptcha.php');
    }

    //Функция отображения предупреждения после валидации, что в поле формы ввода нового сообщения
    //введены неправильные данные
    function showWarning(name) {
        
        var newMessageInputForm = document.getElementById('guestbook-new-message-input-form');
        var input = newMessageInputForm.querySelector('[name="' + name + '"]');
        
        if(input) {
            
            input.classList.add('warning-border');
            input.nextElementSibling.classList.remove('hidden-warning');
            input.focus();
            
        } 
        
    }
    
    //Функция скрытия предупреждения после валидации, что в поле формы ввода нового сообщения
    //введены неправильные данные
    function hideWarning(name) {
        
        var newMessageInputForm = document.getElementById('guestbook-new-message-input-form');
        var input = newMessageInputForm.querySelector('[name="' + name + '"]');
        
        if(input) {
        
            input.classList.remove('warning-border');
            input.nextElementSibling.classList.add('hidden-warning');
            
        }
        
    }
    
    //Показать/скрыть предупреждения для каждого поля после валидации
    function showWrongInputFields(data) {
        
        (data['message_captcha']) ? hideWarning('message_captcha') : showWarning('message_captcha');
        (data['message_messagetext']) ? hideWarning('message_messagetext') : showWarning('message_messagetext');
        (data['message_userurl']) ? hideWarning('message_userurl') : showWarning('message_userurl');
        (data['message_useremail']) ? hideWarning('message_useremail') : showWarning('message_useremail');
        (data['message_username']) ? hideWarning('message_username') : showWarning('message_username');
        
    }

    //Получение данных для отправки через ajax-запрос
    //Внутри элементы с id = parendId ищутся элементы в аттрибутом dataForSending = true (input, textarea)
    //И все значения value этим элементов помещаются в массив, который возвращается
    function getDataForSending(parentId) {
        var messageInputForm = document.getElementById(parentId);
        var inputs = messageInputForm.querySelectorAll('[dataForSending="true"]');
        var dataForSending = {};
        
        for(let i = 0; i < inputs.length; i++) {
            dataForSending[ inputs[i].name ] = inputs[i].value;
        }

        return dataForSending;
    }

    //Передать данные post запросом на указанный url
    function makePostRequest(dataForSending, url, callback) {

        $.post( url, dataForSending, function() {}, 'json')
         .done( callback )
         .fail(function(){
            modalWindow.showModalWindow('600', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось передать данные. Нет связи с сервером.</div>");
         });

    }
            
    //Запрос добавления нового сообщения в базу данных
    function saveNewMessage(dataForSending) {

        makePostRequest(dataForSending, '/guestbook/Ajax/SaveNewMessage.php', function (data) {

            if(data.isSuccess) {
                setInterval("location.reload();", 2000);
                modalWindow.showModalWindow('600', '200', 'px', 
                    "<div style='text-align: center; line-height: 190px;'>Сообщение добавлено на модерацию. Страница будет обновлена автоматически.</div>");
            } else {
                modalWindow.showModalWindow('600', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Добавить сообщение не удалось. Нет связи с базой данных.</div>");
            }

        });

    }
    
    //Запрос на правильность заполнения полей
    //Если все правильно, вызывается функция для сохранения нового сообщения
    //Вызывается из файла \layouts\NewMessaggeForm\NewMessageForm.php
    function validateData() {

        var dataForSending = getDataForSending('guestbook-new-message-input-form');

        makePostRequest(dataForSending, '/guestbook/Ajax/ValidateData.php', function(data){

            if(data.isSuccess) {
                saveNewMessage(dataForSending);
            } else {
                showWrongInputFields(data.data);
            }

        });

    }
    
    //Показать форму для редактирования сообщения. Вызывается из файла \layouts\ShowMessages\ShowMessages.php
    //через файл GetHtmlMessageById.php
    function showEditingMessage(messageId) {

        var dataForSending = {};
        dataForSending['message_id'] = messageId;

        makePostRequest(dataForSending, '/guestbook/Ajax/GetHtmlMessageById.php', function(data){

            if(data.isSuccess) {
                modalWindow.showModalWindow('50', '80', '%', data['data']);
            } else {
                modalWindow.showModalWindow('600', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось получить данные от сервера.</div>");
            }

        });

    }
    
    //Обновить сообщение в базе данных
    function updateMessage(dataForSending) {

        makePostRequest(dataForSending, '/guestbook/Ajax/UpdateMessage.php', function(data) {
            
            modalWindow.closeModalWindow();

            if(data.isSuccess) {
                setInterval("location.reload();", 2000);
                modalWindow.showModalWindow('600', '200', 'px', 
                    "<div style='text-align: center; line-height: 190px;'><p>Изменения успешно внесены. Страница будет обновлена автоматически.</p></div>");
            } else {
                modalWindow.showModalWindow('600', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось внести изменения.</div>");
            }

        });

    }

    //Удалить сообщение из базы данных
    function deleteMessage(dataForSending) {

        makePostRequest(dataForSending, '/guestbook/Ajax/DeleteMessage.php', function(data) {

            modalWindow.closeModalWindow();

            if(data.isSuccess) {
                setInterval("location.reload();", 2000);
                modalWindow.showModalWindow('600', '200', 'px', 
                    "<div style='text-align: center; line-height: 190px;'>Сообщение успешно удалено. Страница будет обновлена автоматически.</div>");
            } else {
                modalWindow.showModalWindow('600', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось удалить сообщение.</div>");
            }

        });

    }
    
    //Редактировать сообщение в базе данных. Вызывается из файла \layouts\EditMessageForm\EditMessageForm.php
    function editMessage(messageId, operationType) {
        var dataForSending = getDataForSending('guestbook-edit-message-input-form');
        dataForSending['message_id'] = messageId;

        switch(operationType) {
            case 'public':
                dataForSending['message_is_moderated'] = "1"; 
                updateMessage(dataForSending);
                break;
            case 'send':
            case 'hide':
                dataForSending['message_is_moderated'] = "0";
                updateMessage(dataForSending);
                break;
            case 'save':
                updateMessage(dataForSending);
                break;
            case 'delete':
                isDelete = confirm('Вы действительно хотите удалить сообщение?');
                if(isDelete) deleteMessage(dataForSending);
        }
    }

    //Сохранение текущей вкладки для личных кабинетов авторизованного пользователя и админа
    //Вызывается из файла AdminCabinet.php и UserCabinet.php
    function saveCurrentTab(elem) {

        localStorage.savedTab = elem.htmlFor;
        location.replace('/');

    }

    //Восстановление после закрытия текущей вкладки для личных кабинетов авторизованного пользователя и админа
    //Вызывается из файла AdminCabinet.php и UserCabinet.php
    function restoreCurrentTab() {
        
        savedTab = localStorage.savedTab;

        if(savedTab) {
            savedTabElem = document.getElementById(savedTab);
            if(savedTabElem) savedTabElem.checked = true;
        }

    }
    
    guestbook.getCaptcha = getCaptcha;
    guestbook.validateData = validateData;
    guestbook.showEditingMessage = showEditingMessage;
    guestbook.editMessage = editMessage;
    guestbook.saveCurrentTab = saveCurrentTab;
    guestbook.restoreCurrentTab = restoreCurrentTab;
    
    window.guestbook = guestbook;

})();


document.addEventListener("DOMContentLoaded", function() {
    guestbook.getCaptcha();
    guestbook.restoreCurrentTab();
});