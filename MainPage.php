<?php
	require "auth.php";
	
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
				<div class="NCentered" id="Navigation">
					<ul class="Navigation">
						<li class="NButton"><a href="#" class="NBLink">Главная</a></li>
						<li class="NButton"><a href="#" class="NBLink">Сохраненное</a></li>
						<li class="NButton"><a href="#" class="NBLink">Авторы</a></li>
						<li class="NButton"><a href="#" class="NBLink">Направление</a></li>
					</ul>
					<button type="button" Class="StartSearch SButton" onclick="SearchVisible()">
						<img src="img/SearchIMG.png">
					</button>
					<button class="exitButton" onclick="document.location.replace('?exit');">Выход</button>
				</div>
				<form class="SearchForm" id="SearchForm" style="display: none;">
					<button type="button" Class="StartSearch SButton">
						<img src="img/SearchIMG.png">
					</button>
					<div>
						<input type="text" class="SearchBookName" id="BookName" placeholder="Введите название книги">
						<input type="button" class="SAOButton SButton" onclick="SAOButtonclick()" value="Фильтр">
					</div>
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
	<script src="js/JQuerry.js" type="text/javascript"></script>
	<script src="js/Slider.js" type="text/javascript"></script>
	<script src="js/Script.js" type="text/javascript"></script>
	<!-- Добавление нового юзера -->
	<div>
		<form method="POST">
			<h3>Добавить пользователя</h3>
			<?php if(isset($smsg)){ ?><div role="alert"> <?php echo $smsg; ?> </div> <?php }?>
			<?php if(isset($fsmsg)){ ?><div role="alert"> <?php echo $fsmsg; ?> </div> <?php }?>
			<input type="text" name="login" placeholder="Логин" required>
			<input type="password" name="password" placeholder="Пароль" required>
			<button type="submit">Добавить</button>
		</form>
	</div>
	<?php 
		$connection = mysqli_connect( 'vat', 'root',  '', 'vat');
		$select_db = mysqli_select_db ($connection, 'vat');
		if (isset($_POST['login']) and isset($_POST['password'])) {
			$login = $_POST['login'];
			$password = $_POST['password'];
			$query = "INSERT INTO loginparol (login, password) VALUES ('$login', '$password')";
			$result = mysqli_query ($connection, $query);

			if ($result) {
				$smsg = "Пользователь успешно добавлен";
			} else {
				$fsmsg = "Ошибка";
			}
		}

	 ?>
</html>