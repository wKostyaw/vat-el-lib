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
		<script src="Js/JQuerry.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h1 class="AdminStart">Информация о категориях</h1>
				<!-- <form method="GET" action="InfoAboutBooks.php">
					<input type="text" name="sql-zapros" placeholder="Введите автора или категорию" autocomplete="off">
					<input type="submit" name="otpravit-sql-zapros" value="Отправить">
				</form> -->
				<?php 
					$sql = $connection->query("SELECT Category FROM categories");
					if ($sql) 
					{
						$rows = mysqli_num_rows($sql);
						echo "<table border='1'>"; 
						    echo "<tr><th>Категория</th><th>Книги</th></tr>";
							for ($i=0; $i < $rows; $i++) { 
								$row = $sql->fetch_row();
								echo "<tr>";
								for ($j=0; $j < 1 ; $j++) { 
									echo "<td rowspan='2'>$row[$j]</td>";
									echo "<td><tr></tr><tr></tr></td>";
								}
								echo "</tr>";
							}
					}
					
				 ?>
			</div>
	</body>
	<script src="Js/JQuerry.js" type="text/javascript"></script>
	<script src="Js/AddOneMore.js" type="text/javascript"></script>
</html>