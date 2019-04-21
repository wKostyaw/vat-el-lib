<?php
	session_start();
	if($_SESSION['login']) {
		header("Location: MainPage.php");
	}
	$connection = mysqli_connect( 'vat', 'root',  '', 'vat');

	if ($_POST['submit']) {
		if (isset($_POST['login']) and isset($_POST['password'])){
		$login = $_POST['login'];
		$password = $_POST['password'];
		$query = "SELECT * FROM loginparol WHERE login='$login' and password='$password'";
		$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
		$count = mysqli_num_rows($result);

			if ($count == 1) {
					$_SESSION['login'] = $login;
			} else {
				echo '<script type="text/javascript">';
				echo 'alert("Неправильный логин или пароль!")';
				echo '</script>';
			}
		}
		if (isset($_SESSION['login'])) {
			$login = $_SESSION['login'];
			header('Location: MainPage.php');
			exit();
		}
	}
?>
<!doctype HTML>
<html>

	<meta charset="utf-8">
	<head>
		<title>Авторизация</title>
		<link rel="stylesheet" type="text/css" href="css/login.css">
	</head>
	<body>
		<div class="SiteHeader">
			<img src="img/WorkInProgress.png" class="Logo">
			<p class="SiteName">Электронная библиотека ВАТ имени В. П. Чкалова</p>
		</div>
			<form class="LoginForm" method="POST">
				<label class="LFormHeader">Авторизация</label>
				<label class="LFormLabel">Логин<input type="text" name="login" class="TextField" required></label>
				<label class="LFormLabel">Пароль<input type="password" name="password" class="TextField" required></label>
				<input name="submit" type="submit" class="LButton" value="Войти">
				<br>
				<span>Если вы забыли пароль обратитесь в службу газа</span>
			</form>
	</body>
</html>