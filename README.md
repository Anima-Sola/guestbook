Установка гостевой книги:
1. Папка guestbook со всем содержимым копируется в папку сайта. Например "\guestbook\".
2. Подключение в index.php происходит таким образом. Пример:

<?php
    session_start();
    require_once __DIR__."\guestbook\guestbook.php"; //Путь к гостевой книге
    use guestbook\GuestBook;
    $guestBook = new GuestBook();
?>
```
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Гостевая книга</title>

    <!-- Здесь подключаются скрипты и стили гостевой книги -->
    <?= $guestBook->insertCssLinks(); ?>
    <?= $guestBook->insertJsLinks(); ?>   
</head>
<body>
    <main class="content">
        <header>
        </header>
        <section class="wrapper">
          
            <!-- Вывод гостевой книги -->
            <div class="guestbook">
                <?php 
                    $guestBook->showGuestBook(); 
                ?>
            <div>
              
        </section>
        <footer>
        </footer>
    </main>
</body>
</html>
```

3. Для работы гостевой книги необходимы три переменные сохраненные в сессии при авторизации пользователя:
$_SESSION['guestbook_userName'], 
$_SESSION['guestbook_userEmail'], 
$_SESSION['guestbook_adminName']

4. Гостевая книга имеет три интерфейсных состояния:
  - Если пользователь не авторизован, то выводится форма добавления нового сообщения и список сообщений.
  - Если пользователь авторизован, и это не администратор, т.е. $_SESSION['guestbook_userName'] != $_SESSION['guestbook_adminName'], то выводится состояние состоящее из двух вкладок, в первой - то же, что в предыдущем абзаце, вторая - сообщения пользователя с именем $_SESSION['guestbook_userName'] с возможностью редактирования текста сообщения с последующей модерацией.
  - Если пользователь авторизован, и это адмистратор, т.е. $_SESSION['guestbook_userName'] == $_SESSION['guestbook_adminName'], то выводится состояние состоящее из двух вкладок, первая - новые не модерированные сообщения от всех пользователей, вторая - все сообщения от всех пользователей, с возможностью редактирования.
  
5. Отдельный личный кабинет в администраторской части сайта не требуется, все реализуется на странице гостевой книги.
