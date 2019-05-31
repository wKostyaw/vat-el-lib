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
		<script type="text/javascript">
	    $(document).ready(),function(){
	    	$(document).on('click', '.knigi', function(){
	    		$(".kniga" ).toggle( display );
	    	})
	    }
	    </script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<div class="LogoContainer">
					<img src="Img/WorkInProgress.png" class="Logo">
				</div>
					<ul class="AdminLinks">
						<li class="AdminLinkBox"><a href="mainpage.php" class="AdminLink">На сайт</a></li>
						<li class="AdminLinkBox"><a href="AddUserForm.php" class="AdminLink">Добавить пользователя</a></li>
						<li class="AdminLinkBox"><a href="ChangeUser.php" class="AdminLink">Изменить/удалить пользователя</a></li>
						<li class="AdminLinkBox"><a href="AddBookForm.php" class="AdminLink">Добавить книгу</a></li>
						<li class="AdminLinkBox"><a href="ChangeBook.php" class="AdminLink">Изменить/удалить книгу</a></li>
						<li class="AdminLinkBox"><a href="InfoAboutUsers.php" class="AdminLink">Информация о пользователях</a></li>
						<li class="AdminLinkBox"><a href="InfoAboutBooks.php" class="AdminLink">Информация о книгах</a></li>
						<li class="AdminLinkBox"><a href="CustomizeSlider.php" class="AdminLink">Настройка главной страницы</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace('?exit');">Выход</a></li>
					</ul>
			</div>
			<div class="Option">
				<h1 class="AdminStart">Информация о пользователях</h1>
				<form method="GET" action="InfoAboutUsers.php">
					<input type="text" name="sql-zapros" placeholder="Введите группу" autocomplete="off" >
					<input type="submit" name="otpravit-sql-zapros" value="Отправить">
				</form>
				<br>
				<?php 
					if (isset($_GET['otpravit-sql-zapros']) and !empty($_GET['sql-zapros'])) {
						$q = $_GET['sql-zapros'];
						$sql = $connection->query("SELECT * FROM loginparol WHERE grupa LIKE '%$q%' ORDER BY id");
						if($sql)
						{
						    $rows = mysqli_num_rows($sql); // количество полученных строк
						    echo "<table border='1'>"; 
						    echo "<tr><th>id</th><th>Логин</th><th>Пароль</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Группа</th><th>Права пользователя</th></tr>";
						    for ($i = 0; $i < $rows; $i++)
						    {
						    	$row = mysqli_fetch_row($sql);
								echo "<tr>";
						        for ($j = 0 ; $j < 8 ; ++$j) 
						        {
									$data = $row[$j];
									if ($data == '') 
									{
										echo "<td><p><font color='LightGray'>Нет данных</font></p></td>";
									} 
									else if ($j == 7)
									{	
										$data1 = $row[$j];
										if ($data1 == '0') 
										{
											echo "<td>Читатель</td>";
										}
										else if ($data1 == '1')
										{
											echo "<td>Администратор</td>";
										}
										else if ($data1 == '2')
										{
											echo "<td>Заблокирован</td>";
										}
									}
									else 
									{
										echo  "<td>". $row[$j] . "</td>";
									}
								}
					            echo "</tr>";
						    }
						    echo "</table>";
						} 
						else 
						{
							echo "Произошла ошибка";
						}
					} else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros'])) {
						echo "Введите запрос!";
					} else if (!isset($_GET['otpravit-sql-zapros'])) {
						$sql = $connection->query("SELECT * FROM loginparol ORDER BY id");
						if($sql)
						{
						    $rows = mysqli_num_rows($sql); // количество полученных строк
						    echo "<table border='1'>"; 
						    echo "<tr><th>id</th><th>Логин</th><th>Пароль</th><th>Имя</th><th>Фамилия</th><th>Отчество</th><th>Группа</th><th>Права пользователя</th></tr>";
						    for ($i = 0; $i < $rows; $i++)
						    {
						    	$row = mysqli_fetch_row($sql);
								echo "<tr>";
							        for ($j = 0 ; $j < 8 ; ++$j) 
							        {

										$data = $row[$j];
										if ($data == '') 
										{
											echo "<td><p><font color='LightGray'>Нет данных</font></p></td>";
										} 
										else if ($j == 7)
										{	
											$data1 = $row[$j];
											if ($data1 == '0') 
											{
												echo "<td>Читатель</td>";
											}
											else if ($data1 == '1')
											{
												echo "<td>Администратор</td>";
											}
											else if ($data1 == '2')
											{
												echo "<td>Заблокирован</td>";
											}
										}
										else 
										{
											echo  "<td>". $row[$j] . "</td>";
										}
									}
									
									$booklist = array();
									$getBooksID = $connection->query("SELECT BookID FROM users_and_books WHERE id = '$row[0]'");
									while ($bookid = $getBooksID->fetch_assoc()) 
									{
										array_push($booklist, $bookid['BookID']);	
									}
									if (!empty($booklist)) {
										echo "<tr class='knigi'><td colspan='8' >Книги на полке пользователя:</td></tr>";
										foreach ($booklist as $key => $valueBookID) 
										{
											$getBook = $connection->query("SELECT * FROM books WHERE BookID = '$valueBookID'");
											$rowsOfGetBook = mysqli_num_rows($getBook);

											for ($k = 0 ; $k < $rowsOfGetBook ; ++$k) 
	                                        {
	                                        	$rowOfGetBook = mysqli_fetch_row($getBook);
	                                        	echo "<tr class='kniga'>";
	                                        		echo "<td border='none'></td>";
		                                            echo "<td colspan='7'>$rowOfGetBook[1], $rowOfGetBook[2]</td>";
	                                            echo "</tr>";
											} 
										}
									}
										
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
</html>