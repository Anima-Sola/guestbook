;(function() {

    guestbook = {};
    
    function getCaptcha() {
        $('#captcha').load('/guestbook/modules/Captcha/BuildCaptcha.php');
    }

    function showWarning(name) {
        
        var newMessageInputForm = document.getElementById('guestbook-new-message-input-form');
        var input = newMessageInputForm.querySelector('[name="' + name + '"]');
        
        if(input) {
            
            input.classList.add('warning-border');
            input.nextElementSibling.classList.remove('hidden-warning');
            input.focus();
            
        } 
        
    }
    
    function hideWarning(name) {
        
        var newMessageInputForm = document.getElementById('guestbook-new-message-input-form');
        var input = newMessageInputForm.querySelector('[name="' + name + '"]');
        
        if(input) {
        
            input.classList.remove('warning-border');
            input.nextElementSibling.classList.add('hidden-warning');
            
        }
        
    }
    
    function showWrongInputFields(data) {
        
        (data['message_captcha']) ? hideWarning('message_captcha') : showWarning('message_captcha');
        (data['message_messagetext']) ? hideWarning('message_messagetext') : showWarning('message_messagetext');
        (data['message_userurl']) ? hideWarning('message_userurl') : showWarning('message_userurl');
        (data['message_useremail']) ? hideWarning('message_useremail') : showWarning('message_useremail');
        (data['message_username']) ? hideWarning('message_username') : showWarning('message_username');
        
    }
    
    function clearInputValues(){
        
        /*for(let i = 0; i < inputs.length; i++ ) {
            inputs[i].classList.remove('warning-border');
            inputs[i].nextElementSibling.classList.add('hidden-warning');
            inputs[i].value = "";
        }
        
        getCaptcha();*/
        
        //location.reload();
        
        setInterval("location.reload();",3000);
    
    }

    function getDataForSending(parentId) {
        var messageInputForm = document.getElementById(parentId);
        var inputs = messageInputForm.querySelectorAll('[dataForSending="true"]');
        var dataForSending = {};
        
        for(let i = 0; i < inputs.length; i++) {
            dataForSending[ inputs[i].name ] = inputs[i].value;
        }

        return dataForSending;
    }
    
    function saveNewMessage(dataForSending) {

        $.post( '/guestbook/Ajax/SaveNewMessage.php',
                dataForSending,
                function() {},
                'json')
         .done(function (data) {

            if(data.isSuccess) {
                clearInputValues();
                modalWindow.showModalWindow('500', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Сообщение успешно добавлено на модерацию.</div>");
            } else {
                modalWindow.showModalWindow('500', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Добавить сообщение не удалось. Нет связи с базой данных.</div>");
            }

         })
         .fail(function(){
                
            modalWindow.showModalWindow('500', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось передать данные. Нет связи с сервером.</div>");

         });

    }
    
    //Запрос на правильность заполнения полей
    function validateData() {

        var dataForSending = getDataForSending('guestbook-new-message-input-form');

        $.post( '/guestbook/Ajax/ValidateData.php',
                dataForSending,
                function() {},
                'json')
         .done(function(data){

            if(data.isValidationSuccess) {
                saveNewMessage(dataForSending);
            } else {
                showWrongInputFields(data.data);
            }

         })
         .fail(function(){
                
            modalWindow.showModalWindow('500', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось передать данные. Нет связи с сервером.</div>");

         });

    }
    
    function showEditMessageForm(messageId) {

        var dataForSending = {};
        dataForSending['message_id'] = messageId;

        $.post( '/guestbook/Ajax/GetHtmlMessageById.php',
                dataForSending,
                function() {},
                'json')
         .done(function(data){

            if(data.isSuccess) {
                modalWindow.showModalWindow('50', '80', '%', data['data']);
            } else {
                modalWindow.showModalWindow('500', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось получить данные от сервера.</div>");
            }

         })
         .fail(function(){
                
            modalWindow.showModalWindow('500', '200', 'px', "<div style='text-align: center; line-height: 190px;'>Не удалось передать данные. Нет связи с сервером.</div>");

         });
         
    }

    function editMessage(messageId, operationType) {
        var dataForSending = getDataForSending('guestbook-edit-message-input-form');
        dataForSending['message_id'] = messageId;

        switch(operationType) {
            case 'public': 
                break;
            case 'hide':
                break;
            case 'save':
                break;
            case 'delete':
        }

        console.log(dataForSending);
    }
    
    guestbook.getCaptcha = getCaptcha;
    guestbook.validateData = validateData;
    guestbook.showEditMessageForm = showEditMessageForm;
    guestbook.editMessage = editMessage;
    
    window.guestbook = guestbook;

})();


document.addEventListener("DOMContentLoaded", function() {
    guestbook.getCaptcha();
});