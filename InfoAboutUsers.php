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
				<h2 class="AdminStart MainHeader">Информация о пользователях</h2>
				<div>
					<p>Сводка по юзерам</p>
					<?php 
						$sql = $connection->query("SELECT * FROM loginparol");
						$rows = $sql->num_rows;
						$sql1 = $connection->query("SELECT * FROM loginparol WHERE admin = '2'");
						$rows1 = $sql1->num_rows;
						$rows2 = $rows - $rows1;
					?>
					<table border="1">
						<tr>
							<th>Количество зарегистрированных пользователей</th>
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
					<br>
				</div>
				<div>
					<form method="GET" action="InfoAboutUsers.php">
						<div class="SearchInReport">
							<input type="text" class="TextInput HalfWidth" name="sql-zapros" placeholder="Введите группу" autocomplete="off" >
							
							<p>Вывести пользователей:</p>
							<input type="radio" name="status" value="0" > Всех
							<input type="radio" name="status" value="1"> Читателей
							<input type="radio" name="status" value="2"> Администраторов
							<input type="radio" name="status" value="3"> Заблокированных
							<input type="submit" name="otpravit-sql-zapros" value="Отправить">
						</div>
					</form>
					<br>
					<?php 
						if ($_GET['status'] == 0) 
						{
							if (isset($_GET['otpravit-sql-zapros']) and !empty($_GET['sql-zapros'])) 
							{
								$q = $_GET['sql-zapros'];
								$sql = $connection->query("SELECT * FROM loginparol WHERE grupa LIKE '%$q%' ORDER BY id");
								if($sql)
								{
								    $rows = mysqli_num_rows($sql); // количество полученных строк
								    echo "<table class='reportTable'>"; 
									    echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
									    for ($i = 0; $i < $rows; $i++)
									    {
									    	$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
												
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							} 
							else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								
							}
							else if (!isset($_GET['otpravit-sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableHeaderRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}

							}
						} 
						else if ($_GET['status'] == 1) 
						{
							if (isset($_GET['otpravit-sql-zapros']) and !empty($_GET['sql-zapros'])) 
							{
								$q = $_GET['sql-zapros'];
								$sql = $connection->query("SELECT * FROM loginparol WHERE grupa LIKE '%$q%' AND admin LIKE '0' ORDER BY id");
								if($sql)
								{
								    $rows = mysqli_num_rows($sql); // количество полученных строк
								    if ($rows > 0) 
								    {
									    echo "<table class='reportTable'>"; 
										    echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										    for ($i = 0; $i < $rows; $i++)
										    {
										    	$row = mysqli_fetch_assoc($sql);
												echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
													echo "<td class='reportTableCell'>$row[id]</td>";
													echo "<td class='reportTableCell'>$row[login]</td>";
													echo "<td class='reportTableCell'>$row[password]</td>";
													if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
														echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
													} else {
														echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
													}
													echo "<td class='reportTableCell'>$row[grupa]</td>";
													if ($row['admin'] == 0) {
														echo "<td class='reportTableCell'>Читатель</td>";
													} else if ($row['admin'] == 1) {
														echo "<td class='reportTableCell'>Администратор</td>";
													} else if ($row['admin'] == 2) {
														echo "<td class='reportTableCell'>Заблокирован</td>";
													}
													echo "<td class='reportTableCell'>$row[reg_date]</td>";
													echo "<td class='reportTableCell'>$row[last_visit]</td>";
													echo "<td class='reportTableCell'>$row[visits]</td>";
													
									            echo "</tr>";
										    }
									    echo "</table>";

									} 
									else
									{
										echo "Нет совпадения по заданным критериям";
									}
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							} 
							else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol WHERE admin = '0' ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							}
							else if (!isset($_GET['otpravit-sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol WHERE admin = '0' ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							}
						}
						else if ($_GET['status'] == 2) 
						{
							if (isset($_GET['otpravit-sql-zapros']) and !empty($_GET['sql-zapros'])) 
							{
								$q = $_GET['sql-zapros'];
								$sql = $connection->query("SELECT * FROM loginparol WHERE grupa LIKE '%$q%' AND admin LIKE '1' ORDER BY id");
								if($sql)
								{
								    $rows = mysqli_num_rows($sql); // количество полученных строк
								    if ($rows > 0) 
								    {
									    echo "<table class='reportTable'>"; 
										    echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										    for ($i = 0; $i < $rows; $i++)
										    {
										    	$row = mysqli_fetch_assoc($sql);
												echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
													echo "<td class='reportTableCell'>$row[id]</td>";
													echo "<td class='reportTableCell'>$row[login]</td>";
													echo "<td class='reportTableCell'>$row[password]</td>";
													if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
														echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
													} else {
														echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
													}
													echo "<td class='reportTableCell'>$row[grupa]</td>";
													if ($row['admin'] == 0) {
														echo "<td class='reportTableCell'>Читатель</td>";
													} else if ($row['admin'] == 1) {
														echo "<td class='reportTableCell'>Администратор</td>";
													} else if ($row['admin'] == 2) {
														echo "<td class='reportTableCell'>Заблокирован</td>";
													}
													echo "<td class='reportTableCell'>$row[reg_date]</td>";
													echo "<td class='reportTableCell'>$row[last_visit]</td>";
													echo "<td class='reportTableCell'>$row[visits]</td>";
													
									            echo "</tr>";
										    }
									    echo "</table>";
									} 
									else
									{
										echo "Нет совпадения по заданным критериям";
									}
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							} 
							else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol WHERE admin='1' ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							} 
							else if (!isset($_GET['otpravit-sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol WHERE admin='1' ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
							echo '<button onclick="javascript:history.back();﻿">Назад</button>';	
							}
						}
						else if ($_GET['status'] == 3) 
						{
							if (isset($_GET['otpravit-sql-zapros']) and !empty($_GET['sql-zapros'])) 
							{
								$q = $_GET['sql-zapros'];
								$sql = $connection->query("SELECT * FROM loginparol WHERE grupa LIKE '%$q%' AND admin LIKE '2' ORDER BY id");
								if($sql)
								{
								    $rows = mysqli_num_rows($sql); // количество полученных строк
								    if ($rows > 0) 
								    {
									    echo "<table class='reportTable'>"; 
										    echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										    for ($i = 0; $i < $rows; $i++)
										    {
										    	$row = mysqli_fetch_assoc($sql);
												echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
													echo "<td class='reportTableCell'>$row[id]</td>";
													echo "<td class='reportTableCell'>$row[login]</td>";
													echo "<td class='reportTableCell'>$row[password]</td>";
													if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
														echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
													} else {
														echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
													}
													echo "<td class='reportTableCell'>$row[grupa]</td>";
													if ($row['admin'] == 0) {
														echo "<td class='reportTableCell'>Читатель</td>";
													} else if ($row['admin'] == 1) {
														echo "<td class='reportTableCell'>Администратор</td>";
													} else if ($row['admin'] == 2) {
														echo "<td class='reportTableCell'>Заблокирован</td>";
													}
													echo "<td class='reportTableCell'>$row[reg_date]</td>";
													echo "<td class='reportTableCell'>$row[last_visit]</td>";
													echo "<td class='reportTableCell'>$row[visits]</td>";
													
									            echo "</tr>";
										    }
									    echo "</table>";
									} 
									else
									{
										echo "Нет совпадения по заданным критериям";
									}
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							} 
							else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol WHERE admin = '2' ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							}
							else if (!isset($_GET['otpravit-sql-zapros'])) 
							{
								$sql = $connection->query("SELECT * FROM loginparol WHERE admin = '2' ORDER BY id");
								if($sql)
								{
									$rows = mysqli_num_rows($sql); // количество полученных строк
									echo "<table class='reportTable'>"; 
										echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Логин</th><th class='reportTableHeaderCell'>Пароль</th><th class='reportTableHeaderCell'>ФИО</th><th class='reportTableHeaderCell'>Группа</th><th class='reportTableHeaderCell'>Права пользователя</th><th class='reportTableHeaderCell'>Дата регистрации</th><th class='reportTableHeaderCell'>Дата последнего посещения</th><th class='reportTableHeaderCell'>Количество посещений библиотеки</th></tr>";
										for ($i = 0; $i < $rows; $i++)
										{
											$row = mysqli_fetch_assoc($sql);
											echo "<tr class='reportTableRow' onclick='document.location.href=\"/InfoAboutOneUser.php?userid=" . $row['id'] . "\"'>";
												echo "<td class='reportTableCell'>$row[id]</td>";
												echo "<td class='reportTableCell'>$row[login]</td>";
												echo "<td class='reportTableCell'>$row[password]</td>";
												if (empty($row['familiya']) and empty($row['imya']) and empty($row['otchestvo'])) {
													echo "<td class='reportTableCell'><font color='grey'>Нет данных</font></td>";
												} else {
													echo "<td class='reportTableCell'>$row[familiya] $row[imya] $row[otchestvo]</td>";
												}
												echo "<td class='reportTableCell'>$row[grupa]</td>";
												if ($row['admin'] == 0) {
													echo "<td class='reportTableCell'>Читатель</td>";
												} else if ($row['admin'] == 1) {
													echo "<td class='reportTableCell'>Администратор</td>";
												} else if ($row['admin'] == 2) {
													echo "<td class='reportTableCell'>Заблокирован</td>";
												}
												echo "<td class='reportTableCell'>$row[reg_date]</td>";
												echo "<td class='reportTableCell'>$row[last_visit]</td>";
												echo "<td class='reportTableCell'>$row[visits]</td>";
								            echo "</tr>";
									    }
								    echo "</table>";
								} 
								else 
								{
									echo "Произошла ошибка";
								}
								echo '<button onclick="javascript:history.back();﻿">Назад</button>';
							}
						}	
					?>
				</div>
			</div>
			</div>
		</div>
	</body>
</html>