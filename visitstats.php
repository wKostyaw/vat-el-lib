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
	if ($kek != 1) {
		header('Location: MainPage.php');
		exit();
	
	}
	$Visits = array();
	$sql = $connection->query("SELECT * FROM visit_stats");
	while ($row = $sql->fetch_assoc()) {
		array_push($Visits, $row['visits']);
	}
	// суммарное кол-во посещений
	$sum = array_sum($Visits);
	// среднее кол-во
	$rows = mysqli_num_rows($sql);
	$srarifm = $sum / $rows;
	// макс в день
	$max = max($Visits);

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
				<h1 class="AdminStart">Количество посещений</h1>
				<p>Общая статистика посещений</p>
				<table border="1">
					<tr>
						<th>Суммарное количество посещений</th>
						<th>Среднее количество в день</th>
						<th>Максимальное за день</th>	
					</tr>
					<tr>
						<td><? echo $sum ?></td>
						<td><? echo $srarifm ?></td>
						<td><? echo $max ?></td>
					</tr>
				</table>
				<p>Статистика посещений по дням</p>
				<form method="GET">
					<p>Введите день в формате: день-месяц-год (например: 06-06-2019)</p>
					<input type="text" name="zaprosText">
					<input type="submit" name="zaprosSubmit">
				</form>
				
					<?php 
						if (!empty($_GET['zaprosText']) and isset($_GET['zaprosSubmit'])) 
						{
							echo '<table border="1">';
								echo'<tr>';
									echo '<th>День</th>';
									echo '<th>Количество посещений</th>';
								echo '</tr>';
								$q = $_GET['zaprosText'];
								$sql = $connection->query("SELECT * FROM visit_stats WHERE `date` = '$q'"); 
								$rows = mysqli_num_rows($sql);
								for ($i=0; $i < $rows; $i++) 
								{ 
									$row2 = mysqli_fetch_row($sql);
									echo "<tr>";
										echo "<td> $row2[0]</td>";
										echo "<td> $row2[1]</td>";
									echo "</tr>";
								}
							echo '</table>';
							echo '<button onclick="javascript:history.back();﻿">Назад</button>';
						} 
						else if (empty($_GET['zaprosText']) and isset($_GET['zaprosSubmit'])) 
						{
							echo "Введите запрос!";
						} 
						else if (!isset($_GET['zaprosSubmit'])) 
						{
							echo '<table border="1">';
								echo'<tr>';
									echo '<th>День</th>';
									echo '<th>Количество посещений</th>';
								echo '</tr>';
								$sql = $connection->query("SELECT * FROM visit_stats"); //если второй раз не сделать запрос, то почему-то не хочет рисовать данные в таблицу
								$rows = mysqli_num_rows($sql);
								for ($i=0; $i < $rows; $i++) 
								{ 
									$row2 = mysqli_fetch_row($sql);
									echo "<tr>";
										echo "<td> $row2[0]</td>";
										echo "<td> $row2[1]</td>";
									echo "</tr>";
								}
							echo '</table>';
						}
					?>
				
			</div>
	</body>
</html>