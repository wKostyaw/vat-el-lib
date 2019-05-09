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
	if (isset($_POST['login']) and isset($_POST['password'])) {
		$login = $_POST['login'];
		$password = $_POST['password'];
		
		$query = "INSERT INTO loginparol (login, password) VALUES ('$login', '$password')";
		$result = mysqli_query ($connection, $query);

		if ($result) {
			echo '<script type="text/javascript">';
			echo 'alert("Пользователь успешно добавлен")';
			echo '</script>';
		} else {
			echo '<script type="text/javascript">';
			echo 'alert("Ошибка!")';
			echo '</script>';
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Добавить пользователя</title>
		<link rel="stylesheet" type="text/css" href="css/AdminPage.css">
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<div class="LogoContainer">
					<img src="img/workinprogress.png" class="Logo">
				</div>
					<ul class="AdminLinks">
						<li class="AdminLinkBox"><a href="mainpage.php" class="AdminLink">На сайт</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink AdminLinkActive">Добавить пользователя</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Изменить/удалить пользователя</a></li>
						<li class="AdminLinkBox"><a href="AddBookForm.php" class="AdminLink">Добавить книгу</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Изменить/удалить книгу</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Пароли, явки</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace('?exit');">Выход</a></li>
					</ul>
			</div>
			<div class="Option">
				<h2 class="MainHeader">Добавить пользователя</h2>
				<form method="POST">
					<div class="FormElemContainer">
					<p class="CategoryName">Логин</p>
					<input type="text" name="login" placeholder="Логин" class="TextInput HalfWidth" required>
					</div>
					<div class="FormElemContainer">
					<p class="CategoryName">Пароль</p>
					<input type="password" name="password" placeholder="Пароль" class="TextInput HalfWidth" required>
					</div>
					<div class="FormElemContainer">
					<button type="reset" class="FormButton ResetButton">Очистить</button>
					<button type="submit" class="FormButton SubmitButton">Добавить</button>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script src="js/JQuerry.js" type="text/javascript"></script>
</html>