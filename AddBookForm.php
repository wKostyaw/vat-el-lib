<?php
	include_once "auth.php";
	// Проверка на админа
	$username = $_SESSION['login'];
	$admin = ("SELECT admin FROM loginparol WHERE login='$username'");
	$result = $connection->query ($admin);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$isAdmin = $row["admin"];
		}
	}
	if ($isAdmin == 0) {
		header('Location: MainPage.php');
		exit();
	}
	// Заливка книги
	if (isset($_POST['submit'])) {
		$BookName = $_POST['BookName'];
		$BookYear = $_POST['BookYear'];
		$Description1 = $_POST['Description1'];
		$BookAuthors = $_POST['BookAuthor'];
		$BookCategories = $_POST['BookCategory'];
		print_r($BookCategories);
		print_r($BookAuthors);
		// заливка обложки
		if(is_uploaded_file($_FILES["BookCover"]["tmp_name"])) {
			$extension_cover = pathinfo($_FILES["BookCover"]["name"], PATHINFO_EXTENSION);
			$new_cover_name = $BookName. $BookYear. '.'. $extension_cover;
			move_uploaded_file($_FILES["BookCover"]["tmp_name"], "Covers/". $new_cover_name);
			$PathToCover = "Covers/". $new_cover_name;
		} else {
			echo "Ошибка загрузки обложки" . "</br>";
			$PathToCover = "Img/BookDefault.png";
		}
		// заливка файла книги
		if(is_uploaded_file($_FILES["BookFile"]["tmp_name"])) {
			$extension = pathinfo($_FILES["BookFile"]["name"], PATHINFO_EXTENSION);
			$new_name = $BookName. $BookYear. '.'. $extension;
			move_uploaded_file($_FILES["BookFile"]["tmp_name"], "Files/". $new_name);
			$PathToFile = "Files/". $new_name;
			$i = 1;
		} else {
			echo "Ошибка загрузки файла" . "</br>";
			$i = 0;
		}
		if ($i == 1) {
			
			$query = "INSERT INTO books (BookName, BookYear, Description, PathToFile, PathToCover) VALUES ('$BookName', '$BookYear', '$Description1', '$PathToFile', '$PathToCover')";
			$result = mysqli_query ($connection, $query);
			if ($result) {
				echo '<script type="text/javascript">';
				echo 'alert("Книга успешно добавлена")';
				echo '</script>';
			} else {
				echo '<script type="text/javascript">';
				echo 'alert("Ошибка!")';
				echo '</script>';
			}
			
			// Обработчик связи таблиц авторов и книг для инпута авторов
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
		} else {
			echo "Загрузите файл";
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Добавить книгу</title>
		<link rel="stylesheet" type="text/css" href="Css/AdminPage.css">
		<link rel="stylesheet" type="text/css" href="Css/AddBookForm.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script src="Js/AddOneMore.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<div class="LogoContainer">
					<img src="Img/WorkInProgress.png" class="Logo">
				</div>
					<ul class="AdminLinks">
						<li class="AdminLinkBox"><a href="mainpage.php" class="AdminLink">На сайт</a></li>
						<li class="AdminLinkBox"><a href="AddUserForm.php" class="AdminLink">Добавить пользователя</a></li>
						<li class="AdminLinkBox"><a href="ChangeUser.php" class="AdminLink">Изменить/удалить пользователя</a></li>
						<li class="AdminLinkBox"><a href="AddBookForm.php" class="AdminLink">Добавить книгу</a></li>
						<li class="AdminLinkBox"><a href="ChangeBook.php" class="AdminLink">Изменить/удалить книгу</a></li>
						<li class="AdminLinkBox"><a href="InfoAboutUsers.php" class="AdminLink">Информация о пользователях</a></li>
						<li class="AdminLinkBox"><a href="InfoAboutBooks.php" class="AdminLink">Информация о книгах</a></li>
						<li class="AdminLinkBox"><a href="CustomizeSlider.php" class="AdminLink">Настройка главной страницы</a></li>
						<li class="AdminLinkBox"><a href="#" class="AdminLink" onclick="document.location.replace('?exit');">Выход</a></li>
					</ul>
			</div>
			<div class="Option">
				<h2 class="MainHeader">Добавить книгу</h2>
				<form class="AddBookForm" method="POST" enctype="multipart/form-data">
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
						<input type="reset" value="Очистить" class="FormButton ResetButton">
						<input id="submit" name="submit" type="submit" value="Добавить" class="FormButton SubmitButton">
					</div>
				</form>
			</div>
		</div>
	</body>
</html>