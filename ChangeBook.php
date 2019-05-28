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
		$sqlBookInfo = $connection->query("SELECT BookID, BookName, BookYear, Description FROM books WHERE BookID LIKE $BookId");
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
	
	
	
	if (isset($_POST['change'])) {
		$BookName = $_POST['BookName'];
		$BookYear = $_POST['BookYear'];
		$Description1 = $_POST['Description1'];
		$BookAuthors = $_POST['BookAuthor'];
		$BookCategories = $_POST['BookCategory'];
		$BookId = $_POST['Id'];
		
		// Обновление названия, года, описания
		$sql = $connection->query(
			"UPDATE `books` 
			SET 
			BookName = '$BookName', 
			BookYear = '$BookYear', 
			Description = '$Description1' 
			WHERE 
			BookID = $BookId"
		);
		// Обновление авторов
		
		$sql = $connection->query (
			"DELETE FROM books_and_authors
			WHERE
			BookID = $BookId"
		);
		
		foreach ($BookAuthors as $BookAutor => $Value) {
			if ($Value != '') {
				$isAuthorExists1 = $connection->query("SELECT count(*) FROM authors WHERE name = '$Value'");
				$row1 = mysqli_fetch_row($isAuthorExists1);
				
				// Если совпадений имен авторов не найдено добавляем нового автора
				if ($row1[0] == 0) {
					$insertNewAuthor = "INSERT INTO authors (Name) VALUES ('$Value')";
					$result = $connection->query($insertNewAuthor);
				}
				// Связка таблиц
				$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
				$result = $connection->query($fatchBookId);
				if ($result->num_rows > 0) {
					// подбирает id заливаемой книги
					while($row = $result->fetch_assoc()) {
						$BookId = $row["BookID"];
					}
				} 
				$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$Value'");
				$result = $connection->query($fatchAuthorId);
				if ($result->num_rows > 0) {
					// подбирает id автора книги
					while($row = $result->fetch_assoc()) {
						$AuthorId = $row["AuthorID"];
					}
				} 
				$link = "INSERT INTO books_and_authors (BookID, AuthorID) VALUES ('$BookId', '$AuthorId')";
				$result = $connection->query($link);
			}
		}
		
		// Обновление категорий
		
		$sql = $connection->query (
			"DELETE FROM books_and_categories
			WHERE BookID = $BookId"
		);
		
		foreach ($BookCategories as $BookCategory => $Value) {
			if ($Value != '') {
				$isCategoryExists = $connection->query("SELECT count(*) FROM categories WHERE Category = '$Value'");
				$row1 = mysqli_fetch_row($isCategoryExists);
				if ($row1[0] == 0) {
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$Value')";
					$result = $connection->query($insertNewCategory);
				}
				// связь
				$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
				$result = $connection->query($fatchBookId);
				if ($result->num_rows > 0) {
					// подбирает id заливаемой книги
					while($row = $result->fetch_assoc()) {
						$BookId = $row["BookID"];
					}
				} 
				$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Category = '$Value'");
				$result = $connection->query($fatchCategoryId);
				if ($result->num_rows > 0) {
					// подбирает id категории книги
					while($row = $result->fetch_assoc()) {
						$CategoryId = $row["CategoryID"];
					}
				} 
				$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
				$result = $connection->query($link);
			}
		}
		
	}
	if (isset($_POST['remove'])) {
		$BookId = $_POST['Id'];
		
		// Удаление из промежуточной таблицы авторов
		
		$sql = $connection->query (
			"DELETE FROM books_and_authors
			WHERE BookID = $BookId"
		);
		
		// Удаление из промежуточной таблицы категорий
		
		$sql = $connection->query (
			"DELETE FROM books_and_categories
			WHERE BookID = $BookId"
		);
		
		// Удаление книги
		
		$sql = $connection->query (
			"DELETE FROM books
			WHERE BookID = $BookId"
		);
		
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
								<input type="text" class="TextInput FullWidth BSearchName" autocomplete="off" id="BSearchName">
							</div>
							<div class="HintBox" Id="BookHints"></div>
						</div>
					</div>
				</form>
				
				
				<form class="AddBookForm" method="POST" enctype="multipart/form-data" style="display: none;">
					<div class="FormElemContainer">
							<p class="CategoryName">Название Книги</p>
							<input type="text" class="TextInput FullWidth" name="BookName" autocomplete="off" required>
					</div>
					<div class="FormElemContainer">
							<p class="CategoryName">Год</p>
							<input type="text" class="TextInput HalfWidth" name="BookYear" autocomplete="off" required>
					</div>
					
					
					
					<!-- АВТОРЫ -->
					<div class="FormElemContainer">
						<p class="CategoryName">Автор(ы):</p>
						
						<div class="BookAuthorContainer SBorder HalfWidth">
							<div class="AddBookAuthorContainer flexContainer">
								<input type="text" class="TextInput BookAuthor" name="BookAuthor[]" autocomplete="off" required>
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseAuthors"></div>
						</div>
						<div class="BookAuthorContainer SBorder HalfWidth">
							<div class="AddBookAuthorContainer flexContainer">
								<input type="text" class="TextInput BookAuthor" name="BookAuthor[]" autocomplete="off">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseAuthors"></div>
						</div>
						<div class="BookAuthorContainer SBorder HalfWidth">
							<div class="AddBookAuthorContainer flexContainer">
								<input type="text" class="TextInput BookAuthor" name="BookAuthor[]" autocomplete="off">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseAuthors"></div>
						</div>
						
						<div class="BookAuthorContainer SBorder HalfWidth">
							<div class="AddBookAuthorContainer flexContainer">
								<input type="text" class="TextInput BookAuthor" name="BookAuthor[]" autocomplete="off">
								<button Class="FormButton AddBookAuthor Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseAuthors"></div>
						</div>
						
						<div class="BookAuthorContainer SBorder HalfWidth">
							<div class="AddBookAuthorContainer flexContainer">
								<input type="text" class="TextInput BookAuthor" name="BookAuthor[]" autocomplete="off">
							</div>
							<div class="HintBox responseAuthors"></div>
						</div>
					</div>
					
					
					
					<!-- КАТЕГОРИИ -->
					<div class="FormElemContainer">
						<p class="CategoryName">Категория(и):</p>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off" required>
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
						<div class="BookCategoryContainer SBorder HalfWidth">
							<div class="AddBookCategoryContainer flexContainer">
								<input type="text" class="TextInput BookCategory" name="BookCategory[]" autocomplete="off">
							</div>
							<div class="HintBox responseCategory"></div>
						</div>
					</div>
					<div class="FormElemContainer">
							<p class="CategoryName">Краткое описание:</p>
							<textarea class="Description" name="Description1"></textarea>
					</div>
					<div class="FormElemContainer">
						<div class="uploadContainer">
							<p class="CategoryName">Файл книги</p>
							<input name="BookFile" id="BookFile" type="File" class="File">
							<label for="BookFile" class="AddFileContainer">
								<span class="LFile LFName"></span><span class="LFile LFButton">Выберите фаил</span>
							</label>
						</div>
						<div class="uploadContainer">
							<p class="CategoryName">Обложка книги</p>
							<input name="BookCover" id="BookCover" type="File" class="File">
							<label for="BookCover" class="AddFileContainer">
								<span class="LFile LFName"></span><span class="LFile LFButton">Выберите фаил</span>
							</label>
						</div>
					</div>
					<div class="FormElemContainer">
						<input name="remove" type="submit" value="Удалить" class="FormButton DeleteButton">
						<input id="submit" name="change" type="submit" value="Изменить" class="FormButton SubmitButton">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>