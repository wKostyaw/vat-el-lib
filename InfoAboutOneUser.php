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
	$UserID = $_GET['userid'];
	// получение всех данных юзера
	$getAllUserData = $connection->query("SELECT login FROM loginparol WHERE id='$UserID'");
	$rowUserData = mysqli_fetch_assoc($getAllUserData);
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
				<h2 class="AdminStart MainHeader">Дополнительная информация о пользователе <? echo $rowUserData['login'] ?></h2>
				<?php 
					echo '<p>Книги на полке пользователя:</p>';
					$booklist = array();
					$getBooksID = $connection->query("SELECT BookID FROM users_and_books WHERE id = '$UserID'");
					while ($bookid = $getBooksID->fetch_assoc()) 
					{
						array_push($booklist, $bookid['BookID']);	
					}
					if (!empty($booklist)) 
					{
						echo '<table border="1">';
							echo '<tr><th>Книга</th><th>Количество обращений</th><th>Время последнего обращения</th></tr>';
							foreach ($booklist as $key => $valueBookID) 
							{
								$getBook = $connection->query("SELECT * FROM books WHERE BookID = '$valueBookID'");
								$rowsOfGetBook = mysqli_num_rows($getBook);
								$savedBooks = $connection->query("SELECT * FROM users_and_books WHERE id='$UserID' and BookID = '$valueBookID'");
								$rowSavedBooks = mysqli_fetch_assoc($savedBooks);
								for ($k = 0 ; $k < $rowsOfGetBook ; ++$k) 
								{
									echo "<tr>";
										$rowOfGetBook = mysqli_fetch_assoc($getBook);
										echo "<td>$rowOfGetBook[BookName], $rowOfGetBook[BookYear]</td>";
										echo "<td>$rowSavedBooks[reading_by_user]</td>";
										echo "<td>$rowSavedBooks[last_time_reading]</td>";
									echo "</tr>";
								} 
							}
						echo '</table>';
					} 
					else 
					{
						echo '<p>Пользователь не добавил на свою книжную полку ни одной книги</p>';
					}
					echo '<p>Остальные книги:</p>';
					$booklist = array();
					$getBooksID = $connection->query("SELECT BookID FROM users_and_unsaved_books WHERE id = '$UserID'");
					while ($bookid = $getBooksID->fetch_assoc()) 
					{
						array_push($booklist, $bookid['BookID']);	
					}
					if (!empty($booklist)) 
					{	
						echo '<table border="1">';
							echo '<tr><th>Книга</th><th>Количество обращений</th><th>Время последнего обращения</th></tr>';
							foreach ($booklist as $key => $valueBookID) 
							{
								$getBook = $connection->query("SELECT * FROM books WHERE BookID = '$valueBookID'");
								$rowsOfGetBook = mysqli_num_rows($getBook);
								$savedBooks = $connection->query("SELECT * FROM users_and_unsaved_books WHERE id='$UserID' and BookID = '$valueBookID'");
								$rowSavedBooks = mysqli_fetch_assoc($savedBooks);
								for ($k = 0 ; $k < $rowsOfGetBook ; ++$k) 
								{
									echo "<tr>";
										$rowOfGetBook = mysqli_fetch_assoc($getBook);
										echo "<td>$rowOfGetBook[BookName], $rowOfGetBook[BookYear]</td>";
										echo "<td>$rowSavedBooks[reading_by_user]</td>";
										echo "<td>$rowSavedBooks[last_time_reading]</td>";
									echo "</tr>";
								} 
							}
						echo '</table>';	
					}
					else
					{
						echo '<p>Пользователь не обращался ещё ни к одной книге</p>';
					}
					echo '<a href="InfoAboutUsers.php"><button>Назад</button></a>';
				?>
			</div>
		</div>
	</body>
</html>