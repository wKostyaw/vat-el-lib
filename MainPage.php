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
		<div class="notificationWindow">
			<span class="notificationHeader">Заголовок уведомления</span>
			<span class="notificationText">Текст уведомления (Супер важный текст, созданный только для того, чтобы посмотреть как он будет выглядеть, если строк много)</span>
		</div>
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
					
					<!--<ul class="PageNavigation">
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
					</ul>-->
					
				</div>
			</div>
		<div class="SiteFooter">
			<div class="FooterContent">
				<p class="Copyright">Сайт разработан в качестве дипломной работы студентами ВАТ имени В. П. Чкалова</p>
			</div>
		</div>
	</body>
</html>