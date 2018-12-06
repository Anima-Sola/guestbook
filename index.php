<?php
    session_start();

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
    <script src="/js/myscript.js"></script>
    <!--<script src="/js/jquery-3.3.1.min.js"></script>-->
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
            <?php 
                $guestBook->showGuestBook(); 
            ?>
        </section>
        <footer class="footer">
            <p>Copyright © 2018</p>
        </footer>
    </main>
</body>
</html>