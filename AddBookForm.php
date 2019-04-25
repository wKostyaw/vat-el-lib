<?php
	require "auth.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/AdminPage.css">
		<link rel="stylesheet" type="text/css" href="css/AddBookForm.css">
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
				<p class="MainHeader">Добавить книгу</p>
				<form>
					<div class="Category">
						<label class="CatInner"><p p class="CategoryName">Название Книги</p><input type="text" class="TextInput BookName"></label>
					</div>
					<div class="Category">
						<label class="CatInner"><p p class="CategoryName">Год</p><input type="text" class="TextInput BookYear"></label>
					</div>
					<div class="Category">
						<label class="CatInner SelectorsGrid"><p p class="CategoryName">Автор(ы)</p>
							<select class="Selector Autor">
								<option>Пункт 1</option>
								<option>Пункт 2</option>
							</select>
							<button Class="AddAutor Add" type="button">
								<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;">
									<path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path>
								</svg>
							</button>
						</label>
					</div>
					<div class="Category">
						<label class="CatInner SelectorsGrid"><p p class="CategoryName">Категория(и)</p>
							<select class="Selector BookCategory">
								<option>Пункт 1</option>
								<option>Пункт 2</option>
							</select>
							<button Class="AddBookCategory Add" type="button">
								<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;">
									<path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path>
								</svg>
							</button>
						</label>
					</div>
				</form>
			</div>
		</div>
	</body>
	<script src="js/JQuerry.js" type="text/javascript"></script>
	<script src="js/AddOneMore.js" type="text/javascript"></script>
</html>