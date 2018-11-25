<?php

namespace Captcha;

session_start();

require_once __DIR__.'\PhraseBuilderInterface.php';
require_once __DIR__.'\CaptchaBuilderInterface.php';
require_once __DIR__.'\ImageFileHandler.php';
require_once __DIR__.'\PhraseBuilder.php';
require_once __DIR__.'\CaptchaBuilder.php';

use Captcha\CaptchaBuilder;

$builder = new CaptchaBuilder;
$builder->build();
echo '<img src="'.$builder->inline().'" alt="">';
$_SESSION['guestbook-captchaPhrase'] = $builder->getPhrase();