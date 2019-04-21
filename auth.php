<?php
	session_start();
	if(!$_SESSION['login']) {
		header("Location: Login.php");
		exit();
	}
	if () {
		unset($_SESSION['password']);
		unset($_SESSION['login']);
		header("Location: login.php")
	}
?>