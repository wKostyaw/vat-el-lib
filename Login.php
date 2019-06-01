<?php
	session_start();
	$connection = mysqli_connect( 'vat', 'root',  '', 'vat');
	// 
	if ($_POST['submit']) 
	{
		if (isset($_POST['login']) and isset($_POST['password']))
		{
			$login = $_POST['login'];
			$password = $_POST['password'];
			$query = "SELECT * FROM loginparol WHERE login='$login' and password='$password'";
			$result = mysqli_query($connection, $query) or die(mysqli_error($connection));
			$count = mysqli_num_rows($result);
			if ($count == 1) 
			{
					$_SESSION['login'] = $login;
			} else 
			{
				echo '<script type="text/javascript">';
				echo 'alert("Неправильный логин или пароль!")';
				echo '</script>';
			}
		} 
		if (isset($_SESSION['login']))
		{
			$isLoginAdmin = $connection->query("SELECT admin FROM loginparol WHERE login='$login'");
			if ($isLoginAdmin == 1) 
			{
				header('Location: AdminPage.php');
				exit();
			}
			else if ($isLoginAdmin == 2) 
			{	
				echo '<script type="text/javascript">';
				echo 'alert("Ваш профиль был заблокирован и Вам отказано в доступе к сайту. Обратитесь к администратору")';
				echo '</script>';
			} 
			else if ($isLoginAdmin == 0) 
			{
				header('Location: MainPage.php');
				exit();
			}
			else
			{
				echo '<script type="text/javascript">';
				echo 'alert("В ходе перехода на сайт библиотеки произошла ошибка")';
				echo '</script>';
			} 
		}
	}
	if (isset($_POST['RequestSummaryInfo'])) {
		$summary = array();
		$sqlBookCount = $connection->query("SELECT COUNT(1) FROM books");
		$sqlAuthorsCount = $connection->query("SELECT COUNT(1) FROM authors");
		$sqlCategoriesCount = $connection->query("SELECT COUNT(1) FROM categories");
		$summary['books'] = mysqli_fetch_assoc($sqlBookCount)['COUNT(1)'];
		$summary['authors'] = mysqli_fetch_assoc($sqlAuthorsCount)['COUNT(1)'];
		$summary['categories'] = mysqli_fetch_assoc($sqlCategoriesCount)['COUNT(1)'];
		$summary = json_encode($summary);
		exit($summary);
	}
?>
<!doctype HTML>
<html>

	<meta charset="utf-8">
	<head>
		<title>Авторизация</title>
		<link rel="stylesheet" type="text/css" href="Css/Login.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script src="Js/Login.js" type="text/javascript"></script>
	</head>
	<body>
		<!--<div class="SiteHeader">
			<img src="Img/WorkInProgress.png" class="Logo">
			<p class="SiteName">Электронная библиотека ВАТ имени В. П. Чкалова</p>
		</div>-->
		<div class="glass">
			<form class="LoginForm" method="POST">
				<button type="button" id="closeLoginForm" class="closeLoginForm">
					<svg x="0px" y="0px" width="24" height="24" viewBox="0 0 192 192">
						<path d="M45.65625,34.34375l-11.3125,11.3125l50.34375,50.34375l-50.34375,50.34375l11.3125,11.3125l50.34375,-50.34375l50.34375,50.34375l11.3125,-11.3125l-50.34375,-50.34375l50.34375,-50.34375l-11.3125,-11.3125l-50.34375,50.34375z"></path>
					</svg>
				</button>
				<label class="LFormHeader">Авторизация</label>
				<label class="LFormLabel">Логин<input type="text" name="login" class="TextField" required></label>
				<label class="LFormLabel">Пароль<input type="password" name="password" class="TextField" required></label>
				<input name="submit" type="submit" class="LButton" value="Войти">
				<br>
				<span>Если вы забыли пароль обратитесь в службу газа</span>
			</form>
		</div>
		<div class="hello">
			<h1 class="helloHeader">ДОБРО ПОЖАЛОВАТЬ В ЭЛЕКТРОННУЮ БИБЛИЕОТЕКУ ВАТ ИМ В. П. ЧКАЛОВА</h1>
			<p class="helloText">
			
			</p>
			<p class="helloText">В нашей библиотеке собраны 
				<span id="BookAmount"></span> умопомрачительных произведений классической литературы от 
				<span id="AuthorAmount"></span> величайших авторов в 
				<span id="CategoryAmount"></span> отборных категориях, после прочтения которых вы поднимите уровень своих знаний до небес. 
				С каждой прочтенной строчкой ваш уровень эрудированности будет расти в геометрической прогрессии.
			</p>
			<p class="helloText">Для того, чтобы ознакомится с представленными на сайте каталогом литературы вам необходимо войти, используя логин и пароль, полученные от вашего [человек выдающий логины и пароли].</p>
			<p class="helloText">Приятного чтения.</p>
		</div>
		<button class="LButton" id="openLoginForm">Войти</button>
	</body>
</html>