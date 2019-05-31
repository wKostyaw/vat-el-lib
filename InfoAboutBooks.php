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
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h1 class="AdminStart">Информация о книгах</h1>
				<form method="GET" action="InfoAboutBooks.php">
					<input type="text" name="sql-zapros" placeholder="Введите автора или категорию" autocomplete="off">
					<input type="submit" name="otpravit-sql-zapros" value="Отправить">
				</form>
				<br>
				<?php 
					if (isset($_GET['otpravit-sql-zapros']) and !empty($_GET['sql-zapros']))
					{
						$q = $_GET['sql-zapros'];
						if (iconv_strlen($q) < 3) 
						{
							echo "Слишком короткий поисковый запрос";
						} else if (iconv_strlen($q) > 128)
						{
							echo "Слишком длинный поисковый запрос";
						} else 
						{
							$sql = $connection->query("SELECT * FROM authors WHERE Name LIKE '%$q%'");
							$rows = mysqli_num_rows($sql);
	                        if ($rows > 0 )
	                        {
	                        	$GetAuthorID = ("SELECT AuthorID FROM authors WHERE Name LIKE '%$q%'");
	                            $result1 = $connection->query ($GetAuthorID);
	                        	$authorslist = array();
	                            if ($result1->num_rows > 0) {
	                                while ($row = $result1->fetch_assoc()) 
	                                {
	                            		$AuthorID = $row["AuthorID"];
	                                    array_push($authorslist, $AuthorID);
	                                }
	                            }
	                            foreach ($authorslist as $key => $valueAuthorID) 
	                            {
	                            	$AuthorBooks = ("SELECT BookID FROM books_and_authors WHERE AuthorID LIKE '$valueAuthorID'");
	                                $result2 = $connection->query ($AuthorBooks);
	                                $bookslist = array();
	                                if ($result2->num_rows > 0) 
	                                {
	                                	while ($row = $result2->fetch_assoc())
	                                    {
	                                    	$BookID = $row['BookID'];
	                                        array_push($bookslist, $BookID);
	                                    }
	                                }
	                                echo "<table border='1'>"; 
							    	echo "<tr><th>id</th><th>Название книги</th><th>Год написания</th><th>Авторы</th><th>Категории</th><th>Описание</th><th>Путь к файлу</th><th>Путь к обложке</th></tr>";
	                                foreach ($bookslist as $key => $valueBookID) 
	                                {
		                                $book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID'");
		                                $rows = mysqli_num_rows($book);
		                                for ($i = 0 ; $i < $rows ; ++$i) 
		                                {
		                                	$row = mysqli_fetch_row($book);
		                                	echo "<tr>";
									            for ($j = 0 ; $j < 6 ; ++$j) 
									            {
									            	if ($j == 2) 
									            	{
									            		echo "<td>". $row[$j]. "</td>";
									            		$AuthorName = array();
				          								$whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[0]'");
									                    $result = $connection->query ($whoisauthor);
									                    if ($result->num_rows > 0) 
									                    {
									                        while ($rowauthor = $result->fetch_assoc())
									                        {
									                            $AuthorID = $rowauthor["AuthorID"];
									                            $whoisauthor2 = ("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
									                            $result2 = $connection->query ($whoisauthor2);
									                            if ($result2->num_rows > 0) 
									                            {
									                                while ($rowauthor2 = $result2->fetch_assoc())
									                                {
									                                    array_push($AuthorName, $rowauthor2["Name"]);
									                                }
									                            } 
									                            else 
									                            {
									                                $AuthorName = 'Авторов нет';
									                            }
									                        }
									                    } else 
									                    {
									                        $AuthorID = 'Авторов нет';
									                    }
									                    echo "<td>";
									                    foreach ($AuthorName as $key => $value) 
									                    { 
									                        if($value == end($AuthorName)) 
									                        {
									                            echo $value;
									                        }
									                        else 
									                        {
									                            echo $value . ", ";
									                        }
									                    }
									                    unset($key);
				                    					echo "</td>";
				                    					$Categories = array();
									                    $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[0]'");
									                    $result = $connection->query ($whatiscategory);
									                    if ($result->num_rows > 0) 
									                    {
									                        while ($rowcategory = $result->fetch_assoc())
									                        {
									                            $CategoryID = $rowcategory["CategoryID"];
									                            $whatiscategory2 = ("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
									                            $result2 = $connection->query ($whatiscategory2);
									                            if ($result2->num_rows > 0) 
									                            {
									                                while ($rowcategory2 = $result2->fetch_assoc())
									                                {
									                                    array_push($Categories, $rowcategory2["Category"]);
									                                }
									                            } 
									                            else 
									                            {
									                                $Categories = 'Категорий нет';
									                            }
									                        }
									                    } 
									                    else 
									                    {
									                        $CategoryID = 'Категорий нет';
									                    }
									                    echo "<td>";
									                    foreach ($Categories as $key => $value) 
									                    { 
									                        if($value == end($Categories)) 
									                        {
									                            echo $value;
									                        }
									                        else 
									                        {
									                            echo $value . ", ";
									                        }
									                    }
									                    unset($key);
									                    echo "</td>";
				                    					
									            	} else 
									            	{
										            	echo "<td>". $row[$j]. "</td>";
									            	}
									            } 
									        echo "</tr>";
		                                }
	                            	} 
	                            	echo "</table>";
	                            }
	                        }
	                        $sql = $connection->query("SELECT * FROM categories WHERE Category LIKE '%$q%'");
	                        $rows = mysqli_num_rows($sql);
	                        if ($rows > 0 )
	                        {
	                         	$GetCategoryID = ("SELECT CategoryID FROM categories WHERE Category LIKE '%$q%'");
	                            $result1 = $connection->query ($GetCategoryID);
	                            $categorieslist = array();
	                            if ($result1->num_rows > 0) 
	                            {
	                            	while ($row = $result1->fetch_assoc()) 
	                                {
	                                	$CategoryID = $row["CategoryID"];
	                                    array_push($categorieslist, $CategoryID);
	                                }
	                            }
	                            foreach ($categorieslist as $key => $valueCategoryID) 
	                            {
	                            	$CategoryBooks = ("SELECT BookID FROM books_and_categories WHERE CategoryID LIKE '$valueCategoryID'");
	                                $result2 = $connection->query ($CategoryBooks);
	                                $bookslist = array();
	                                if ($result2->num_rows > 0) 
	                                {
	                                	while ($row = $result2->fetch_assoc())
	                                    {
	                                    	$BookID = $row['BookID'];
	                                        array_push($bookslist, $BookID);
									    }
	                                }
	                                echo "<table border='1'>"; 
							    	echo "<tr><th>id</th><th>Название книги</th><th>Год написания</th><th>Авторы</th><th>Категории</th><th>Описание</th><th>Путь к файлу</th><th>Путь к обложке</th></tr>";
	                                foreach ($bookslist as $key => $valueBookID) 
	                                {
	                                	$book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID'");
	                                    $rows = mysqli_num_rows($book);
	                                    for ($i = 0 ; $i < $rows ; ++$i) 
	                                    {
	                                    	$row = mysqli_fetch_row($book);
	                                        echo "<tr>";
									            for ($j = 0 ; $j < 6 ; ++$j) 
									            {
									            	if ($j == 2) 
									            	{
									            		echo "<td>". $row[$j]. "</td>";
									            		$AuthorName = array();
				          								$whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[0]'");
									                    $result = $connection->query ($whoisauthor);
									                    if ($result->num_rows > 0) 
									                    {
									                        while ($rowauthor = $result->fetch_assoc())
									                        {
									                            $AuthorID = $rowauthor["AuthorID"];
									                            $whoisauthor2 = ("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
									                            $result2 = $connection->query ($whoisauthor2);
									                            if ($result2->num_rows > 0) 
									                            {
									                                while ($rowauthor2 = $result2->fetch_assoc())
									                                {
									                                    array_push($AuthorName, $rowauthor2["Name"]);
									                                }
									                            } 
									                            else 
									                            {
									                                $AuthorName = 'Авторов нет';
									                            }
									                        }
									                    } else 
									                    {
									                        $AuthorID = 'Авторов нет';
									                    }
									                    echo "<td>";
									                    foreach ($AuthorName as $key => $value) 
									                    { 
									                        if($value == end($AuthorName)) 
									                        {
									                            echo $value;
									                        }
									                        else 
									                        {
									                            echo $value . ", ";
									                        }
									                    }
									                    unset($key);
				                    					echo "</td>";
				                    					$Categories = array();
									                    $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[0]'");
									                    $result = $connection->query ($whatiscategory);
									                    if ($result->num_rows > 0) 
									                    {
									                        while ($rowcategory = $result->fetch_assoc())
									                        {
									                            $CategoryID = $rowcategory["CategoryID"];
									                            $whatiscategory2 = ("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
									                            $result2 = $connection->query ($whatiscategory2);
									                            if ($result2->num_rows > 0) 
									                            {
									                                while ($rowcategory2 = $result2->fetch_assoc())
									                                {
									                                    array_push($Categories, $rowcategory2["Category"]);
									                                }
									                            } 
									                            else 
									                            {
									                                $Categories = 'Категорий нет';
									                            }
									                        }
									                    } 
									                    else 
									                    {
									                        $CategoryID = 'Категорий нет';
									                    }
									                    echo "<td>";
									                    foreach ($Categories as $key => $value) 
									                    { 
									                        if($value == end($Categories)) 
									                        {
									                            echo $value;
									                        }
									                        else 
									                        {
									                            echo $value . ", ";
									                        }
									                    }
									                    unset($key);
									                    echo "</td>";
				                    					
									            	} else 
									            	{
										            	echo "<td>". $row[$j]. "</td>";
									            	}
									            } 
									        echo "</tr>";
	                                    } 
	                                }
	                            } 
	                        }
						}
							
					} else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros']))
					{
						echo "Введите запрос!";	
					} else if (!isset($_GET['otpravit-sql-zapros'])) 
					{
						$sql = $connection->query("SELECT * FROM books ORDER BY BookID");
						if($sql)
						{
						    $rows = mysqli_num_rows($sql); // количество полученных строк
						    echo "<table border='1'>"; 
						    echo "<tr><th>id</th><th>Название книги</th><th>Год написания</th><th>Авторы</th><th>Категории</th><th>Описание</th><th>Путь к файлу</th><th>Путь к обложке</th></tr>";
						    for ($i = 0; $i < $rows; $i++)
						    {
						    	$row = mysqli_fetch_row($sql);
						    	echo "<tr>";
						            for ($j = 0 ; $j < 6 ; ++$j) 
						            {
						            	if ($j == 2) 
						            	{
						            		echo "<td>". $row[$j]. "</td>";
						            		$AuthorName = array();
	          								$whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[0]'");
						                    $result = $connection->query ($whoisauthor);
						                    if ($result->num_rows > 0) 
						                    {
						                        while ($rowauthor = $result->fetch_assoc())
						                        {
						                            $AuthorID = $rowauthor["AuthorID"];
						                            $whoisauthor2 = ("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
						                            $result2 = $connection->query ($whoisauthor2);
						                            if ($result2->num_rows > 0) 
						                            {
						                                while ($rowauthor2 = $result2->fetch_assoc())
						                                {
						                                    array_push($AuthorName, $rowauthor2["Name"]);
						                                }
						                            } 
						                            else 
						                            {
						                                $AuthorName = 'Авторов нет';
						                            }
						                        }
						                    } else 
						                    {
						                        $AuthorID = 'Авторов нет';
						                    }
						                    echo "<td>";
						                    foreach ($AuthorName as $key => $value) 
						                    { 
						                        if($value == end($AuthorName)) 
						                        {
						                            echo $value;
						                        }
						                        else 
						                        {
						                            echo $value . ", ";
						                        }
						                    }
						                    unset($key);
	                    					echo "</td>";
	                    					$Categories = array();
						                    $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[0]'");
						                    $result = $connection->query ($whatiscategory);
						                    if ($result->num_rows > 0) 
						                    {
						                        while ($rowcategory = $result->fetch_assoc())
						                        {
						                            $CategoryID = $rowcategory["CategoryID"];
						                            $whatiscategory2 = ("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
						                            $result2 = $connection->query ($whatiscategory2);
						                            if ($result2->num_rows > 0) 
						                            {
						                                while ($rowcategory2 = $result2->fetch_assoc())
						                                {
						                                    array_push($Categories, $rowcategory2["Category"]);
						                                }
						                            } 
						                            else 
						                            {
						                                $Categories = 'Категорий нет';
						                            }
						                        }
						                    } 
						                    else 
						                    {
						                        $CategoryID = 'Категорий нет';
						                    }
						                    echo "<td>";
						                    foreach ($Categories as $key => $value) 
						                    { 
						                        if($value == end($Categories)) 
						                        {
						                            echo $value;
						                        }
						                        else 
						                        {
						                            echo $value . ", ";
						                        }
						                    }
						                    unset($key);
						                    echo "</td>";
	                    					
						            	} else 
						            	{
							            	echo "<td>". $row[$j]. "</td>";
						            	}
						            } 
						        echo "</tr>";
						    }
						    echo "</table>";
						} else 
						{
							echo "Не удалось получить данные из базы данных";
						}
					} else {
						echo "Ничего не найдено";
					}
				?>

			</div>
		</div>
	</body>
	<script src="Js/JQuerry.js" type="text/javascript"></script>
</html>