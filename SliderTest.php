<?php
	require "auth.php";
	// поиск соответствий в БД
	if (isset($_POST['search1'])) {
		$response1 = "<ul><li>Все соответствия <a href='search.php'> </a></li></ul>";
		$q1 = $connection->real_escape_string($_POST['q1']);
		$sql = $connection->query("SELECT BookName FROM books WHERE BookName LIKE '%$q1%'");
		if ($sql->num_rows > 0) {
			$response1 = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$response1 .= "<li id='li1' class='Hint'>" . $data['Name'] . "</li>";
			$response1 .= "</ul>";
		}
		exit($response1);
	}
	
	
	//$sql = $connection->query("SELECT BookName FROM books WHERE BookName LIKE '%$q1%'");
	if (isset($_POST['SliderLastItemRequest'])) {
		$Amount = $_POST['SliderLastItemRequest']; // Не получилось без этой переменной поставить лимит указанный в Ajax запросе
		$sqlbook = $connection->query("SELECT * FROM books ORDER BY BookID DESC LIMIT $Amount");
		unset($Amount); // Удаляем эту переменную
		$LastBooks = array();
		$j = 0;
		while($BookInfo = $sqlbook-> fetch_assoc()){
		
			$BookId = $BookInfo["BookID"];
			$BookAuthors = array(); //Массив имен авторов
			$BookCategories = array(); //Массив категорий книги
			
			$sqlbookauthors = $connection->query("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$BookId'");
			$i = 0; // обнуленный счетчик
			while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc()) {
				$AuthorID = $BookAuthorsId["AuthorID"];
				$sqlauthors = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
					$AuthorName = $sqlauthors->fetch_assoc();
					$BookAuthors[$i] = $AuthorName["Name"];
					$i = $i + 1;
			}
			$BookAuthors = implode(', ',$BookAuthors); // Перевод полученного массива авторов в строку
			
			$sqlbookcategories = $connection->query("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$BookId'");
			$i = 0; // обнуленный счетчик
			while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc()) {
				$CategoryID = $BookCategoriesId["CategoryID"];
				$sqlcategory = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
					$CategoryName = $sqlcategory->fetch_assoc();
					$BookCategories[$i] = $CategoryName["Category"];
					$i = $i + 1;
			}
			$BookCategories = implode(', ',$BookCategories); // Перевод полученного массива категорий в строку
			$BookInfo[BookAuthors] = $BookAuthors;
			$BookInfo[BookCategories] = $BookCategories;
			$LastBooks[$j] = $BookInfo;
			$j = $j + 1;
		} //Конец While($BookAuthorsId = $sqlbookauthors -> fetch_assoc())
		$LastBooks = json_encode($LastBooks);
		exit($LastBooks);
	} // Конец if (isset($_POST['SliderLastItemRequest']))
		
	if (isset($_POST['SliderCategoryRequest'])) {
		$Amount = ($_POST['SliderAmountOfItems']);
		$CategoryName = ($_POST['SliderCategoryRequest']);
		$sqlbookcategory = $connection->query("SELECT CategoryID FROM categories WHERE Category LIKE '$CategoryName'");
		$SelectedCategoryId = ($sqlbookcategory -> fetch_assoc())['CategoryID'];
		$sqlbookIds = $connection->query("SELECT BookID FROM books_and_categories WHERE CategoryID LIKE $SelectedCategoryId LIMIT $Amount");
		$ListOfBooks = array();
		$j = 0;
		while($BookId = $sqlbookIds-> fetch_assoc()) {
			$BookIdValue = $BookId['BookID'];
			$sqlbook = $connection->query("SELECT * FROM books WHERE BookID LIKE $BookIdValue");
			$i = 0; // обнуленный счетчик
			$BookInfo = $sqlbook-> fetch_assoc();
			
			$BookAuthors = array(); //Массив имен авторов
			$BookCategories = array(); //Массив категорий книги
				
			$sqlbookauthors = $connection->query("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$BookIdValue'");
			while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc()) {
				$AuthorID = $BookAuthorsId["AuthorID"];
				$sqlauthors = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
					$AuthorName = $sqlauthors->fetch_assoc();
					$BookAuthors[$i] = $AuthorName["Name"];
					$i = $i + 1;
			} // Конец while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc())
			$BookAuthors = implode(', ',$BookAuthors); // Перевод полученного массива авторов в строку
			
			$sqlbookcategories = $connection->query("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$BookIdValue'");
			$i = 0; // обнуленный счетчик
			while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc()) {
				$CategoryID = $BookCategoriesId["CategoryID"];
				$sqlcategory = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
					$CategoryName = $sqlcategory->fetch_assoc();
					$BookCategories[$i] = $CategoryName["Category"];
					$i = $i + 1;
			} // Конец while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc())
			$BookCategories = implode(', ',$BookCategories); // Перевод полученного массива категорий в строку
			$BookInfo[BookAuthors] = $BookAuthors;
			$BookInfo[BookCategories] = $BookCategories;
			$ListOfBooks[$j] = $BookInfo;
			$j = $j + 1;
		} // Конец while($BookId = $sqlbookIds -> fetch_assoc())
		$ListOfBooks = json_encode($ListOfBooks);
		exit($ListOfBooks);
	} // Конец if (isset($_POST['SliderCategoryRequest']))
		
	if (isset($_POST['SliderAuthorRequest'])) {
		$Amount = ($_POST['SliderAmountOfItems']);
		$AuthorName = ($_POST['SliderAuthorRequest']);
		$sqlbookcategory = $connection->query("SELECT AuthorID FROM authors WHERE Name LIKE '$AuthorName'");
		$SelectedAuthorId = ($sqlbookcategory -> fetch_assoc())['AuthorID'];
		$sqlbookIds = $connection->query("SELECT BookID FROM books_and_authors WHERE AuthorID LIKE $SelectedAuthorId LIMIT $Amount");
		$ListOfBooks = array();
		$j = 0;
		while($BookId = $sqlbookIds-> fetch_assoc()) {
			$BookIdValue = $BookId['BookID'];
			$sqlbook = $connection->query("SELECT * FROM books WHERE BookID LIKE $BookIdValue");
			$i = 0; // обнуленный счетчик
			$BookInfo = $sqlbook-> fetch_assoc();
			
			$BookAuthors = array(); //Массив имен авторов
			$BookCategories = array(); //Массив категорий книги
				
			$sqlbookauthors = $connection->query("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$BookIdValue'");
			while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc()) {
				$AuthorID = $BookAuthorsId["AuthorID"];
				$sqlauthors = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
					$AuthorName = $sqlauthors->fetch_assoc();
					$BookAuthors[$i] = $AuthorName["Name"];
					$i = $i + 1;
			} // Конец while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc())
			$BookAuthors = implode(', ',$BookAuthors); // Перевод полученного массива авторов в строку
			
			$sqlbookcategories = $connection->query("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$BookIdValue'");
			$i = 0; // обнуленный счетчик
			while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc()) {
				$CategoryID = $BookCategoriesId["CategoryID"];
				$sqlcategory = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
					$CategoryName = $sqlcategory->fetch_assoc();
					$BookCategories[$i] = $CategoryName["Category"];
					$i = $i + 1;
			} // Конец while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc())
			$BookCategories = implode(', ',$BookCategories); // Перевод полученного массива категорий в строку
			$BookInfo[BookAuthors] = $BookAuthors;
			$BookInfo[BookCategories] = $BookCategories;
			$ListOfBooks[$j] = $BookInfo;
			$j = $j + 1;
		} // Конец while($BookId = $sqlbookIds -> fetch_assoc())
		$ListOfBooks = json_encode($ListOfBooks);
		exit($ListOfBooks);
	} // Конец if (isset($_POST['SliderCategoryRequest']))
