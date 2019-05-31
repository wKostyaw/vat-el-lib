<?php
	include_once "auth.php";

	// поиск соответствий в БД
	if (isset($_POST['search'])) {
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q = $connection->real_escape_string($_POST['q']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%'");
		$sql1 = $connection->query("SELECT BookName FROM books WHERE BookName LIKE '%$q%'");
		$sql2 = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q%'");
		if ($sql->num_rows > 0 or  $sql1->num_rows > 0 or  $sql2->num_rows > 0) {
			$responseAuthors = "<ul class='HintList'>";
				// $responseAuthors .= "<li class='HintHead'>Авторы:</li>";
				while ($data = $sql->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'>" . $data['Name'] . "</li>";
				// $responseAuthors .= "<li class='HintHead'>Книги:</li>";
				while ($data = $sql1->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'>" . $data['BookName'] . "</li>";
				// $responseAuthors .= "<li class='HintHead'>Категории:</li>";
				while ($data = $sql2->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'>" . $data['Category'] . "</li>";
			$responseAuthors .= "</ul>";
		}
		exit($responseAuthors);
	}
	
	// Отрисовка сохранок
	
	function push($SavedBookId, $BookName, $BookYear, $BookAuthors, $BookCategories, $Description, $PathToCover) {
		echo '<div class="BookBlock">';
			echo '<div class="BookBlockItem">';
				echo '<div class="BookPreview">';
					echo '<img src="' . $PathToCover . '">';
				echo '</div>';
				echo '<div class="BookInfo">';
					echo '<span class="BookInfoItem">Название книги: <a href="book.php?BookInfo=' . $SavedBookId . '">' . $BookName . '</a></span>';
					echo '<span class="BookInfoItem">Год: ' . $BookYear . '</span>';
					echo '<span class="BookInfoItem">Авторы: ' . $BookAuthors . '</span>';
					echo '<span class="BookInfoItem">Категории: ' . $BookCategories . '</span>';
					echo '<span class="BookInfoItem">Краткое описание: ' . $Description . '</span>';
				echo '</div>';
			echo '</div>';
			echo '<div class="BookBlockButtons">';
					echo '<a href="book.php?BookInfo=' . $SavedBookId . '#bookFile"><button type="button" class="BookBlockButton">Читать</button></a>';
					echo '<button class="BookBlockButton deleteBook" name="deletebook[]" id="' . $SavedBookId . '">Удалить из сохраненных</button>';
			echo '</div>';
		echo '</div>';
	}
	
	// Поиск сохранок пользователя
	
	function savedBooks($Login , $connection) {
		//$Login = $_SESSION['login'];
		$sqlUserId = $connection->query("SELECT id FROM loginparol WHERE login LIKE '$Login'");
		$UserId = $sqlUserId->fetch_assoc()['id'];
		
		$sqlSavedBookIds = $connection->query("SELECT BookID FROM users_and_books WHERE id LIKE '$UserId'");
		
		while ($SavedBookId = $sqlSavedBookIds->fetch_assoc()['BookID']) {
			$sqlBookInfo = $connection->query("SELECT BookName, BookYear, Description, PathToCover FROM books WHERE BookID LIKE '$SavedBookId'");
			
			$BookInfo = $sqlBookInfo->fetch_assoc();
			$BookName = $BookInfo['BookName'];
			$BookYear = $BookInfo['BookYear'];
			$Description = $BookInfo['Description'];
			$PathToCover = $BookInfo['PathToCover'];
			
			
			
			
			$sqlbookauthors = $connection->query("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$SavedBookId'");
			$BookAuthors = array();
			$i = 0;
			while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc()) {
				$AuthorID = $BookAuthorsId["AuthorID"];
				$sqlauthors = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
				$AuthorName = $sqlauthors->fetch_assoc();
				$BookAuthors[$i] = $AuthorName["Name"];
				$i = $i + 1;
			} 
			$BookAuthors = implode(', ',$BookAuthors); 
			
			$sqlbookcategories = $connection->query("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$SavedBookId'");
			$BookCategories = array();
			$i = 0;
			while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc()) {
				$CategoryID = $BookCategoriesId["CategoryID"];
				$sqlcategory = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
					$CategoryName = $sqlcategory->fetch_assoc();
					$BookCategories[$i] = $CategoryName["Category"];
					$i = $i + 1;
			}
			$BookCategories = implode(', ',$BookCategories);
			
			push($SavedBookId, $BookName, $BookYear, $BookAuthors, $BookCategories, $Description, $PathToCover);
		}
	}
	
	// Удаление книги
	if (isset($_POST['DeleteBookID'])) 
    {
        $DeleteBookID = $_POST['DeleteBookID'];
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
<!DOCTYPE HTML>
<html>
	<meta charset="utf-8">
	<head>
		<title>Главная</title>
		<link rel="stylesheet" type="text/css" href="Css/style.css">
		<link rel="stylesheet" type="text/css" href="Css/BooksList.css">
		<link rel="stylesheet" type="text/css" href="Css/BooksList.css">
		<link rel="stylesheet" type="text/css" href="Css/PageNavigation.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script src="Js/Script.js" type="text/javascript"></script>
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
					
					<!--<div class="addNewShelfBox">
						<span class="addNewShelfHeader">Добавить полку</span><br>
						<input id="newShelfName" type="text" class="textField" placeholder="Имя полки">
						<button type="button">Добавить</button>
					</div>
					<div class="shelvesContainer">
						<div class="shelf">
							<a href="#">
								<svg id="svg913" class="shelfIcon" width="100" height="100" version="1.1" viewBox="0 0 52.917 52.917" xmlns="http://www.w3.org/2000/svg">
									<g id="g911" transform="matrix(.74415 0 0 .74415 -51.061 -25.419)">
										<g id="g885" stroke-width=".50493">
											<path id="path879" d="m68.822 91.855h70.693"/>
											<path id="path881" d="m68.822 101.61h70.693"/>
											<path id="path883" d="m68.822 104.28h70.693"/>
										</g>
										<g id="g907">
											<g id="g895" stroke-width=".52917">
												<path id="path887" d="m76.926 53.799c4.0091-0.67721 8.0183-0.56804 12.027 0v44.366c-4.0919 0.66228-8.1135 0.7617-12.027 0z"/>
												<path id="path889" d="m91.316 42.841c1.9557-0.62107 4.1811-0.74432 6.6817 0v55.325c-2.6685 1.1663-4.7524 0.81637-6.6817 0z"/>
												<path id="path891" d="m100.23 49.79c3.0759-0.65053 6.4846-1.0892 12.294 0v48.376c-4.9431 1.2096-8.8187 0.94908-12.294 0z"/>
												<path id="path893" d="m114.51 38.565c4.9455-0.76066 10.228-0.99651 16.303 0v59.601c-5.5681 1.2025-10.987 1.0636-16.303 0z"/>
											</g>
											<g id="g903" stroke-width=".26458">
												<path id="path897" d="m78.208 58.182c2.9179-0.27032 5.992-0.35118 9.3544 0v7.2163c-3.2246 0.30496-6.3066 0.22718-9.3544 0z"/>
												<path id="path899" d="m92.943 55.388c1.1422-0.28609 2.1762-0.24788 3.1404 0v38.821c-0.7642 0.28261-1.6696 0.424-3.1404 0z"/>
												<path id="path901" d="m101.7 53.668c2.9179-0.27032 5.992-0.35118 9.3544 0v7.2163c-3.2246 0.30496-6.3066 0.22718-9.3544 0z"/>
											</g>
											<path id="path905" d="m116.44 44.452c3.8886-0.37554 7.9853-0.48788 12.466 0v10.025c-4.2973 0.42367-8.4046 0.31561-12.466 0z" stroke-width=".36001"/>
										</g>
									</g>
								</svg>
							</a>
							<span class="shelfName">Полка по умолчанию</span>
						</div>
					</div>-->
					<?
					savedBooks($_SESSION['login'], $connection);
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