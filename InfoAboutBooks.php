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
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h2 class="AdminStart MainHeader">Информация о книгах</h2>
				<form method="GET" action="InfoAboutBooks.php">
					<div class="SearchInReport">
						<input type="text" class="TextInput HalfWidth" name="sql-zapros" placeholder="Введите автора или категорию" autocomplete="off">
						<input type="submit" name="otpravit-sql-zapros" value="Отправить">
					</div>
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
	                        if ($sql)
	                        {	
	                        	$rowsAuthors = mysqli_num_rows($sql);
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
	                                echo "<table class='reportTable'>"; 
							    	echo "<tr class='reportTableHeaderRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Название книги</th><th class='reportTableHeaderCell'>Год написания</th><th class='reportTableHeaderCell'>Авторы</th><th class='reportTableHeaderCell'>Категории</th><th class='reportTableHeaderCell'>Описание</th><th class='reportTableHeaderCell'>Количество обращений</th></tr>";
	                                foreach ($bookslist as $key => $valueBookID) 
	                                {
		                                $book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID' ORDER BY BookID");
		                                $rowsBooksAuthors = mysqli_num_rows($book);
		                                for ($i = 0 ; $i < $rowsBooksAuthors ; ++$i) 
		                                {
		                                	$row = mysqli_fetch_assoc($book);
		                                	echo "<tr class='reportTableRow'>";
									         	echo "<td class='reportTableCell'>$row[BookID]</td>";
									         	echo "<td class='reportTableCell'>$row[BookName]</td>";
									         	echo "<td class='reportTableCell'>$row[BookYear]</td>";
									         	$AuthorName = array();
				          						$whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[BookID]'");
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
									            } 
									            else 
									            {
									            	$AuthorID = 'Авторов нет';
									            }
									            echo "<td class='reportTableCell'>";
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
									            $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[BookID]'");
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
									            echo "<td class='reportTableCell'>";
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
									         	echo "<td class='reportTableCell'>$row[Description]</td>";
									         	echo "<td class='reportTableCell'>$row[reading]</td>";
									    	echo "</tr>";
		                                }
	                            	} 
	                            	echo "</table>";
	                            }
	                        }
	                        $sql = $connection->query("SELECT * FROM categories WHERE Category LIKE '%$q%'");
	                        if ($sql)
	                        {	
	                        	$rowsCategories = mysqli_num_rows($sql);
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
	                                echo "<table class='reportTable'>"; 
							    	echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Название книги</th><th class='reportTableHeaderCell'>Год написания</th><th class='reportTableHeaderCell'>Авторы</th><th class='reportTableHeaderCell'>Категории</th><th class='reportTableHeaderCell'>Описание</th><th class='reportTableHeaderCell'>Количество обращений</th></tr>";
	                                foreach ($bookslist as $key => $valueBookID) 
	                                {
	                                	$book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID'");
	                                    $rowsBooksCategories = mysqli_num_rows($book);
	                                    for ($i = 0 ; $i < $rowsBooksCategories ; ++$i) 
	                                    {
	                                    	$row = mysqli_fetch_assoc($book);
	                                        echo "<tr class='reportTableRow'>";
									         	echo "<td class='reportTableCell'>$row[BookID]</td>";
									         	echo "<td class='reportTableCell'>$row[BookName]</td>";
									         	echo "<td class='reportTableCell'>$row[BookYear]</td>";
									         	$AuthorName = array();
				          						$whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[BookID]'");
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
									            } 
									            else 
									            {
									            	$AuthorID = 'Авторов нет';
									            }
									            echo "<td class='reportTableCell'>";
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
									            $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[BookID]'");
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
									            echo "<td class='reportTableCell'>";
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
									         	echo "<td class='reportTableCell'>$row[Description]</td>";
									         	echo "<td class='reportTableCell'>$row[reading]</td>";
									    	echo "</tr>";
	                                    } 
	                                }
	                            } 
	                        }
						}	
					} 
					else if (isset($_GET['otpravit-sql-zapros']) and empty($_GET['sql-zapros']))
					{
						echo "Введите запрос!";	
					} 
					else if (!isset($_GET['otpravit-sql-zapros'])) 
					{
						$sql = $connection->query("SELECT * FROM books ORDER BY BookID");
						if($sql)
						{
						    $rows = mysqli_num_rows($sql); // количество полученных строк
						    echo "<span class='totalAmount'>Всего книг в библиотеке: ".$rows."<span>";
						    echo "<table class='reportTable'>"; 
						    echo "<tr class='reportTableRow'><th class='reportTableHeaderCell'>id</th><th class='reportTableHeaderCell'>Название книги</th><th class='reportTableHeaderCell'>Год написания</th><th class='reportTableHeaderCell'>Авторы</th><th class='reportTableHeaderCell'>Категории</th><th class='reportTableHeaderCell'>Описание</th><th class='reportTableHeaderCell'>Количество обращений</th></tr>";
						    for ($i = 0; $i < $rows; $i++)
							    {
							    	$row = mysqli_fetch_assoc($sql);
							    	echo "<tr class='reportTableRow'>";
							         	echo "<td class='reportTableCell'>$row[BookID]</td>";
							         	echo "<td class='reportTableCell'>$row[BookName]</td>";
							         	echo "<td class='reportTableCell'>$row[BookYear]</td>";
							         	$AuthorName = array();
		          						$whoisauthor = ("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$row[BookID]'");
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
							            } 
							            else 
							            {
							            	$AuthorID = 'Авторов нет';
							            }
							            echo "<td class='reportTableCell'>";
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
							            $whatiscategory = ("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$row[BookID]'");
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
							            echo "<td class='reportTableCell'>";
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
							         	echo "<td class='reportTableCell'>$row[Description]</td>";
							         	echo "<td class='reportTableCell'>$row[reading]</td>";
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
</html>