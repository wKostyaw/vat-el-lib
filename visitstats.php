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
		<script src="Js/jquery.table2excel.min.js" type="text/javascript"></script>
		<script src="Js/AddOneMore.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				
					<h2 class="AdminStart MainHeader">Количество посещений</h2>
					<p class="SearchInReport">Общая статистика посещений</p>
					<table class="sumReportTable">
						<tr class="sumReportTableRow">
							<th class="sumReportTableHeaderCell">Суммарное количество посещений</th>
							<td class="sumReportTableCell"><? echo $sum ?></td>
						</tr>
						<tr class="sumReportTableRow">
						<th class="sumReportTableHeaderCell">Среднее количество в день</th>
							<td class="sumReportTableCell"><? echo $srarifm ?></td>
						</tr>
						<tr class="sumReportTableRow">
							<th class="sumReportTableHeaderCell">Максимальное за день</th>	
							<td class="sumReportTableCell"><? echo $max ?></td>
						</tr>
					</table>
				
					<form method="GET" class="FilterReport">
						<p class="SearchInReportHeader">Статистика посещений по дням</p>
						<div class="SearchInReport">
						<label class="filterContainer">Введите день в формате: день-месяц-год (например: 06-06-2019)<br>
							<input type="text" name="zaprosText" class="TextInput HalfWidth" placeholder="ДД-ММ-ГГГГ">
							<input type="submit" name="zaprosSubmit" class="ReportTableButton ApplyFilter">
						</label>
						</div>
					</form>
				
				<br>
				<div class="reportTableButtonsContainer">
					<input type="button" name="exportInto" class="exportInto ReportTableButton" value="Экспорт таблицы">
					<? 
						if (isset($_GET['zaprosSubmit'])) {
							echo '<button class="ReportTableButton" onclick="javascript:history.back();﻿">Назад</button>';
						}
					?>
				</div>
					<?php 
						if (!empty($_GET['zaprosText']) and isset($_GET['zaprosSubmit'])) 
						{
							echo '<table class="reportTable">';
								echo'<tr class="reportTableRow">';
									echo '<th class="reportTableHeaderCell">День</th>';
									echo '<th class="reportTableHeaderCell">Количество посещений</th>';
								echo '</tr>';
								$q = $_GET['zaprosText'];
								$sql = $connection->query("SELECT * FROM visit_stats WHERE `date` = '$q'"); 
								$rows = mysqli_num_rows($sql);
								for ($i=0; $i < $rows; $i++) 
								{ 
									$row2 = mysqli_fetch_row($sql);
									echo "<tr class='reportTableRow'>";
										echo "<td class='reportTableCell'> $row2[0]</td>";
										echo "<td class='reportTableCell'> $row2[1]</td>";
									echo "</tr>";
								}
							echo '</table>';
						} 
						else if (empty($_GET['zaprosText']) and isset($_GET['zaprosSubmit'])) 
						{
							echo "Введите запрос!";
						} 
						else if (!isset($_GET['zaprosSubmit'])) 
						{
							echo '<table class="reportTable">';
								echo'<tr class="reportTableRow">';
									echo '<th class="reportTableHeaderCell">День</th>';
									echo '<th class="reportTableHeaderCell">Количество посещений</th>';
								echo '</tr>';
								$sql = $connection->query("SELECT * FROM visit_stats"); //если второй раз не сделать запрос, то почему-то не хочет рисовать данные в таблицу
								$rows = mysqli_num_rows($sql);
								for ($i=0; $i < $rows; $i++) 
								{ 
									$row2 = mysqli_fetch_row($sql);
									echo "<tr class='reportTableRow'>";
										echo "<td class='reportTableCell'> $row2[0]</td>";
										echo "<td class='reportTableCell'> $row2[1]</td>";
									echo "</tr>";
								}
							echo '</table>';
						}
					?>
				<div class="reportTableButtonsContainer">
					<input type="button" name="exportInto" class="exportInto ReportTableButton" value="Экспорт таблицы">
					<? 
						if (isset($_GET['zaprosSubmit'])) {
							echo '<button class="ReportTableButton" onclick="javascript:history.back();﻿">Назад</button>';
						}
					?>
				</div>
			</div>
	</body>
</html>