?>
<!doctype HTML>
<html>
	<meta charset="utf-8">
	<head>
		<title>Главная</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<link rel="stylesheet" type="text/css" href="css/slider.css">
		<link rel="stylesheet" type="text/css" href="css/BooksList.css">
		<link rel="stylesheet" type="text/css" href="css/PageNavigation.css">
	</head>
	<body>
		<div class="SiteHeader">
			<div class="HeaderContent">
				<img src="img/WorkInProgress.png" class="Logo">
				<p class="SiteName">Электронная библиотека ВАТ имени В. П. Чкалова</p>
			</div>
		</div>
			<div class="SecondHeader" id="SecondHeader">
			<div class="NCentered">
				<button class="exitButton" onclick="document.location.replace('?exit');">Выход</button>
				
				<div id="Navigation">
					<ul class="Navigation">
						<li class="NButton"><a href="MainPage.php" class="NBLink">Главная</a></li>
						<li class="NButton"><a href="#" class="NBLink">Сохраненное</a></li>
						<li class="NButton"><a href="#" class="NBLink">Авторы</a></li>
						<li class="NButton"><a href="#" class="NBLink">Категории</a></li>
					</ul>
					<button type="button" Class="OpenSearch SButton" onclick="SearchVisible()">
						<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
							<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
						</svg>
						</button>
				</div>

				<form class="SearchForm" id="SearchForm" name="Search" method="POST" style="display: none;">
					<div class="SBorder">
						<button type="button" Class="StartSearch SButton">
							<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
								<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
							</svg>
						</button>
						<input type="text" class="SearchBookName" id="BookName" name="SearchAll" placeholder="Введите название книги">
						<button type="button" Class="CloseSearch SButton" onclick="SearchHide()">
							<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 192 192">
								<path d="M45.65625,34.34375l-11.3125,11.3125l50.34375,50.34375l-50.34375,50.34375l11.3125,11.3125l50.34375,-50.34375l50.34375,50.34375l11.3125,-11.3125l-50.34375,-50.34375l50.34375,-50.34375l-11.3125,-11.3125l-50.34375,50.34375z"></path>
							</svg>
						</button>
					</div>
						<button class="SAOButton SButton" onclick="SAOButtonclick()">
							<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 192 192">
							<path d="M116,92h-40l-48,-56h136z"></path>
							<path d="M116,152l-40,24v-84h40z"></path>
							<path d="M166,36h-140c-3.20312,0 -6,-2.79688 -6,-6c0,-3.20312 2.79688,-6 6,-6h140c3.20312,0 6,2.79688 6,6c0,3.20312 -2.79688,6 -6,6z"></path>
							</svg>
						</button>
					<div class="SAOOptions" id="SAOOptions" style="display: none;">
						<div class="SAOOption SAOAutor">
							<label class="SAOLabel">Авторы (указать через запятую):
								<input class="SAOInput" type="text">
							</label>
						</div>	
						<div class="SAOOption SAOYear">
							<label class="SAOLabel">Года (пример: 2019/2005-2009/2012, 2014):
								<input class="SAOInput" type="text">
							</label>
						</div>
						<div class="SAOOption SAOGenre">
							<label class="SAOLabel">Жанры (указать через запятую):
								<input class="SAOInput" type="text">
							</label>
						</div>
					</div>
				</form>
			</div>
			</div>
			
			<!-- Контент страницы -->
			<div class="SiteWrapper">
				<div class="SiteContent">
				
					<div class="Slider" id="ListofLast">
						<div Class="SliderLogo">Последние загруженные книги</div>
						<div class="SliderButton SliderButtonLeft""><img src="img/ArrowL.png"></div>
						<div class="SliderItems">
							<div class="SliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderBookPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderBookInfo">
									<p class="SliderBookAuthors">Авторы: Вася, Петя, Сеня, Остальные аболтусы</p>
									<p class="SliderBookYear">Год: 2007</p>
								</div>
							</div>
							
							<div class="SliderItem">
								<a href="#" Class="SliderBookName"></a>
								<div class="SliderBookPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderBookInfo">
									<p class="SliderBookAuthors">Авторы: </p>
									<p class="SliderBookYear">Год: </p>
								</div>
							</div>
						</div>
						<div class="SliderButton SliderButtonRight""><img src="img/ArrowR.png"></div>
					</div>
					
					<div class="Slider" id="Category1">
						<div Class="SliderLogo">Категория</div>
						<div class="SliderButton SliderButtonLeft""><img src="img/ArrowL.png"></div>
						<div class="SliderItems"></div>
						<div class="SliderButton SliderButtonRight""><img src="img/ArrowR.png"></div>
					</div>
					
					<div class="Slider" id="Author1">
						<div Class="SliderLogo">Автор</div>
						<div class="SliderButton SliderButtonLeft""><img src="img/ArrowL.png"></div>
						<div class="SliderItems"></div>
						<div class="SliderButton SliderButtonRight""><img src="img/ArrowR.png"></div>
					</div>
				</div>
			</div>
		<div class="SiteFooter">
			<div class="FooterContent">
				<p class="Copyright">Сайт разработан в качестве дипломной работы студентами ВАТ имени В. П. Чкалова</p>
			</div>
		</div>
	</body>
	<script src="js/JQuerry.js" type="text/javascript"></script>
	<script src="js/Slider.js" type="text/javascript"></script>
	<script src="js/Script.js" type="text/javascript"></script>
	</html>