<?php
	include_once "auth.php";
	
	if (isset($_POST['nameValue'])) {
		$nameValue = $connection->real_escape_string($_POST['nameValue']);
		$sqlRequest = $connection->query("SELECT BookID, BookName, BookYear FROM books WHERE BookName LIKE '%$nameValue%'");
	if ($sqlRequest->num_rows > 0) {
		$responseBooks = "<ul class='HintList'>";
			while ($data = $sqlRequest->fetch_array()) {
				$responseBooks .= "<li class='bookHint Hint' id='" . $data['BookID'] . "'>" . $data['BookName'] . " - " . $data['BookYear'] . " год" . "</li>";
			}
		$responseBooks .= "</ul>";
	}
	exit($responseBooks);
	}
	
	if (isset($_POST['BookId'])) {
		$BookId = $_POST['BookId'];
		
		// Название, год, описание
		$sqlBookInfo = $connection->query("SELECT BookName, BookYear, Description FROM books WHERE BookID LIKE $BookId");
		$data = $sqlBookInfo->fetch_assoc();
		
		// Авторы
		$sqlbookauthors = $connection->query("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$BookId'");
		$BookAuthors = array();
		$i = 0;
		while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc()) {
			$AuthorID = $BookAuthorsId["AuthorID"];
			$sqlauthors = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
				$AuthorName = $sqlauthors->fetch_assoc();
				$BookAuthors[$i] = $AuthorName["Name"];
				$i = $i + 1;
		} 
		$data['BookAuthors'] = $BookAuthors;
		
		// Категории
		$sqlbookcategories = $connection->query("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$BookId'");
		$BookCategories = array();
		$i = 0;
		while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc()) 
		{
			$CategoryID = $BookCategoriesId["CategoryID"];
			$sqlcategory = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
				$CategoryName = $sqlcategory->fetch_assoc();
				$BookCategories[$i] = $CategoryName["Category"];
				$i = $i + 1;
		}
		$data['BookCategories'] = $BookCategories;
		
		$data = json_encode($data);
		exit($data);
	}
	
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
						<div class="SBorder">
							<div class="flexContainer">
								<input type="text" class="TextInput FullWidth BSearchName" id="BSearchName">
							</div>
							<div class="HintBox" Id="BookHints"></div>
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
								<input type="text" id="SearchBox" class="TextInput BookAuthor" name="BookAuthor[]" required>
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer" id="testik1">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox1" class="TextInput BookAuthor" name="BookAuthor[]">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors1" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox2" class="TextInput BookAuthor" name="BookAuthor[]">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors2" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox3" class="TextInput BookAuthor" name="BookAuthor[]">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors3" class="HintBox"></div>
							<br>
						</div>
						<div class="BookAuthorContainer">
							<div class="AddBookAuthorContainer">
								<input type="text" id="SearchBox4" class="TextInput BookAuthor" name="BookAuthor[]">
							</div>
						<div id="responseAuthors4" class="HintBox"></div>
						</div>
					</div>
					<!-- КАТЕГОРИИ -->
					<div class="FormElemContainer">
						<p class="CategoryName">Категория(и):</p>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory1" class="TextInput BookCategory" name="BookCategory[]" required>
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory1" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory2" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory2" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory3" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory3" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory4" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory4" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory5" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory5" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory6" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory6" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory7" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory7" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory8" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory8" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory9" class="TextInput BookCategory" name="BookCategory[]">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory9" class="HintBox"></div>
							<br>
						</div>
						<div class="BookCategoryContainer">
							<div class="AddBookCategoryContainer">
								<input type="text" id="SearchBoxCategory10" class="TextInput BookCategory" name="BookCategory[]">
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