<?php
	$connection = mysqli_connect( 'vat-el-lib.local', 'root',  '', 'vat');
	$connection->query ("SET NAMES 'utf8'");
	$select_db = mysqli_select_db ($connection, 'vat');
	session_start();
	if(!$_SESSION['login']) {
		header("Location: Login.php");
		exit();
	}
	if(isset($_GET['exit'])) {
		session_destroy(); 
		header('Location: Login.php');
		exit;
	}
	function ifAdminShowButton($connection) {
		$username = $_SESSION['login'];
		$admin = ("SELECT admin FROM loginparol WHERE login='$username'");
		$result = $connection->query($admin);
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()) {
				$kek = $row["admin"] ;
			}
		}
		if ($kek == 1) {
			echo "<li class='NButton'><a href='AdminPage.php' class='NBLink'>Панель администрирования</a></li>";
		}
	}
?>