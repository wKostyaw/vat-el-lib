<?php
	session_start();
	$connection = mysqli_connect( 'vat', 'root',  '', 'vat');
	// 
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
		} 
		else 
		{
			echo '<script type="text/javascript">';
			echo 'alert("Неправильный логин или пароль!")';
			echo '</script>';
		}
	} 
	if (isset($_SESSION['login']))
	{	
		
		// проверка статуса пользователя
		$isLoginAdmin = $connection->query("SELECT admin FROM loginparol WHERE login='$login'");
		while ($rowStatus = $isLoginAdmin->fetch_assoc()) {
			$_SESSION['status'] = $rowStatus['admin'];
		}
		if ($_SESSION['status'] == '1') 
		{	
			// подсчёт количества посещений сайта конкретным юзером
			$getVisitsValue = $connection->query("SELECT visits FROM loginparol WHERE login='$login'");
			while ($row = $getVisitsValue->fetch_assoc()) {
				$visitsValue = $row["visits"];
			}
			$visitsValue++;
			$updateVisitsValue = $connection->query("UPDATE loginparol SET visits='$visitsValue' WHERE login='$login'");
			// подсчет количества посещений вообще
			$Today = date("d-m-Y");
			$getDate = $connection->query("SELECT * FROM visit_stats ORDER BY `date` DESC LIMIT 1");
			while ($rowGetDate = $getDate->fetch_assoc()) {
				$DateValue = $rowGetDate['date'];
				$VisitsValue = $rowGetDate['visits'];
			}
			if ($Today == $DateValue) {
				$VisitsValue++;
				$sql = $connection->query("UPDATE visit_stats SET visits = '$VisitsValue'");
			} else if ($Today != $DateValue) {
				$sql = $connection->query("INSERT INTO visit_stats (`date`, visits) VALUES ('$Today', '1')");
			}
			// последняя дата посещения сайта
			$lastVisitDate = date("d-m-Y H:i:s");
			$updateLastVisitsDate = $connection->query("UPDATE loginparol SET last_visit='$lastVisitDate' WHERE login='$login'");
			header('Location: AdminPage.php');
			exit();
		}
		else if ($_SESSION['status'] == '2') 
		{	
			echo '<script type="text/javascript">';
			echo 'alert("Ваш профиль был заблокирован и Вам отказано в доступе к сайту. Обратитесь к администратору")';
			echo '</script>';
			session_destroy(); 
		} 
		else if ($_SESSION['status'] == '0') 
		{
			// подсчёт количества посещений сайта
			$getVisitsValue = $connection->query("SELECT visits FROM loginparol WHERE login='$login'");
			while ($row = $getVisitsValue->fetch_assoc()) {
				$visitsValue = $row["visits"];
			}
			$visitsValue++;
			$updateVisitsValue = $connection->query("UPDATE loginparol SET visits='$visitsValue' WHERE login='$login'");
			// подсчет количества посещений вообще
			$Today = date("d-m-Y");
			$getDate = $connection->query("SELECT * FROM visit_stats ORDER BY `date` DESC LIMIT 1");
			while ($rowGetDate = $getDate->fetch_assoc()) {
				$DateValue = $rowGetDate['date'];
				$VisitsValue = $rowGetDate['visits'];
			}
			if ($Today == $DateValue) {
				$VisitsValue++;
				$sql = $connection->query("UPDATE visit_stats SET visits = '$VisitsValue'");
			} else if ($Today != $DateValue) {
				$sql = $connection->query("INSERT INTO visit_stats (`date`, visits) VALUES ('$Today', '1')");
			}
			// последняя дата посещения сайта
			$lastVisitDate = date("d-m-Y H:i:s");
			$updateLastVisitsDate = $connection->query("UPDATE loginparol SET last_visit='$lastVisitDate' WHERE login='$login'");
			header('Location: MainPage.php');
			exit();
		}
		else
		{
			echo '<script type="text/javascript">';
			echo 'alert("В ходе перехода на сайт библиотеки произошла ошибка")';
			echo '</script>';
			session_destroy(); 
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
				<span>Если вы забыли пароль обратитесь к своему куратору</span>
			</form>
		</div>
		<div class="hello">
			<div class="LoginPageLogoMainContainer">
				<div class="LoginPageLogoAlignContainer">
					<div class="LoginPageLogoContainer">
						<img src="Img/Logo.png" class="LoginPageLogo">
					</div><div class="LoginPageLogoCaptionContainer">
						<h1 class="LoginPageLogoHeader">ДОБРО ПОЖАЛОВАТЬ</h1>
						<span class="LoginPageLogoCaption">Вы находитесь на сайте электронной библиотеки ВАТ имени В. П. Чкалова</span>
					</div>
				</div>
			</div>
			<div class="HelloTextContainer">
				<span class="helloText">
			
				</span>
				<span class="helloText">В нашей библиотеке представлены 
					<span id="BookAmount"></span> произведений классической и учебной литературы от 
					<span id="AuthorAmount"></span> авторов в 
					<span id="CategoryAmount"></span> категориях.
				</span>
			<!--<span class="helloText">Для того, чтобы ознакомится с каталогом литературы 
			вам необходимо быть студентом ВАТ имени В. П. Чкалова и получить логин и пароль от куратора группы</span>-->
				<span class="helloText">Для того, чтобы ознакомится с каталогом литературы
				вам необходимо быть студентом ВАТ имени В. П. Чкалова и пройти авторизацию,
				используя логин и пароль, полученные от вашего куратора.</span>
				<span class="helloText">Приятного чтения.</span>
				
			</div>
			<button class="LButton openLoginForm" id="openLoginForm">Войти</button>
		</div>
		<div class="LoginFooter">
			<div class="LoginFooterInfo">
				<span class="FooterRow">Контакты</span>
				<span class="FooterRow">Тел.: +7 (473) 249 10 02</span>
				<span class="FooterRow">Email: <a href="mailto:vatk2001@mail.ru">vatk2001@mail.ru</a></span>
				<span class="FooterRow">ВАТ имени В. П. Чкалова: <a href="http://www.vatvrn.ru/">http://www.vatvrn.ru/</a></span>
			</div>
		</div>
	</body>
</html>