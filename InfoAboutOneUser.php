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
	$UserID = $_GET['userid'];
	$getAllUserData = $connection->query("SELECT * FROM loginparol")
	// чета с одной книгой 
	$booklist = array();
	$getBooksID = $connection->query("SELECT BookID FROM users_and_books WHERE id = '$UserID'");
	while ($bookid = $getBooksID->fetch_assoc()) 
	{
		array_push($booklist, $bookid['BookID']);	
	}
	if (!empty($booklist)) 
	{
		echo "<td class='reportTableCell'>";
			foreach ($booklist as $key => $valueBookID) 
			{
				$getBook = $connection->query("SELECT * FROM books WHERE BookID = '$valueBookID'");
				$rowsOfGetBook = mysqli_num_rows($getBook);
				for ($k = 0 ; $k < $rowsOfGetBook ; ++$k) 
				{
					$rowOfGetBook = mysqli_fetch_row($getBook);
					echo "$rowOfGetBook[1], $rowOfGetBook[2] <br>";
				} 
			}
		echo "</td>";
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
				<h1 class="AdminStart">Информация о пользователе <? echo $UserID ?></h1>
			</div>