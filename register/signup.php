<?php 
	require 'db.php';

	$data = $_POST;

	function captcha_show(){
		$questions = array(
			1 => 'Столица России',
			2 => 'Столица США',
			3 => '2 + 3',
			4 => '15 + 14',
			5 => '45 - 10',
			6 => '33 - 3'
		);
		$num = mt_rand( 1, count($questions) );
		$_SESSION['captcha'] = $num;
		echo $questions[$num];
	}

	//если кликнули на button
	if ( isset($data['do_signup']) )
	{
    // проверка формы на пустоту полей
		$errors = array();
		if ( trim($data['login']) == '' )
		{
			$errors['login'] = 'Введите логин';
		}

		if ( trim($data['email']) == '' )
		{
			$errors['email'] = 'Введите Email';
		}

		if ( $data['password'] == '' )
		{
			$errors['password'] = 'Введите пароль';
		}

		if ( $data['password_2'] != $data['password'] )
		{
			$errors['password_2'] = 'Повторный пароль введен не верно!';
		}
        
		//проверка капчи
		$answers = array(
			1 => 'москва',
			2 => 'вашингтон',
			3 => '5',
			4 => '29',
			5 => '35',
			6 => '30'
		);
		if ( $_SESSION['captcha'] != array_search( mb_strtolower($_POST['captcha']), $answers ) )
		{
			$errors['captcha'] = 'Ответ на вопрос указан не верно!';
			//var_dump($answers);
		}

        $isRegisterSuccess = false;
        
		if ( empty($errors) ) {
			
            $isLoginExists = false;
            
            //проверка на существование одинакового логина
            if ( R::count('users', "login = ?", array($data['login'])) > 0)
            {
                //$errors['login_exists'] = 'Пользователь с таким логином уже существует!';
                $isLoginExists = true;
            }

            $isEmailExists = false;

            //проверка на существование одинакового email
            if ( R::count('users', "email = ?", array($data['email'])) > 0)
            {
                //$errors['email_exists'] = 'Пользователь с таким Email уже существует!';
                $isEmailExists = true;
		    }

            if(!$isLoginExists && !$isEmailExists) {    
        
                //ошибок нет, теперь регистрируем
                $user = R::dispense('users');
                $user->login = $data['login'];
                $user->email = $data['email'];
                $user->password = password_hash($data['password'], PASSWORD_DEFAULT); //пароль нельзя хранить в открытом виде, мы его шифруем при помощи функции password_hash для php > 5.6
				R::store($user);
				$_SESSION['logged_user'] = $user;
				$_SESSION['guestbook_userName'] = $user->login;
				$_SESSION['guestbook_userEmail'] = $user->email;
				if($user->login == "admin") $_SESSION['guestbook_adminName'] = $user->login;
                //echo '<div style="color:dreen;">Вы успешно зарегистрированы!</div><hr>';

                $isRegisterSuccess = true;
            
            }
                        
		}else
		{
			//var_dump($errors);
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
    <script src="/js/ModalWindow.js"></script>
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
			<form class="reg-form" action="/register/signup.php" method="POST">
				<h1>Регистрация нового пользователя</h1>
				<div class="input-wrapper">
					<strong>Ваш логин*</strong>
					<input type="text" name="login" value="<?php echo @$data['login']; ?>"><br/>
                    <?php
                        if(isset($errors['login'])) echo "<span class='warning'>".$errors['login']."</span>";
                    ?>
				</div>
				
				<div class="input-wrapper">
					<strong>Ваш Email*</strong>
					<input type="email" name="email" value="<?php echo @$data['email']; ?>"><br/>
                    <?php
                        if(isset($errors['email'])) echo "<span class='warning'>".$errors['email']."</span>";
                    ?>
				</div>	

				<div class="input-wrapper">
					<strong>Ваш пароль*</strong>
					<input type="password" name="password" value="<?php echo @$data['password']; ?>"><br/>
                    <?php
                        if(isset($errors['password'])) echo "<span class='warning'>".$errors['password']."</span>";
                    ?>
				</div>

				<div class="input-wrapper">
					<strong>Повторите пароль*</strong>
					<input type="password" name="password_2" value="<?php echo @$data['password_2']; ?>"><br/>
                    <?php
                        if(isset($errors['password_2'])) echo "<span class='warning'>".$errors['password_2']."</span>";
                    ?>
				</div>

				<div class="input-wrapper">
					<strong><?php captcha_show(); ?>*</strong>
					<input type="text" name="captcha" ><br/>
                    <?php
                        if(isset($errors['captcha'])) echo "<span class='warning'>".$errors['captcha']."</span>";
                    ?>
				</div>

				<button type="submit" name="do_signup">Регистрация</button>
			</form>
        </section>
        <footer class="footer">
            <p>Copyright © 2018</p>
        </footer>
    </main>
    
<?php
    if($isLoginExists && !$isEmailExists) echo "<script> modalWindow.showModalWindow('500', '200', 'px', '<div style='text-align: center; line-height: 190px;'>Пользователь с таким Логином уже существует!</div>'); </script>";
    if($isEmailExists && !$isLoginExists) echo "<script> modalWindow.showModalWindow('500', '200', 'px', '<div style='text-align: center; line-height: 190px;'>Пользователь с таким Email уже существует!</div>'); </script>";
    if($isEmailExists && $isLoginExists) echo "<script> modalWindow.showModalWindow('500', '200', 'px', '<div style='text-align: center; line-height: 190px;'>Пользователь с таким Логином и Email уже существует!</div>'); </script>";
    if($isRegisterSuccess) {
		//echo "<script> modalWindow.showModalWindow('500', '200', 'px', 'Вы успешно зарегистрированы!'); </script>";
		echo "<script> window.location.replace('/'); </script>";
	}
?>
    
</body>
</html>