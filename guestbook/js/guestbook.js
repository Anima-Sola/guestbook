document.addEventListener("DOMContentLoaded", function() {

    guestbook = {};
    
    function getCaptcha() {
        $('#captcha').load('/guestbook/modules/Captcha/BuildCaptcha.php');
    }

    function showWarning(name) {
        
        var newMessageInputForm = document.getElementById('new-message-input-form');
        var input = newMessageInputForm.querySelector('[name="' + name + '"]');
        
        if(input) {
            
            input.classList.add('warning-border');
            input.nextElementSibling.classList.remove('hidden-warning');
            input.focus();
            
        } 
        
    }
    
    function hideWarning(name) {
        
        var newMessageInputForm = document.getElementById('new-message-input-form');
        var input = newMessageInputForm.querySelector('[name="' + name + '"]');
        
        if(input) {
        
            input.classList.remove('warning-border');
            input.nextElementSibling.classList.add('hidden-warning');
            
        }
        
    }
    
    function showWrongInputFields(data) {
        
        (data['guestbook-captcha']) ? hideWarning('guestbook-captcha') : showWarning('guestbook-captcha');
        (data['guestbook-message']) ? hideWarning('guestbook-message') : showWarning('guestbook-message');
        (data['guestbook-url']) ? hideWarning('guestbook-url') : showWarning('guestbook-url');
        (data['guestbook-email']) ? hideWarning('guestbook-email') : showWarning('guestbook-email');
        (data['guestbook-username']) ? hideWarning('guestbook-username') : showWarning('guestbook-username');
        
    }
    
    function clearInputValues(inputs){
        
        /*for(let i = 0; i < inputs.length; i++ ) {
            inputs[i].classList.remove('warning-border');
            inputs[i].nextElementSibling.classList.add('hidden-warning');
            inputs[i].value = "";
        }
        
        getCaptcha();*/
        
        //location.reload();
        
        setInterval("location.reload();",3000);
    
    }
    
    function sendNewMessage() {
        var newMessageInputForm = document.getElementById('new-message-input-form');
        var inputs = newMessageInputForm.querySelectorAll('[dataForSend="true"]');
        var dataForSend = {};
        
        for(let i = 0; i < inputs.length; i++) {
            dataForSend[ inputs[i].name ] = inputs[i].value;
        }

        result = $.ajax({
                    type: 'POST',
                    url: '/guestbook/Ajax/AddNewMessage.php', 
                    dataType: 'text',
                    data: dataForSend,
                    success: function(msg){
                        result = JSON.parse(msg);

                        if(result.validationSuccess) {

                            if(result.isMessageAdded) {
                                clearInputValues(inputs);
                                modalWindow.showModalWindow('500', '200', 'px', "Сообщение успешно добавлено на модерацию.");
                            } else {
                                modalWindow.showModalWindow('500', '200', 'px', "Добавить сообщение не удалось. Нет связи с базой данных.");
                            }

                        } else {
                            showWrongInputFields(result);
                        }
                    }, 
                    error: function(){
                        modalWindow.showModalWindow('500', '200', 'px', "Не удалось передать данные. Нет связи с сервером.");
                    }        
        });

    }

    function editMessage(messageId, isAdmin) {

    

        console.log(messageId, ' ', isAdmin);
    }

    getCaptcha();
    
    window.guestbook.editMessage = editMessage;
    window.guestbook.sendNewMessage = sendNewMessage;
    window.guestbook.getCaptcha = getCaptcha;

});