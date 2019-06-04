<?php
	include_once "auth.php";
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
	$sql = $connection->query("SELECT * FROM loginparol");
	$rows = $sql->num_rows;
	$sql1 = $connection->query("SELECT * FROM loginparol WHERE admin = '2'");
	$rows1 = $sql1->num_rows;
	$rows2 = $rows - $rows1;
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Css/AdminPage.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script src="Js/AddOneMore.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h1 class="AdminStart">Сводка по пользователям</h1>
				<table border="1">
					<tr>
						<th>Количество зарегестрированных пользователей</th>
						<td><? echo $rows ?></td>
					</tr>
					<tr>
						<th>Количество действующих пользователей</th>
						<td><? echo $rows2 ?></td>
					</tr>
					<tr>
						<th>Количество заблокированных пользователей</th>
						<td><? echo $rows1 ?></td>
					</tr>
				</table>
			</div>
		</div>
	</body>
</html>