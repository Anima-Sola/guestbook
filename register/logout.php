<?php 
	require 'db.php';
	unset($_SESSION['logged_user']);
	unset($_SESSION['guestbook_userName']);
	unset($_SESSION['guestbook_userEmail']);
	unset($_SESSION['guestbook_adminName']);
	header('Location: /');
?>
