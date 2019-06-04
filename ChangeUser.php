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
		$sql2 = $connection->query("SELECT * FROM loginparol WHERE familiya LIKE '%$q%'");
		if ($sql->num_rows > 0 || $sql2->num_rows > 0) 
		{
			$response = "<ul class='HintList'>";
				while ($data = $sql->fetch_array()) 
				{
					$response .= "<a style='color: #000;' href='ChangeUser.php?id=".$data['id']."&old_login=".$data['login']."&old_password=".$data['password']."&old_familiya=".$data['familiya']."&old_imya=".$data['imya']."&old_otchestvo=".$data['otchestvo']."&old_status=".$data['admin']."&old_grupa=".$data['grupa']."'><li id='li0' class='Hint'>" . $data['login'] . "</li></a>";
				}
				while ($data2 = $sql2->fetch_array()) 
				{
					$response .= "<a style='color: #000;' href='ChangeUser.php?id=".$data2['id']."&old_login=".$data2['login']."&old_password=".$data2['password']."&old_familiya=".$data2['familiya']."&old_imya=".$data2['imya']."&old_otchestvo=".$data2['otchestvo']."&old_status=".$data2['admin']."&old_grupa=".$data2['grupa']."'><li id='li0' class='Hint'>" . $data2['familiya'] . " " . $data2['imya'] . " " . $data2['otchestvo'] . "</li></a>";
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
	$id = $_GET['id'];
	$old_login = $_GET['old_login'];
	$old_password = $_GET['old_password'];
	$old_familiya = $_GET['old_familiya'];
	$old_imya = $_GET['old_imya'];
	$old_otchestvo = $_GET['old_otchestvo'];
	$old_grupa = $_GET['old_grupa'];
	$old_status = $_GET['old_status'];
	if (isset($_POST['change'])) 
	{
		$new_login = $_POST['login'];
		$new_password = $_POST['password'];
		// ФИО и группа
		$new_imya = $_POST['imya'];
		$new_familiya = $_POST['familiya'];
		$new_otchestvo = $_POST['otchestvo'];
		$new_gruppa = $_POST['gruppa'];
		$new_status = $_POST['status'];
		echo $new_status;
		$sql = $connection->query("UPDATE loginparol SET login='$new_login', password='$new_password', familiya='$new_familiya', imya='$new_imya', otchestvo='$new_otchestvo', grupa='$new_gruppa', admin='$new_status' WHERE id = '$id'");
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
		<link rel="stylesheet" type="text/css" href="Css/AdminPage.css">
		<link rel="stylesheet" type="text/css" href="Css/ChangeUser.css">
		<style type="text/css">
			A:link { text-decoration: none;  } 
		   	A:visited { text-decoration: none; } 
		   	A:active { text-decoration: none; }
		   	A:hover { text-decoration: none; }
		</style>
		<script src="Js/JQuerry.js" type="text/javascript"></script>
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
					if (query.length > 0) 
					{
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
					}
				});					
			});
		</script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h2 class="MainHeader">Изменить/удалить пользователя</h2>
				<form class="findUser" name="findUser">
					<div class="FormElemContainer">
						<p class="CategoryName">Введите логин или фамилию пользоваетеля, данные которого Вы хотите изменить:</p>
						<div class="SBorder">
						<div class="flexContainer">
							<input type="text" class="TextInput HalfWidth USearchName" autocomplete="off" id="SearchBox">
						</div>
						<div id="response" class="HintBox"></div>
						</div>
					</div>
				</form>
				<?php 
				if ($old_login != '' and $old_password != '') 
				{
					?>
					<form method="POST" class="changeUser">
						<div class="FormElemContainer">
							<p class="CategoryName">Фамилия</p>
							<? echo "<input type='text' name='familiya' class='TextInput HalfWidth' value='".$old_familiya."' autocomplete='off'>"?>
						</div>
						<div class="FormElemContainer">
							<p class="CategoryName">Имя</p>
							<? echo "<input type='text' name='imya' class='TextInput HalfWidth' value='".$old_imya."' autocomplete='off'>"?>
						</div>
						<div class="FormElemContainer">
							<p class="CategoryName">Отчество</p>
							<? echo "<input type='text' name='otchestvo' class='TextInput HalfWidth' value='".$old_otchestvo."' autocomplete='off'>"?>
						</div>
						<div class="FormElemContainer">
							<p class="CategoryName">Группа</p>
							<? echo "<input type='text' name='gruppa' class='TextInput HalfWidth' value='".$old_grupa."' autocomplete='off'>"?>
						</div>
						<div class="FormElemContainer">
							<p class="CategoryName">Роль пользователя:</p>
							<?php 
								if ($old_status == 0) {
									echo "<input type='radio' name='status' value='0' checked=''> Читатель<br>";
									echo "<input type='radio' name='status' value='1'> Администратор<br>";
									echo "<input type='radio' name='status' value='2'> Заблокирован";
								} else if ($old_status == 1) {
									echo "<input type='radio' name='status' value='0'> Читатель<br>";
									echo "<input type='radio' name='status' value='1' checked=''> Администратор<br>";
									echo "<input type='radio' name='status' value='2'> Заблокирован";
								} else if ($old_status == 2) {
									echo "<input type='radio' name='status' value='0'> Читатель<br>";
									echo "<input type='radio' name='status' value='1'> Администратор<br>";
									echo "<input type='radio' name='status' value='2' checked=''> Заблокирован";
								}
							?>
						</div>
						<div class="FormElemContainer">
							<p class="CategoryName">Логин</p>
							<?echo "<input type='text' name='login' placeholder='Логин' class='TextInput HalfWidth' autocomplete='off' value='".$old_login."' required >"?>
						</div>
						<div class="FormElemContainer">
							<p class="CategoryName">Пароль</p>
							<div class="flexContainer SBorder HalfWidth">
								<?echo "<input type='text' name='password' placeholder='Пароль' class='TextInput noBorder' autocomplete='off' value='".$old_password."' required>"?>
								<input type="button" id="passwordGenerator" class="FormButton NewRandPassBtn" value="Создать новый пароль">
							</div>
						</div>
						<div class="FormElemContainer">
							<input type="submit" class="FormButton DeleteButton" name="delete" value="Удалить">   
							<input type="submit" class="FormButton SubmitButton" name="change" value="Изменить">
						</div>
					</form>
					<?php
				}
				?>
			</div>
		</div>
	</body>
	<script src="Js/JQuerry.js" type="text/javascript"></script>
</html>