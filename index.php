<?php
    session_start();

    //Подключаем скрипт гостевой книги
    require_once __DIR__."\guestbook\guestbook.php";

    use guestbook\GuestBook;

    $guestBook = new GuestBook();
    
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta http-equiv="Cache-Control" content="private">
    <link rel="stylesheet" href="/css/style.css">
    <!-- Вставка стилей и скриптов гостевой книги -->
    <?= $guestBook->insertCssLinks(); ?>
    <?= $guestBook->insertJsLinks(); ?>
    
    <title>Гостевая книга</title>
</head>
<body>
    <main class="content">
        <header class="header">
            <a class='logo' href="/"><img src="/images/logo.png" alt=""></a>
            <nav>
                <ul class="main-menu">
                    <?php
                        if(isset($_SESSION['logged_user']))
                            echo "<li class='main-menu__item'><a href='/register/logout.php'>Выход </a></li>";
                        else
                            echo "<li class='main-menu__item'><a href='/register/login.php'>Вход </a>/<a href='/register/signup.php'> Регистрация</a></li>";
                    ?>
                </ul>
            </nav>
        </header>
        <section class="wrapper">
            <div class="guestbook">
                <?php 
                    //Вывод самой гостевой книги
                    $guestBook->showGuestBook(); 
                ?>
            <div>
        </section>
        <footer class="footer">
            <p>Copyright © 2019</p>
        </footer>
    </main>
</body>
</html>