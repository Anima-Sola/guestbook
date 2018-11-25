<?php
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
        
        $result['guestbook-username'] = validateUserName($data['guestbook-username']);
        $result['guestbook-email'] = validateEmail($data['guestbook-email']);
        $result['guestbook-url'] = validateUrl($data['guestbook-url']);
        $result['guestbook-message'] = validateMessage($data['guestbook-message']);
        $result['guestbook-captcha'] = isCaptchaCorrect($data['guestbook-captcha']);
        $result['validationSuccess'] = true;

        foreach($result as $value) {
            if($value) continue;
            $result['validationSuccess'] = false;
        }

        return $result;
    }
?>