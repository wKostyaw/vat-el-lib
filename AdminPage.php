<?php
	require "auth.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
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
						<li class="AdminLinkBox"><a href="AdminPage2.php" class="AdminLink">Добавить пользователя</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Изменить/удалить пользователя</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Добавить книгу</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Изменить/удалить книгу</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink">Пароли, явки</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace('?exit');">Выход</a></li>
					</ul>
			</div>
			<div class="Option">
				<h1 class="AdminStart">Выберите одну из опций слева</h1>
			</div>
		</div>
	</body>
	<script src="js/JQuerry.js" type="text/javascript"></script>
</html>