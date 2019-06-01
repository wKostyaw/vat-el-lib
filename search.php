<?php   
    include_once "auth.php";
 ?>
<?php
    // поиск соответствий в БД
    if (isset($_POST['search'])) {
        
        $connection = new mysqli('vat', 'root', '', 'vat');
        $q = $connection->real_escape_string($_POST['q']);
        $sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%'");
        $sql1 = $connection->query("SELECT BookName FROM books WHERE BookName LIKE '%$q%'");
        $sql2 = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q%'");
        if ($sql->num_rows > 0 or  $sql1->num_rows > 0 or  $sql2->num_rows > 0) {
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
    function izvekov_nauchilsya_uzat_funktsii($row, $connection, $BookIDabc) 
    {
        // echo "<form action='book.php' method='POST'>";
            echo "<div class='BookBlockItem' id='". $row[0] . "' name='divsavebook'>";
                echo "<div class='BookPreview'>";
                    echo "<a href='book.php?BookInfo=$row[0]'> <img src='" . $row[5] . "'> </a>";
                echo "</div>";
                echo "<div class='BookInfo'>";
                    //название книги
                    echo "<span class='BookInfoItem'>" . "Название: " . "<a href='book.php?BookInfo=$row[0]'>". $row[1] . "</a>" . "</span>";
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
                    echo "<span class='BookInfoItem'>" . "Авторы: ";
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
                    echo "</span>";
                    echo "<span class='BookInfoItem'>" . "Год: " . $row[2] . "</span>";
                    echo "<span class='BookInfoItem'>" . "Описание: " . $row[3] . "</span>";
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
                    echo "<span class='BookInfoItem'>" . "Категории: ";
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
                    echo "</span>";
                echo "</div>";
            echo "</div>";
            echo "<form method='POST'>";
                echo "<div class='BookBlockButtons'>";
                    echo '<a href="book.php?BookInfo=' . $row[0] . '#bookFile"><button type="button" class="BookBlockButton readBook">Читать</button></a>';
                    echo "<input type='button' class='BookBlockButton saveBook' id='savebook".$row[0]."' name='savebook[]' value='Сохранить к себе' >";
                    echo "<input type='button' class='BookBlockButton deleteBook' id='deletebook".$row[0]."' name='deletebook[]' value='Удалить от себя' >";
                echo "</div>";
            echo "</form>"; 

        // echo "</form>";    
    }
    // сохранение книги 
    if (isset($_POST['BookIDajax'])) 
    {
		$BookIDabc = $_POST['BookIDajax'];
        /*echo $BookIDabc . " kjk" ;*/
        $username = $_SESSION['login'];
        $getUserID = $connection->query("SELECT id FROM loginparol WHERE login = '$username'");
        while ($rowUserID = $getUserID->fetch_assoc()) 
        {
            $UserID = $rowUserID["id"];
        }
        $isLinkExist = $connection->query("SELECT * FROM users_and_books WHERE id = '$UserID' and BookID = '$BookIDabc'");
        if ($isLinkExist->num_rows == 0 ) 
        {
            $addLinkBetweenUserAndBook = $connection->query("INSERT INTO users_and_books (id, BookID) VALUES ('$UserID', '$BookIDabc')");
        }
		exit($BookIDabc);
    }
    if (isset($_POST['DeleteBookID'])) 
    {
        $DeleteBookID = $_POST['DeleteBookID'];
        // echo $DeleteBookID . " kjk" ;
        $username = $_SESSION['login'];
        $getUserID = $connection->query("SELECT id FROM loginparol WHERE login = '$username'");
        while ($rowUserID = $getUserID->fetch_assoc()) 
        {
            $UserID = $rowUserID["id"];
        }
        $isLinkExist = $connection->query("SELECT * FROM users_and_books WHERE id = '$UserID' and BookID = '$DeleteBookID'");
        if ($isLinkExist->num_rows > 0 ) 
        {
            $deleteLinkBetweenUserAndBook = $connection->query("DELETE FROM users_and_books  WHERE id = '$UserID' and BookID = '$DeleteBookID'");
        }
        exit($DeleteBookID);
    }
    
?>
<!doctype HTML>
<html>
    <meta charset="utf-8">
    <head>
        <title>Поиск</title>
        <link rel="stylesheet" type="text/css" href="Css/style.css">
        <link rel="stylesheet" type="text/css" href="Css/BooksList.css">
        <link rel="stylesheet" type="text/css" href="Css/PageNavigation.css">
        <script src="Js/JQuerry.js" type="text/javascript"></script>
        <script src="Js/Script.js" type="text/javascript"></script>
		<script>
			$(document).on('click', '.saveBook', function () {
				var SavedBookID = $(this).attr('id'),
				SavedBookID = SavedBookID.replace(/[^\d]/g, '');
				
				$.ajax (
				{
					url: 'search.php',
					method: 'POST',
					data: {
						BookIDajax: SavedBookID
					},
					success: function (data) {
						alert('Сохранено');
						// alert(data);
					},
					dataType: 'text'
				}
				);
				
			});
            $(document).on('click', '.deleteBook', function () {
                var DeleteBookID = $(this).attr('id'),
                DeleteBookID = DeleteBookID.replace(/[^\d]/g, '');
                
                $.ajax (
                {
                    url: 'search.php',
                    method: 'POST',
                    data: {
                        DeleteBookID: DeleteBookID
                    },
                    success: function (data) {
                        alert('Удалено');
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
            <div class="SecondHeader" id="SecondHeader">
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
								echo "<li class='NButton'><a href='AdminPage.php' class='NBLink'>&#128081 Панель администрирования &#128081</a></li>";
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
                    <div class="BookBlock">
                        <?php
                            $search_q = $_GET['SearchAll'];
                            $search_q = trim($search_q); 
                            $search_q = mysqli_real_escape_string($connection, $search_q);
                            $search_q = htmlspecialchars($search_q);
                            if ($search_q == '') 
                            {   
                                echo "Введите поисковой запрос!";
                            } 
                            else if (iconv_strlen($search_q) < 3)
                            { 
                                echo "Слишком короткий поисковый запрос";
                            } 
                            else if (iconv_strlen($search_q) > 128) 
                            {
                                echo "Слишком длинный поисковый запрос";
                            }
                            else
                            {   
                                //поиск книг по названию
                                $sql = $connection->query("SELECT * FROM books WHERE bookName LIKE '%$search_q%'");
                                $rows = mysqli_num_rows($sql);
                                echo "<span class='BookInfoItem textPadding'>" . "Книги, содержащие в названии \"" . $search_q . "\", по вашему запросу: " . "</span>";
                                if ($rows > 0 )
                                {
                                    for ($i = 0 ; $i < $rows ; ++$i) 
                                    {
                                        $row = mysqli_fetch_row($sql);

                                        izvekov_nauchilsya_uzat_funktsii($row, $connection, $BookIDabc);
                                    }       
                                } else 
                                {   
                                    echo "<p class='textPadding borderBottom'> Не найдено </p>";
                                }
                                // поиск книги по автору
                                $sql = $connection->query("SELECT * FROM authors WHERE Name LIKE '%$search_q%'");
                                $rows = mysqli_num_rows($sql);
                                if ($rows > 0 )
                                {
                                    echo "<span class='BookInfoItem textPadding'>" . "Книги автора \"" . $search_q . "\", по вашему запросу: " . "</span>";
                                    $GetAuthorID = ("SELECT AuthorID FROM authors WHERE Name LIKE '%$search_q%'");
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
                                        foreach ($bookslist as $key => $valueBookID) 
                                        {
                                            $book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID'");
                                            $rows = mysqli_num_rows($book);
                                            for ($i = 0 ; $i < $rows ; ++$i) 
                                            {
                                                $row = mysqli_fetch_row($book);
                                                izvekov_nauchilsya_uzat_funktsii($row, $connection, $BookIDabc);
                                            } 
                                        }
                                    } 
                                }
                                // поиск книг по категории
                                $sql = $connection->query("SELECT * FROM categories WHERE Category LIKE '%$search_q%'");
                                $rows = mysqli_num_rows($sql);
                                if ($rows > 0 )
                                {
                                    echo "<span class='BookInfoItem textPadding'>" . "Книги в категори \"" . $search_q . "\", по вашему запросу: " . "</span>";
                                    $GetCategoryID = ("SELECT CategoryID FROM categories WHERE Category LIKE '%$search_q%'");
                                    $result1 = $connection->query ($GetCategoryID);
                                    $categorieslist = array();
                                    if ($result1->num_rows > 0) {
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
                                        foreach ($bookslist as $key => $valueBookID) 
                                        {
                                            $book = $connection->query("SELECT * FROM books WHERE BookID LIKE '$valueBookID'");
                                            $rows = mysqli_num_rows($book);
                                            for ($i = 0 ; $i < $rows ; ++$i) 
                                            {
                                                $row = mysqli_fetch_row($book);
                                                izvekov_nauchilsya_uzat_funktsii($row, $connection, $BookIDabc);
                                            } 
                                        }
                                    } 
                                }
                            }
                        ?>
                    </div>
                    <!-- <ul class="PageNavigation">
                        <li class="Page PreviousPage"><a href="#">◀</a></li>
                        <li class="Page FirstPage"><a href="#">1</a></li>
                        <li class="PageEmptySpace"></li>
                        <li class="Page"><a href="#">11</a></li>
                        <li class="Page"><a href="#">12</a></li>
                        <li class="Page"><a href="#">13</a></li>
                        <li class="Page"><a href="#">14</a></li>
                        <li class="Page"><a href="#">15</a></li>
                        <li class="PageEmptySpace"></li>
                        <li class="Page LastPage"><a href="#">999</a></li>
                        <li class="Page NextPage"><a href="#">▶</a></li>
                    </ul> -->
                </div>
            </div>
        <div class="SiteFooter">
            <div class="FooterContent">
                <p class="Copyright">Сайт разработан в качестве дипломной работы студентами ВАТ имени В. П. Чкалова</p>
            </div>
        </div>
    </body>
</html>