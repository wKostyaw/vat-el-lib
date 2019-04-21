<?php
	session_start();
	if(!$_SESSION['login']) {
		header("Location: Login.php");
		exit();
	}
	if(isset($_GET['exit'])) {
		session_destroy(); 
		header('Location: login.php');
		exit;
	}
?>