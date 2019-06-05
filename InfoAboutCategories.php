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
				<h2 class="AdminStart MainHeader">Информация о категориях</h2>
				<!-- <form method="GET" action="InfoAboutBooks.php">
					<input type="text" name="sql-zapros" placeholder="Введите автора или категорию" autocomplete="off">
					<input type="submit" name="otpravit-sql-zapros" value="Отправить">
				</form> -->
				<?php 
					$sql = $connection->query("SELECT * FROM categories");
					if ($sql) 
					{
						$rows = mysqli_num_rows($sql);
						echo "<table class='reportTable'>"; 
						    echo "<tr class='reportTableHeaderRow'><th class='reportTableHeaderCell'>Категория</th><th class='reportTableHeaderCell'>Книги</th></tr>";
							for ($i = 0; $i < $rows; $i++) 
							{ 
								$row = $sql->fetch_assoc();
								echo "<tr class='reportTableRow'>";
									echo "<td class='reportTableCell'>".$row['Category']."</td>";
									echo "<td class='reportTableCell'>";
									$sql2 = $connection->query("SELECT * FROM books_and_categories WHERE CategoryID = $row[CategoryID] ");
									$rows2 = mysqli_num_rows($sql2);
									for ($j = 0; $j < $rows2; $j++) 
									{ 
										$row2 = $sql2->fetch_assoc();
										$sql3 = $connection->query("SELECT * FROM books WHERE BookID = $row2[BookID]");
										$rows3 = mysqli_num_rows($sql3);
											echo "<table class='reportTable'>";
												for ($k = 0; $k < $rows3 ; $k++) { 
													$row3 = $sql3->fetch_assoc();
													echo "<tr class='reportTableRow'>$row3[BookName], $row3[BookYear]</tr>";
												}
											echo "</table>";
									}
									echo "</td>";
								echo "</tr>";
							}
						echo "</table>";
					}
				 ?>
			</div>
	</body>
	<script src="Js/JQuerry.js" type="text/javascript"></script>
	<script src="Js/AddOneMore.js" type="text/javascript"></script>
</html>