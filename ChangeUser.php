<?php
	include_once "auth.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Изменить/удалить пользователя</title>
		<link rel="stylesheet" type="text/css" href="css/AdminPage.css">
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<div class="LogoContainer">
					<img src="img/workinprogress.png" class="Logo">
				</div>
					<ul class="AdminLinks">
						<li class="AdminLinkBox"><a href="mainpage.php" class="AdminLink">На сайт</a></li>
						<li class="AdminLinkBox"><a href="AddUserForm.php" class="AdminLink">Добавить пользователя</a></li>
						<li class="AdminLinkBox"><a href="ChangeUser.php" class="AdminLink">Изменить/удалить пользователя</a></li>
						<li class="AdminLinkBox"><a href="AddBookForm.php" class="AdminLink">Добавить книгу</a></li>
						<li class="AdminLinkBox"><a href="ChangeBook.php" class="AdminLink">Изменить/удалить книгу</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Пароли, явки</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace('?exit');">Выход</a></li>
					</ul>
			</div>
			<div class="Option">
				<h2 class="MainHeader">Изменить/удалить пользователя</h2>
				<form class="findUser" name="findUser">
					<div class="FormElemContainer">
						<p class="CategoryName">Логин разыскиваемого</p>
						<div class="flexContainer SBorder">
						
						
							<input type="text" class="TextInput HalfWidth USearchName">
							
							
							<button Class="FormButton USearchBtn" type="button">
								<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
									<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
								</svg>
							</button>
							
							<!-- Автокомплит сюда(если нужен) -->
							<div class="HintBox"></div>
							
						</div>
					</div>
				</form>
				<form method="POST">
					<div class="FormElemContainer">
					<p class="CategoryName">Логин</p>
					<input type="text" name="login" placeholder="Логин" class="TextInput HalfWidth" required>
					</div>
					<div class="FormElemContainer">
					<p class="CategoryName">Пароль</p>
					<input type="password" name="password" placeholder="Пароль" class="TextInput HalfWidth" required>
					</div>
					<div class="FormElemContainer">
					<button type="button" class="FormButton DeleteButton">Удалить</button>
					<button type="submit" class="FormButton SubmitButton">Изменить</button>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script src="js/JQuerry.js" type="text/javascript"></script>
</html>