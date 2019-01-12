<?php 
	require 'db.php';

	$data = $_POST;
	if ( isset($data['do_login']) )
	{
		
        $isUserAuthorized = false;
        
        $user = R::findOne('users', 'login = ?', array($data['login']));
		if ( $user )
		{
			//логин существует
			if ( password_verify($data['password'], $user->password) )
			{
				//если пароль совпадает, то нужно авторизовать пользователя
                $_SESSION['logged_user'] = $user;

                //Переменные, необходимые для работы гостевой книги
                $_SESSION['guestbook_userName'] = $user->login;
                $_SESSION['guestbook_userEmail'] = $user->email;
                $_SESSION['guestbook_adminName'] = "admin";

                $isUserAuthorized = true;
				//echo '<div style="color:dreen;">Вы авторизованы!<br/> Можете перейти на <a href="/">главную</a> страницу.</div><hr>';
			}else
			{
				$errors['wrong_password'] = 'Неверно введен пароль!';
			}

		}else
		{
			$errors['wrong_login'] = 'Пользователь с таким логином не найден!';
		}
		
		if ( ! empty($errors) )
		{
			//выводим ошибки авторизации
			//echo '<div id="errors" style="color:red;">' .array_shift($errors). '</div><hr>';
		}

	}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/../css/style.css">
	<title>Гостевая книга</title>
</head>
<body>
    <main class="content">
        <header class="header">
            <a class='logo' href="/"><img src="/images/logo.png" alt=""></a>
            <nav>
                <ul class="main-menu">
                    <li class="main-menu__item"><a href="/">Главная</a></li>
                </ul>
            </nav>
        </header>
        <section class="wrapper">
			<form class="reg-form" action="login.php" method="POST">
                <h1>Войти на сайт</h1>
                <div class="input-wrapper">
                    <strong>Логин</strong>
				    <input type="text" name="login" value="<?php echo @$data['login']; ?>"><br/>
                    <?php
                        if(isset($errors['wrong_login'])) echo "<span class='warning'>".$errors['wrong_login']."</span>";
                    ?>
                </div>
                    
                <div class="input-wrapper">
                    <strong>Пароль</strong>
				    <input type="password" name="password" value="<?php echo @$data['password']; ?>"><br/>
                    <?php
                        if(isset($errors['wrong_password'])) echo "<span class='warning'>".$errors['wrong_password']."</span>";
                    ?>
                </div>

				<button type="submit" name="do_login">Войти</button>
			</form>
            <div class="reg-link">
                <br><span>или</span><br>
                <a href="signup.php">Зарегистрироваться</a>   
            </div>
        </section>
        <footer class="footer">
            <p>Copyright © 2018</p>
        </footer>
    </main>
    <?php
        if($isUserAuthorized) echo "<script> window.location.replace('/'); </script>";
    ?>    
</body>
</html>


