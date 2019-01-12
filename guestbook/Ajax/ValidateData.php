<?php
    //Валидацих данные вводимых в форму нового сообщения. Вызывается ajax запросом.
    //Возвращается JSON с флагом isSuccess - true в случае успешной валидации, false - в случае неудачи
    //и массив data с указание какие поля прошли/не прошли валидацию
    namespace guestbook;

    session_start();

    function validateUserName($username) {
        return ($username) ? true : false;
    }
    
    function validateEmail($email) {
        $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);
        return ($isEmailValid) ? true : false;
    }

    function validateUrl($url) {
        /*$isUrlValid = filter_var($data['url'], FILTER_VALIDATE_URL);
        return ($isUrlValid) ? true : false;*/
        return true;
    }

    function validateMessage($message) {
        return ($message) ? true : false;
    }

    function isCaptchaCorrect($captcha) {
        return ($_SESSION['guestbook-captchaPhrase'] == $captcha) ? true : false;
    }
    
    function validateData($data) {
        
        $result = [];
        $result['isSuccess'] = true;
        
        $result['data']['message_username'] = validateUserName($data['message_username']);
        $result['data']['message_useremail'] = validateEmail($data['message_useremail']);
        $result['data']['message_userurl'] = validateUrl($data['message_userurl']);
        $result['data']['message_messagetext'] = validateMessage($data['message_messagetext']);
        $result['data']['message_captcha'] = isCaptchaCorrect($data['message_captcha']);

        foreach($result['data'] as $value) {
            if($value) continue;
            $result['isSuccess'] = false;
        }

        return $result;
    }

    if(isset($_POST)) {

        $respond = validateData($_POST);

        echo json_encode($respond);

    } else {

        $respond['isSuccess'] = false;

        echo json_encode($respond);

    }

?>