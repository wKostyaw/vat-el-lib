<?php
	session_start();
	if(!$_SESSION['login']) {
		header("Location: Login.php");
		exit();
	}
?>