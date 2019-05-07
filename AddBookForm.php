<?php
	require "auth.php";
	// Проверка на админа
	$username = $_SESSION['login'];
	$admin = ("SELECT admin FROM loginparol WHERE login='$username'");
	$result = $connection->query ($admin);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$kek = $row["admin"] ;
		}
	}
	if ($kek == 0) {
		header('Location: MainPage.php');
		exit();
	}
	// Заливка книги
	if (isset($_POST['submit'])) {
		$BookName = $_POST['BookName'];
		$BookYear = $_POST['BookYear'];
		if($_POST['BookAutor']) {
			$count = count($_POST['BookAutor'])-1;
			foreach ($_POST['BookAutor'] as $key => $_POST['BookAutor']) {
    			if ($key != $count) {
					$BookAutors = $BookAutors.  $_POST['BookAutor']. ', ';
				} else {
					$BookAutors = $BookAutors.  $_POST['BookAutor'];
				}
			}
		}
		if($_POST['BookCategory']) {
			$count = count($_POST['BookCategory'])-1;
			foreach ($_POST['BookCategory'] as $key => $_POST['BookCategory']) {
    			if ($key != $count) {
					$BookCategories = $BookCategories.  $_POST['BookCategory']. ', ';
				} else {
					$BookCategories = $BookCategories.  $_POST['BookCategory'];
				}
			}
		}
		if(is_uploaded_file($_FILES["filename"]["tmp_name"])) {
			$extension = pathinfo($_FILES["filename"]["name"], PATHINFO_EXTENSION);
			$new_name = $BookName. $BookYear. '.'. $extension;
			move_uploaded_file($_FILES["filename"]["tmp_name"], "Files/". $new_name);
			$i = 1;
		} else {
			echo "Ошибка загрузки файла" . "</br>";
			$i = 0;
		}
		if ($i == 1) {
			$PathToFile = "Files/". $new_name;
			$query = "INSERT INTO books (BookName, BookYear, BookAutors, BookCategories, PathToFile) VALUES ('$BookName', '$BookYear', '$BookAutors', '$BookCategories', '$PathToFile')";
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
		} else {
			echo "Загрузите файл";
		}
	}
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
				<h2 class="MainHeader">Добавить книгу</h2>
				<form class="AddBookForm" method="POST" enctype="multipart/form-data">
					<div class="Category">
							<p class="CategoryName">Название Книги</p>
							<input type="text" class="TextInput BookName" name="BookName" required>
					</div>
					<div class="Category">
							<p class="CategoryName">Год</p>
							<input type="text" name="BookYear" class="TextInput BookYear" required>
					</div>
					<!-- АВТОРЫ -->
					<div class="Category">
						<p class="CategoryName">Автор(ы):</p>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik" id="testik1">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox1" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors1" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox2" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors2" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox3" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors3" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox4" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
						<div id="responseAuthors4" class="HintBox"></div>
						</div>
					</div>
					<!-- КАТЕГОРИИ -->
					<div class="Category">
						<p class="CategoryName">Категория(и):</p>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory1" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory1" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory2" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory2" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory3" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory3" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory4" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory4" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory5" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory5" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory6" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory6" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory7" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory7" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory8" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory8" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory9" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory9" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory10" class="TextInput TagSearch">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory10" class="HintBox"></div>
							<br>
						</div>
					</div>
					<div class="Category">
							<p class="CategoryName">Краткое описание:</p>
							<textarea class="Description"></textarea>
					</div>
					<div class="Category">
							<p class="CategoryName">Загрузка файла</p>
							<input name="BookFile" id="BookFile" type="File" class="File">
							<label for="BookFile" class="AddFileContainer">
							<span class="LFile LFName"></span><span class="LFile LFButton">Выберите фаил</span>
							</label>
					</div>
					<div class="Category">
						<input type="reset" value="Очистить" class="FormButton ResetButton">
						<input name="submit" type="submit" value="Добавить" class="FormButton SubmitButton">
					</div>
				</form>
			</div>
		</div>
	</body>
	<script src="js/JQuerry.js" type="text/javascript"></script>
	<script src="js/AddOneMore.js" type="text/javascript"></script>
</html>