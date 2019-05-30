<?php
	include_once "auth.php";
	// Проверка на админа
	$username = $_SESSION['login'];
	$admin = ("SELECT admin FROM loginparol WHERE login='$username'");
	$result = $connection->query ($admin);
	if ($result->num_rows > 0) 
	{
		while ($row = $result->fetch_assoc()) 
		{
			$isAdmin = $row["admin"];
		}
	}
	if ($isAdmin == 0) {
		header('Location: MainPage.php');
		exit();
	}
	// autocomplete
	if (isset($_POST['search'])) 
	{
		$q = $connection->real_escape_string($_POST['q']);
		$sql = $connection->query("SELECT * FROM loginparol WHERE login LIKE '%$q%'");
		if ($sql->num_rows > 0) 
		{
			$response = "<ul class='HintList'>";
				while ($data = $sql->fetch_array()) 
				{
					$response .= "<li id='li0' class='Hint'>" . $data['login'] . "</li>";
					echo "<input type='text' hidden='' id='hiddenPassword' name='old_password' value='".$data['password']."'>" ; //вывод в невидимый инпут пароля изменяемого пользователя для передачи в форму
					echo "<input type='text' hidden='' id='hiddenID' name='old_password' value='".$data['id']."'>" ; //вывод в невидимый инпут id пользователя
				}
			$response .= "</ul>";
		}
		exit($response);
	}
	// генератор нового пароля
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
	// обработчик кнопки "изменить"
	$id = $_POST['usersID'];
	if (isset($_POST['change'])) 
	{
		$new_login = $_POST['login'];
		$new_password = $_POST['password'];
		
		
		// ФИО и группа
		$new_imya = $_POST['imya'];
		$new_familia = $_POST['familia'];
		$new_otchestvo = $_POST['otchestvo'];
		$new_gruppa = $_POST['gruppa'];
		
		
		
		$sql = $connection->query("UPDATE loginparol SET login='$new_login', password='$new_password' WHERE id = '$id'");
		if ($sql) {
			echo "<script> alert('Данные пользователя " . $_POST['login'] . " изменены')</script>";
		} else {
			echo "<script> alert('При изменении данных пользователя " . $_POST['login'] . " произошла ошибка')</script>";	
		}
	}
	// обработчик кнопки "удалить"
	if (isset($_POST['delete'])) 
	{
		$sql = $connection->query("DELETE FROM loginparol WHERE id = '$id'");
		if ($sql) {
			echo "<script> alert('Данные пользователя " . $_POST['login'] . " удалены')</script>";
		} else {
			echo "<script> alert('При удалении данных пользователя " . $_POST['login'] . " произошла ошибка')</script>";
		}
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Изменить/удалить пользователя</title>
		<link rel="stylesheet" type="text/css" href="css/AdminPage.css">
		<link rel="stylesheet" type="text/css" href="css/ChangeUser.css">
		<script src="js/JQuerry.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function(){
				var passField = $('input[name="password"]');
				$(document).on('click', '#passwordGenerator', function(){
					$.ajax({
							url: 'ChangeUser.php',
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
				$(document).on('click', 'input[name="change"]', function(){
					
				})
				$("#SearchBox").keyup(function() {
					var query = $("#SearchBox").val();							
					// if (query.length > 1) 
					// {
						$.ajax (
							{
								url: 'ChangeUser.php',
								method: 'POST',
								data: {
									search: 1,
									q: query
								},
								success: function (data) {
								$("#response").html(data);
								},
								dataType: 'text'
							}
						);			
					// }
				});
				$(document).on('click', '#li0', function (){
					var login = $(this).text();
					var password = $("#hiddenPassword").val();
					var id = $("#hiddenID").val();
					$("#usersID").val(id);
					$("#SearchBox").val('');
					$('input[name="login"]').val(login);
					$('input[name="password"]').val(password);
					$("#response").html("");
					$('.findUser').css('display', 'none');
					$('.changeUser').css('display', 'block');
				});
									
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
						<li class="AdminLinkBox"><a href="InfoAboutUsers.php" class="AdminLink">Информация о пользователях</a></li>
						<li class="AdminLinkBox"><a href="CustomizeSlider.php" class="AdminLink">Настройка главной страницы</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace('?exit');">Выход</a></li>
					</ul>
			</div>
			<div class="Option">
				<h2 class="MainHeader">Изменить/удалить пользователя</h2>
				<form class="findUser" name="findUser">
					<div class="FormElemContainer">
						<p class="CategoryName">Логин пользоваетеля</p>
						<div class="SBorder">
						<div class="flexContainer">
							<input type="text" class="TextInput HalfWidth USearchName" autocomplete="off" id="SearchBox">
						</div>
						<div id="response" class="HintBox"></div>
						</div>
					</div>
				</form>
				
				<form method="POST" class="changeUser">
					<div class="FormElemContainer">
						<p class="CategoryName">Логин</p>
						<input type="text" name="usersID" id="usersID" hidden="">
						<input type="text" name="login" placeholder="Логин" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Пароль</p>
						<div class="flexContainer SBorder HalfWidth">
							<input type="text" name="password" placeholder="Пароль" class="TextInput noBorder" autocomplete="off" required>
							<input type="button" id="passwordGenerator" class="FormButton RandPassBtn" value="Создать пароль">
						</div>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Права пользователя:</p>
						
						
						
						
						<!--<p>-->
						<input type="radio" name="isAdmin" value="0" checked=""> Читатель<br>
						<input type="radio" name="isAdmin" value="1"> Администратор<br>
						<input type="radio" name="isAdmin" value="2"> Заблокирован
						<!--</p>-->
						
						
						
						
						
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Имя</p>
						<input type="text" name="imya" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Фамилия</p>
						<input type="text" name="familia" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Отчество</p>
						<input type="text" name="otchestvo" class="TextInput HalfWidth" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Группа</p>
						<input type="text" name="gruppa" class="TextInput HalfWidth" autocomplete="off">
					</div>
					<div class="FormElemContainer">
						<input type="submit" class="FormButton DeleteButton" name="delete" value="Удалить">   
						<input type="submit" class="FormButton SubmitButton" name="change" value="Изменить">
					</div>
				</form>
			</div>
		</div>
	</body>
	<script src="js/JQuerry.js" type="text/javascript"></script>
</html>