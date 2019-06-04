<?php
	include_once "auth.php";

	// поиск соответствий в БД
	if (isset($_POST['search'])) {
		$q = $connection->real_escape_string($_POST['q']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%' ORDER BY Name ASC LIMIT 2");
		$sql1 = $connection->query("SELECT BookName FROM books WHERE BookName LIKE '%$q%' ORDER BY FIND_IN_SET(BookName,'$q*') ASC LIMIT 2");
		$sql2 = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q%' ORDER BY Category ASC LIMIT 2");
		if ($sql->num_rows > 0 or  $sql1->num_rows > 0 or  $sql2->num_rows > 0) {
			$responseAuthors = "<ul class='HintList'>";
				// $responseAuthors .= "<li class='HintHead'>Авторы:</li>";
				while ($data = $sql->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'><a href='#'>" . $data['Name'] . "</a></li>";
				// $responseAuthors .= "<li class='HintHead'>Книги:</li>";
				while ($data = $sql1->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'><a href='#'>" . $data['BookName'] . "</a></li>";
				// $responseAuthors .= "<li class='HintHead'>Категории:</li>";
				while ($data = $sql2->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'><a href='#'>" . $data['Category'] . "</a></li>";
			$responseAuthors .= "</ul>";
		}
		exit($responseAuthors);
	}
	// поиск 
	
?>
<!DOCTYPE HTML>
<html>
	<meta charset="utf-8">
	<head>
		<title>Главная</title>
		<link rel="stylesheet" type="text/css" href="Css/style.css">
		<link rel="stylesheet" type="text/css" href="Css/slider.css">
		<link rel="stylesheet" type="text/css" href="Css/BooksList.css">
		<link rel="stylesheet" type="text/css" href="Css/PageNavigation.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script src="Js/Slider.js" type="text/javascript"></script>
		<script src="Js/Script.js" type="text/javascript"></script>
	</head>
	<body>
		<!--<div class="notificationWindow">
			<span class="notificationHeader">Заголовок уведомления</span>
			<span class="notificationText">Текст уведомления (Супер важный текст, созданный только для того, чтобы посмотреть как он будет выглядеть, если строк много)</span>
		</div>-->
		<div class="SiteHeader">
			<div class="HeaderContent">
				<!--<img src="Img/WorkInProgress.png" class="Logo">-->
				<a href="MainPage.php" title="На главную"><img src="Img/LogoBWStroke.png" class="Logo"></a>
				<h1 class="SiteName">Электронная библиотека ВАТ имени В. П. Чкалова</h1>
			</div>
		</div>
			<div class="SecondHeader" id="SecondHeader">
			<div class="NCentered">
					<ul class="Navigation">
						<li class="NButton"><a href="MainPage.php" class="NBLink">Главная</a></li>
						<li class="NButton"><a href="Saved.php" class="NBLink">Сохраненное</a></li>
						<?php 
							ifAdminShowButton($connection);
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
							<input type="text" autocomplete="off" class="SearchBookName" id="SearchBox" name="SearchAll" placeholder="Введите название книги">								
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
				</div>
			</div>
		<div class="SiteFooter">
			<div class="FooterContent">
				<p class="Copyright">Сайт разработан в качестве дипломной работы студентами ВАТ имени В. П. Чкалова</p>
			</div>
		</div>
	</body>
</html>