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
								/*alert('Класс!');
								alert(data);*/
								passField.val(data);
							},
							dataType: 'text'
						}
					)
				})
				$(document).on('click', 'input[name="change"]', function(){
					
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
				<h2 class="MainHeader">Изменить/удалить пользователя</h2>
				<form class="findUser" name="findUser">
					<div class="FormElemContainer">
						<p class="CategoryName">Логин разыскиваемого</p>
						<div class="flexContainer SBorder">
							<input type="text" class="TextInput HalfWidth USearchName" id="SearchBox">
							<button Class="FormButton USearchBtn" type="button">
								<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
									<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
								</svg>
							</button>
							<!-- Автокомплит сюда(если нужен) -->
							<script type="text/javascript">
								$(document).ready(),function () {
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
									});
								}();
							</script>
							<div id="response" class="HintBox"></div>
						</div>
					</div>
				</form>
				<form method="POST">
					<div class="FormElemContainer">
						<p class="CategoryName">Логин</p>
						<input type="text" name="usersID" id="usersID" hidden="">
						<input type="text" name="login" placeholder="Логин" class="TextInput HalfWidth" required>
					</div>
					<div class="FormElemContainer">
						<p class="CategoryName">Пароль</p>
						<input type="text" name="password" placeholder="Пароль" class="TextInput HalfWidth" required>
						<input type="button" id="passwordGenerator" value="Сгенерировать новый пароль">
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