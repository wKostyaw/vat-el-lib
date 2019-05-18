<?php
	include_once "auth.php";
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Изменить/удалить книгу</title>
		
		<link rel="stylesheet" type="text/css" href="css/AdminPage.css">
		<link rel="stylesheet" type="text/css" href="css/AddBookForm.css">
		
		<script src="js/JQuerry.js" type="text/javascript"></script>
		<script src="js/AddOneMore.js" type="text/javascript"></script>
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
				<h2 class="MainHeader">Изменить/удалить книгу</h2>
				
				
				<form class="findBook" name="findBook">
					<div class="FormElemContainer">
						<p class="CategoryName">Поиск по названию(надо придумать нормальную подпись)</p>
						<div class="flexContainer SBorder">
						
						
							<input type="text" class="TextInput FullWidth BSearchName">
							
							
							<button Class="FormButton BSearchBtn" type="button">
								<svg class="SButtonIcon" x="0px" y="0px" width="24" height="24" viewBox="0 0 210 210">
									<path d="M88.2,12.6c-39.47344,0 -71.4,31.92656 -71.4,71.4c0,39.47344 31.92656,71.4 71.4,71.4c14.09297,0 27.13594,-4.13438 38.19375,-11.15625l51.58125,51.58125l17.85,-17.85l-50.925,-50.79375c9.15469,-12.00938 14.7,-26.88984 14.7,-43.18125c0,-39.47344 -31.92656,-71.4 -71.4,-71.4zM88.2,29.4c30.23672,0 54.6,24.36328 54.6,54.6c0,30.23672 -24.36328,54.6 -54.6,54.6c-30.23672,0 -54.6,-24.36328 -54.6,-54.6c0,-30.23672 24.36328,-54.6 54.6,-54.6z"></path>
								</svg>
							</button>
							
							
							<!-- Автокомплит сюда -->
							<div class="HintBox"></div>
							
							
						</div>
					</div>
				</form>
				
				
				<form class="AddBookForm" method="POST" enctype="multipart/form-data" style="display: none;">
					<div class="FormElemContainer">
							<p class="CategoryName">Название Книги</p>
							<input type="text" class="TextInput FullWidth" name="BookName" required>
					</div>
					<div class="FormElemContainer">
							<p class="CategoryName">Год</p>
							<input type="text" class="TextInput HalfWidth" name="BookYear" required>
					</div>
					<!-- АВТОРЫ -->
					<div class="FormElemContainer">
						<p class="CategoryName">Автор(ы):</p>
						<div class="BookAuthorContainer">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox" class="TextInput BookAuthor" name="BookAuthor1" required>
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer" id="testik1">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox1" class="TextInput BookAuthor" name="BookAuthor2">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors1" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox2" class="TextInput BookAuthor" name="BookAuthor3">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors2" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox3" class="TextInput BookAuthor" name="BookAuthor4">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors3" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox4" class="TextInput BookAuthor" name="BookAuthor5">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
						<div id="responseAuthors4" class="HintBox"></div>
						</div>
					</div>
					<!-- КАТЕГОРИИ -->
					<div class="FormElemContainer">
						<p class="CategoryName">Категория(и):</p>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory1" class="TextInput BookCategory" name="BookCategory1" required>
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory1" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory2" class="TextInput BookCategory" name="BookCategory2">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory2" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory3" class="TextInput BookCategory" name="BookCategory3">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory3" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory4" class="TextInput BookCategory" name="BookCategory4">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory4" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory5" class="TextInput BookCategory" name="BookCategory5">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory5" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory6" class="TextInput BookCategory" name="BookCategory6">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory6" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory7" class="TextInput BookCategory" name="BookCategory7">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory7" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory8" class="TextInput BookCategory" name="BookCategory8">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory8" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory9" class="TextInput BookCategory" name="BookCategory9">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory9" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory10" class="TextInput BookCategory" name="BookCategory10">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory10" class="HintBox"></div>
							<br>
						</div>
					</div>
					<div class="FormElemContainer">
							<p class="CategoryName">Краткое описание:</p>
							<textarea class="Description" name="Description1"></textarea>
					</div>
					<div class="FormElemContainer">
							<p class="CategoryName">Загрузка файла</p>
							<input name="BookFile" id="BookFile" type="File" class="File">
							<label for="BookFile" class="AddFileContainer">
							<span class="LFile LFName"></span><span class="LFile LFButton">Выберите фаил</span>
							</label>
							
							<p class="CategoryName">Загрузка файла</p>
							<input name="BookFile" id="BookFile" type="File" class="File">
							<label for="BookFile" class="AddFileContainer">
							<span class="LFile LFName"></span><span class="LFile LFButton">Выберите фаил</span>
							</label>
					</div>
					<div class="FormElemContainer">
						<input type="button" value="Удалить" class="FormButton DeleteButton">
						<input name="submit" type="submit" value="Изменить" class="FormButton SubmitButton">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>