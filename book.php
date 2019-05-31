<?php 
	include_once "auth.php";
?>
<?php
	// поиск соответствий в БД
	if (isset($_POST['search'])) 
	{
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q = $connection->real_escape_string($_POST['q']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%'");
		$sql1 = $connection->query("SELECT BookName FROM books WHERE BookName LIKE '%$q%'");
		$sql2 = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q%'");
		if ($sql->num_rows > 0 or  $sql1->num_rows > 0 or  $sql2->num_rows > 0) 
		{
			$responseAuthors = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'>" . $data['Name'] . "</li>";
				while ($data = $sql1->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'>" . $data['BookName'] . "</li>";
				while ($data = $sql2->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'>" . $data['Category'] . "</li>";
			$responseAuthors .= "</ul>";
		}
		exit($responseAuthors);
	}
	$bookinfo = $_GET['BookInfo'];
	if (isset($_POST['save'])) 
    {	
    	$bookid = $_POST['save'];
        $username = $_SESSION['login'];
        $getUserID = $connection->query("SELECT id FROM loginparol WHERE login = '$username'");
        while ($rowUserID = $getUserID->fetch_assoc()) 
        {
            $UserID = $rowUserID["id"];
        }
        $isLinkExist = $connection->query("SELECT * FROM users_and_books WHERE id = '$UserID' and BookID = '$bookid'");
        if ($isLinkExist->num_rows == 0 ) 
        {
            $addLinkBetweenUserAndBook = $connection->query("INSERT INTO users_and_books (id, BookID) VALUES ('$UserID', '$bookid')");
            if ($addLinkBetweenUserAndBook) {
            	echo "Сохранено ";
            } else {
            	echo "Не сохранено ";
            }
        } else {
        	echo "Уже сохранена";
        }
        exit($_POST['save']);
    }
    if (isset($_POST['delete'])) 
    {	
    	$bookid = $_POST['delete'];
        $username = $_SESSION['login'];
        $getUserID = $connection->query("SELECT id FROM loginparol WHERE login = '$username'");
        while ($rowUserID = $getUserID->fetch_assoc()) 
        {
            $UserID = $rowUserID["id"];
        }
        $isLinkExist = $connection->query("SELECT * FROM users_and_books WHERE id = '$UserID' and BookID = '$bookid'");
        if ($isLinkExist->num_rows > 0 ) 
        {
            $deleteLinkBetweenUserAndBook = $connection->query("DELETE FROM users_and_books  WHERE id = '$UserID' and BookID = '$bookid'");
            if ($deleteLinkBetweenUserAndBook) {
            	echo "Удалено ";
            } else {
            	echo "Не удалено ";
            }
        } else {
        	echo "Уже удалена";
        }
        exit($_POST['delete']);
    }
?>
<!doctype HTML>
<html>
	<meta charset="utf-8">
	<head>
		
		<link rel="stylesheet" type="text/css" href="Css/style.css">
		<link rel="stylesheet" type="text/css" href="Css/BookPageStyle.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script src="Js/Script.js" type="text/javascript"></script>
		<script>
			$(document).on('click', '.savebook', function () {			
				var SavedBookID = $(this).attr('id'),
				SavedBookID = SavedBookID.replace(/[^\d]/g, '');
				$.ajax (
				{
					url: 'book.php',
					method: 'POST',
					data: {
						save: SavedBookID
					},
					success: function (data) {
						alert(data);
					},
					dataType: 'text'
				}
				);
			});
			$(document).on('click', '.deletebook', function () {			
				var deleteBookID = $(this).attr('id'),
				deleteBookID = deleteBookID.replace(/[^\d]/g, '');
				$.ajax (
				{
					url: 'book.php',
					method: 'POST',
					data: {
						delete: deleteBookID
					},
					success: function (data) {
						alert(data);
					},
					dataType: 'text'
				}
				);
			});
		</script>
	</head>
	<body>
		<div class="SiteHeader">
			<div class="HeaderContent">
				<img src="Img/WorkInProgress.png" class="Logo">
				<p class="SiteName">Электронная библиотека ВАТ имени В. П. Чкалова</p>
			</div>
		</div>
			<div class="SecondHeaderNotSticky" id="SecondHeader">
			<div class="NCentered">
					<ul class="Navigation">
						<li class="NButton"><a href="MainPage.php" class="NBLink">Главная</a></li>
						<li class="NButton"><a href="Saved.php" class="NBLink">Сохраненное</a></li>
						<li class="NButton"><a href="Authors.php" class="NBLink">Авторы</a></li>
						<li class="NButton"><a href="Categories.php" class="NBLink">Категории</a></li>
						<?php 
							$username = $_SESSION['login'];
							$admin = ("SELECT admin FROM loginparol WHERE login='$username'");
							$result = $connection->query ($admin);
							if ($result->num_rows > 0) {
								while ($row = $result->fetch_assoc()) {
									$kek = $row["admin"] ;
								}
							}
							if ($kek == 1) {
								echo "<li class='NButton'><a href='adminpage.php' class='NBLink'>&#128081 Панель администрирования &#128081</a></li>";
							}
						?> 
					</ul>
				<button type="button" Class="OpenSearch SButton" onclick="SearchVisible()">
					<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
						<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
					</svg>
				</button>
				<form class="SearchForm" id="SearchForm" name="Search" method="GET" action="search.php" style="display: none;">
					<div class="SBorder">
						<div class="SearchBook">
						<button type="submit" Class="StartSearch SButton" formmethod="GET">
							<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
								<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
							</svg>
						</button>
							<input type="search" class="SearchBookName" id="SearchBox" name="SearchAll" placeholder="Введите название книги">
								<script type="text/javascript">
									$(document).ready(),function () {
										$("#SearchBox").keyup(function() {
											var query = $("#SearchBox").val();							
											if (query.length > 0) {
												$.ajax (
													{
														url: 'MainPage.php',
														method: 'POST',
														data: {
															search: 1,
															q: query
														},
														success: function (data) {
														$("#responseAuthors").html(data);
													},
														dataType: 'text'
													}
												);			
											}
										});
	
	
										$(document).on('click', '#li0', function (){
											var author = $(this).text();
											$("#SearchBox").val(author);
											$("#responseAuthors").html("");
										});
									}();
								</script>
								
							<button type="button" Class="CloseSearch SButton" onclick="SearchHide()">
								<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 192 192">
									<path d="M45.65625,34.34375l-11.3125,11.3125l50.34375,50.34375l-50.34375,50.34375l11.3125,11.3125l50.34375,-50.34375l50.34375,50.34375l11.3125,-11.3125l-50.34375,-50.34375l50.34375,-50.34375l-11.3125,-11.3125l-50.34375,50.34375z"></path>
								</svg>
							</button>
						</div>
						<div id="responseAuthors" class="HintBox"></div>
					</div>
				</form>
				<button class="exitButton" onclick="document.location.replace('?exit');">Выход</button>
			</div>
			</div>
			<div class="SiteWrapper">
				<div class="SiteContent">
				<div class="bookPage">
					<!-- ВЫВОД ИНФОРМАЦИИ О КНИГЕ -->
					<?php 
						$sql4 = $connection->query("SELECT * FROM books WHERE BookID LIKE '$bookinfo'");
						$rows = mysqli_num_rows($sql4);
						for ($i = 0 ; $i < $rows ; ++$i) 
					    {
					    	$row = mysqli_fetch_row($sql4);
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
                                    } else 
                                    {
                                        $AuthorName = 'Авторов нет';
                                    }
                                }
                                } else 
                                {
                                    $AuthorID = 'Авторов нет';
                                }
					    }
					    echo "<title>" . $row[1] . "</title>";
					    echo "<div class='coverAndButtons'>";
							echo "<form method='POST' action='book.php'>";
								echo "<img src='" . $row[5] . "' class='bookCover'>";
								echo '<a href="#bookFile"><button type="button" class="bookButton readbook">Читать</button></a>';
								echo "<input type='button' class='bookButton savebook' id='savebook".$row[0]."' value='Сохранить'>";
								echo "<input type='button' class='bookButton deletebook' id='deletebook".$row[0]."' value='Удалить'>";
							echo "</form>";
						echo "</div>";
						echo "<div class='bookInfo'>";
							echo "<p class='bookName'>" . $row[1] ." </p>";
							echo "<p class='bookInfoPoint'><b>Год: </b>" . $row[2] . "</p>";
							echo "<p class='bookInfoPoint'><b>Автор(ы): </b>";
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
                            echo "</p>";
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
                                        } else 
                                        {
                                            $Categories = 'Авторов нет';
                                        }
                                }
                            } else 
                            {
                                $CategoryID = 'Авторов нет';
                            }
							echo "<p class='bookInfoPoint'><b>Категория(и): </b>";
							foreach ($Categories as $key => $value) 
                            { 
                                if($value == end($Categories)) 
                                {
                                    echo $value;
                                } else 
                                {
                                    echo $value . ", ";
                            	}
                            }
                            unset($key);
							echo "</p>";
							echo "<p class='bookInfoPoint'><b>Краткое описание: </b>". $row[3] ." </p>";
						echo "</div>";
					echo "</div>";
					echo "<embed id='bookFile' src='" . $row[4] . "' width='100%' vspace='10' style='height: 98vh;'>";
				 ?>
				</div>
			</div>
		<div class="SiteFooter">
			<div class="FooterContent">
				<p class="Copyright">Сайт разработан в качестве дипломной работы студентами ВАТ имени В. П. Чкалова</p>
			</div>
		</div>
	</body>
</html>