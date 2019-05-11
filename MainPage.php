<?php
	require "auth.php";
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
	// поиск 
	
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
		<script src="js/JQuerry.js" type="text/javascript"></script>
		<script src="js/Slider.js" type="text/javascript"></script>
		<script src="js/Script.js" type="text/javascript"></script>
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
								echo "<li class='NButton'><a href='adminpage2.php' class='NBLink'>&#128081 Панель администрирования &#128081</a></li>";
							}
						?> 
					</ul>
					<button type="button" Class="OpenSearch SButton" onclick="SearchVisible()">
						<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
							<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
						</svg>
						</button>
				</div>
				<form class="SearchForm" id="SearchForm" name="Search" method="POST" action="search.php" style="display: none;">
					<div class="SBorder">





						<button type="submit" Class="StartSearch SButton">
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
							<div id="responseAuthors" class="HintBox"></div>
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
			<div class="SiteWrapper">
				<div class="SiteContent">
					<div class="Slider">
						<div Class="SliderLogo">Название того что внутри</div>
						<div class="SliderButton SliderButtonLeft" onclick="LeftButtonClick()"><img src="img/ArrowL.png"></div>
						<div class="SliderItems">
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Супер-пупер, прям капец какое длинное название книги, что аж не влезает в одну строчку</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo">
									<p>Авторы: Вася, Петя, Сеня, Остальные аболтусы</p>
									<p>Год: 2007</p>
								</div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo">
									<p>Авторы: Вася, Петя, Сеня, Остальные аболтусы</p>
									<p>Год: 2007</p>
								</div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
							<div class="ExampleSliderItem">
								<a href="#" Class="SliderBookName">Название книги</a>
								<div class="SliderItemPreview"><img src="img/BookDefault.png"></div>
								<div class="SliderItemInfo"></div>
							</div>
						</div>
						<div class="SliderButton SliderButtonRight" onclick="RightButtonClick()"><img src="img/ArrowR.png"></div>
					</div>
					<div class="BookBlock">
						<div class="BookBlockItem">
							<div class="BookPreview">
								<img src="img/BookDefault.png">
							</div>
							<div class="BookInfo">
								<span class="BookInfoItem">Название книги: Супер-пупер, прям капец какое длинное название книги, что аж не влезает в одну строчку даже тут не влезло</span>
								<span class="BookInfoItem">Авторы</span>
								<span class="BookInfoItem">Издательство</span>
								<span class="BookInfoItem">Год</span>
								<span class="BookInfoItem">Что-то еще</span>
							</div>
						</div>
						<div class="BookBlockButtons">
							<button class="BookBlockButton">
								Читать
							</button>
							<button class="BookBlockButton">
								Сохранить к себе
							</button>
							<button class="BookBlockButton">
								Что-то еще
							</button>
						</div>
					</div>
					<ul class="PageNavigation">
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
					</ul>
				</div>
			</div>
		<div class="SiteFooter">
			<div class="FooterContent">
				<p class="Copyright">Сайт разработан в качестве дипломной работы студентами ВАТ имени В. П. Чкалова</p>
			</div>
		</div>
	</body>
	
	</html>