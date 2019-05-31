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
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="Css/AdminPage.css">
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h1 class="AdminStart">Информация о пользователях</h1>
				<form method="GET" action="InfoAboutUsers.php">
					<input type="text" name="sql-zapros" placeholder="Введите группу" autocomplete="off" >
					<input type="submit" name="otpravit-sql-zapros" value="Отправить">
				</form>
				<br>
				<?php 
					if (isset($_GET['otpravit-sql-zapros'])) {
						$q = $_GET['sql-zapros'];
						$sql = $connection->query("SELECT * FROM loginparol WHERE grupa LIKE '%$q%' ORDER BY id");
						if($sql)
						{
						    $rows = mysqli_num_rows($sql); // количество полученных строк
						    echo "<table border='1' >"; 
						    echo "<tr><th>id</th><th>Логин</th><th>Пароль</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Группа</th><th>Является ли администратором (1 - да, 0 - нет)</th></tr>";
						    for ($i = 0; $i < $rows; $i++)
						    {
						    	$row = mysqli_fetch_row($sql);
						    	echo "<tr>";
						            for ($j = 0 ; $j < 8 ; ++$j) 
						            {
						            	echo "<td>". $row[$j]. "</td>";
						            } 
						        echo "</tr>";
						    }
						    echo "</table>";
						} else 
						{
							echo "не";
						}
					} else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros'])) 
					{
						$sql = $connection->query("SELECT * FROM loginparol ORDER BY id");
						if($sql)
						{
						    $rows = mysqli_num_rows($sql); // количество полученных строк
						    echo "<table border='1'>"; 
						    echo "<tr><th>id</th><th>Логин</th><th>Пароль</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Группа</th><th>Является ли администратором (1 - да, 0 - нет)</th></tr>";
						    for ($i = 0; $i < $rows; $i++)
						    {
						    	$row = mysqli_fetch_row($sql);
						    	echo "<tr>";
						            for ($j = 0 ; $j < 8 ; ++$j) 
						            {
						            	echo "<td>". $row[$j]. "</td>";
						            } 
						        echo "</tr>";
						    }
						    echo "</table>";
						} else 
						{
							echo "не";
						}
					} else 
					{
						$sql = $connection->query("SELECT * FROM loginparol ORDER BY id");
						if($sql)
						{
						    $rows = mysqli_num_rows($sql); // количество полученных строк
						    echo "<table border='1'>"; 
						    echo "<tr><th>id</th><th>Логин</th><th>Пароль</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Группа</th><th>Является ли администратором (1 - да, 0 - нет)</th></tr>";
						    for ($i = 0; $i < $rows; $i++)
						    {
						    	$row = mysqli_fetch_row($sql);
						    	echo "<tr>";
						            for ($j = 0 ; $j < 8 ; ++$j) 
						            {
						            	echo "<td>". $row[$j]. "</td>";
						            } 
						        echo "</tr>";
						    }
						    echo "</table>";
						} else 
						{
							echo "не";
						}
					}		
				?>

			</div>
		</div>
	</body>
	<script src="Js/JQuerry.js" type="text/javascript"></script>
</html>