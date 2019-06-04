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
				<h1 class="AdminStart">Информация о пользователях</h1>
				<form method="GET" action="InfoAboutUsers.php">
					<div class="SearchInReport">
						<input type="text" class="TextInput HalfWidth" name="sql-zapros" placeholder="Введите группу" autocomplete="off" >
						<input type="submit" name="otpravit-sql-zapros" value="Отправить">
					</div>
				</form>
				<br>
				<?php 
					if (isset($_GET['otpravit-sql-zapros']) and !empty($_GET['sql-zapros'])) {
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
										// $booklist = array();
										// $getBooksID = $connection->query("SELECT BookID FROM users_and_books WHERE id = '$row[id]'");
										// while ($bookid = $getBooksID->fetch_assoc()) 
										// {
										// 	array_push($booklist, $bookid['BookID']);	
										// }
										// if (!empty($booklist)) {
										// 	echo "<td class='reportTableCell'>";
										// 	foreach ($booklist as $key => $valueBookID) 
										// 	{
										// 		$getBook = $connection->query("SELECT * FROM books WHERE BookID = '$valueBookID'");
										// 		$rowsOfGetBook = mysqli_num_rows($getBook);
										// 			for ($k = 0 ; $k < $rowsOfGetBook ; ++$k) 
			       //                                  {
			       //                                  	$rowOfGetBook = mysqli_fetch_row($getBook);
				      //                                   echo "$rowOfGetBook[1], $rowOfGetBook[2] <br>";
										// 			} 
										// 	}
										// 	echo "</td>";
										// }
						            echo "</tr>";
							    }
						    echo "</table>";
						} 
						else 
						{
							echo "Произошла ошибка";
						}
					} 
					else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros'])) 
					{
						echo "Введите запрос!";
					} 
					else if (!isset($_GET['otpravit-sql-zapros'])) 
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
										// $booklist = array();
										// $getBooksID = $connection->query("SELECT BookID FROM users_and_books WHERE id = '$row[id]'");
										// while ($bookid = $getBooksID->fetch_assoc()) 
										// {
										// 	array_push($booklist, $bookid['BookID']);	
										// }
										// if (!empty($booklist)) {
										// 	echo "<td class='reportTableCell'>";
										// 	foreach ($booklist as $key => $valueBookID) 
										// 	{
										// 		$getBook = $connection->query("SELECT * FROM books WHERE BookID = '$valueBookID'");
										// 		$rowsOfGetBook = mysqli_num_rows($getBook);
										// 			for ($k = 0 ; $k < $rowsOfGetBook ; ++$k) 
										// 			{
										// 				$rowOfGetBook = mysqli_fetch_row($getBook);
										// 				echo "$rowOfGetBook[1], $rowOfGetBook[2] <br>";
										// 			} 
										// 	}
										// 	echo "</td>";
										// }
						            echo "</tr>";
							    }
						    echo "</table>";
						} 
						else 
						{
							echo "Произошла ошибка";
						}
					}		
				?>

			</div>
		</div>
	</body>
	<script src="Js/JQuerry.js" type="text/javascript"></script>
	<script src="Js/AddOneMore.js" type="text/javascript"></script>
</html>