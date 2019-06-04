<?php
	require "auth.php";
	// Проверка на админа
	$username = $_SESSION['login'];
	$admin = ("SELECT admin FROM loginparol WHERE login='$username'");
	$result = $connection->query ($admin);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$kek = $row["admin"] ;
		}
	}
	if ($kek == 0) {
		header('Location: MainPage.php');
		exit();
	}
	// Добавление пользователя
	if (isset($_POST['login']) and isset($_POST['password'])) 
	{
		$login = $_POST['login'];
		$password = $_POST['password'];
		$isAdmin = $_POST['isAdmin'];
		$imya = $_POST['imya'];
		$familiya = $_POST['familiya'];
		$otchestvo = $_POST['otchestvo'];
		$grupa = $_POST['grupa'];
		$reg_date = date("d-m-Y H:i:s");
		$query = "INSERT INTO loginparol (login, password, admin, imya, familiya, otchestvo, grupa, reg_date) VALUES ('$login', '$password', '$isAdmin', '$imya', '$familiya', '$otchestvo', '$grupa', '$reg_date')";
		$result = mysqli_query ($connection, $query);
		if ($result) 
		{
			echo '<script type="text/javascript">';
			echo 'alert("Пользователь успешно добавлен")';
			echo '</script>';
		} else 
		{
			echo '<script type="text/javascript">';
			echo 'alert("Ошибка!")';
			echo '</script>';
		}
	}
	// генератор паролей 
	if (isset($_POST['pswrdgnrtr'])) 
	{
		$chars="qazxswedcvfrtgbnhyujmkiolp1234567890QAZXSWEDCVFRTGBNHYUJMKIOLP"; 
		$max=10; 
		$size=StrLen($chars)-1; 
		$password=null; 
		while($max--) 
		{
		$password.=$chars[rand(0,$size)];
		}
		exit($password);
	}
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Добавить пользователя</title>
		<link rel="stylesheet" type="text/css" href="Css/AdminPage.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var passField = $('input[name="password"]');
				$(document).on('click', '#passwordGenerator', function(){
					$.ajax({
							url: 'AddUserForm.php',
							method: 'POST',
							data: {
								pswrdgnrtr: 1
							}, 
							success: function (data) {
								passField.val(data);
							},
							dataType: 'text'
						}
					)
				})
			});
		</script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h2 class="MainHeader">Добавить пользователя</h2>
				<form method="POST">
					<div class="FormElemContainer">
						<p class="CategoryName">Фамилия</p>
						<input type="text" name="familiya" placeholder="Фамилия" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Имя</p>
						<input type="text" name="imya" placeholder="Имя" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Отчество</p>
						<input type="text" name="otchestvo" placeholder="Отчество" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Группа</p>
						<input type="text" name="grupa" placeholder="Группа" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p>Роль пользователя</p>
						<p>
							<input type="radio" name="isAdmin" value="1">Администратор<br>
							<input type="radio" name="isAdmin" value="0" checked="">Читатель
						</p>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Логин</p>
						<input type="text" name="login" placeholder="Логин" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Пароль</p>
						<div class="flexContainer SBorder HalfWidth">
						<input type="text" name="password" placeholder="Пароль" class="TextInput HalfWidth noBorder" autocomplete="off" required>
						<input type="button" id="passwordGenerator" class="FormButton RandPassBtn" value="Создать пароль">
						</div>
					</div>
					<div class="FormElemContainer">
						<button type="reset" class="FormButton ResetButton">Очистить</button>
						<button type="submit" class="FormButton SubmitButton">Добавить</button>
					</div>
				</form>
			</div>
		</div>
	</body>
	
</html>