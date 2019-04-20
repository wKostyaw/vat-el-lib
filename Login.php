
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
			<form class="LoginForm">
				<label class="LFormHeader">Авторизация</label>
				<label class="LFormLabel">Логин<input type="text" name="login" class="TextField" required></label>
				<label class="LFormLabel">Пароль<input type="password" name="password" class="TextField" required></label>
				<button type="submit"  class="LButton">Войти </button>  
				<br>
				<span>Если вы забыли пароль обратитесь в службу газа</span>
			</form>
	</body>
	<?php 
		session_start();
		$connection = mysqli_connect( 'vat-el-lib', 'root',  '');
		$select_db = mysqli_select_db( $connection, 'vat');
		if (isset($_POST['login']) and isset($_POST['password'])){
			$login = $_POST['login'];
			$password = $_POST['password'];
			$query = "SELECT * FROM loginparol WHERE login='$login' and password='$password'";
			$result = mysqli_querry($connection, $query) or die(mysqli_error($connection));
			$count = mysqli_num_rows($result);

			if ($count == 1) {
				$_SESSION['login'] = $login;
			} else {
				$fmsg = "Ошибка";
			}
		}

		if (isset($_SESSION['login'])) {
			$login = $_SESSION['login'];
			echo "Hello" . $login . "";
			echo "Вы вошли";
			echo "<a href='connection.php'> log in</a>";
		}



	 ?>
