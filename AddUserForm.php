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
		$query = "INSERT INTO loginparol (login, password, admin) VALUES ('$login', '$password', '$isAdmin')";
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
		$otvet = "<p>";
		$otvet .= "класс, даа";
		$otvet .= "</p>";
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
		<link rel="stylesheet" type="text/css" href="css/AdminPage.css">
		<script src="js/JQuerry.js" type="text/javascript"></script>
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
								/*alert('Класс!');
								alert(data);*/
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
				<div class="LogoContainer">
					<img src="img/workinprogress.png" class="Logo">
				</div>
					<ul class="AdminLinks">
						<li class="AdminLinkBox"><a href="mainpage.php" class="AdminLink">На сайт</a></li>
						<li class="AdminLinkBox"><a href="AddUserForm.php" class="AdminLink">Добавить пользователя</a></li>
						<li class="AdminLinkBox"><a href="ChangeUser.php" class="AdminLink">Изменить/удалить пользователя</a></li>
						<li class="AdminLinkBox"><a href="AddBookForm.php" class="AdminLink">Добавить книгу</a></li>
						<li class="AdminLinkBox"><a href="ChangeBook.php" class="AdminLink">Изменить/удалить книгу</a></li>
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
					<p>Будет ли администратором?</p>
					<p><input type="radio" name="isAdmin" value="1">Да
					<input type="radio" name="isAdmin" value="0" checked="">Нет</p>
					</div>
					<div class="FormElemContainer">
					<p class="CategoryName">Пароль</p>
					<input type="text" name="password" placeholder="Пароль" class="TextInput HalfWidth" required >
					<input type="button" id="passwordGenerator" value="Сгенерировать пароль">
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