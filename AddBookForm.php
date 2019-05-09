<?php
	require "auth.php";
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
		$BookAuthor = $_POST['BookAuthor1'];
		$BookAuthor2 = $_POST['BookAuthor2'];
		$BookAuthor3 = $_POST['BookAuthor3'];
		$BookAuthor4 = $_POST['BookAuthor4'];
		$BookAuthor5 = $_POST['BookAuthor5'];
		$BookCategory = $_POST['BookCategory1'];
		$BookCategory2 = $_POST['BookCategory2'];
		$BookCategory3 = $_POST['BookCategory3'];
		$BookCategory4 = $_POST['BookCategory4'];
		$BookCategory5 = $_POST['BookCategory5'];
		$BookCategory6 = $_POST['BookCategory6'];
		$BookCategory7 = $_POST['BookCategory7'];
		$BookCategory8 = $_POST['BookCategory8'];
		$BookCategory9 = $_POST['BookCategory9'];
		$BookCategory10 = $_POST['BookCategory10'];
		if(is_uploaded_file($_FILES["BookFile"]["tmp_name"])) {
			$extension = pathinfo($_FILES["BookFile"]["name"], PATHINFO_EXTENSION);
			$new_name = $BookName. $BookYear. '.'. $extension;
			move_uploaded_file($_FILES["BookFile"]["tmp_name"], "Files/". $new_name);
			$i = 1;
		} else {
			echo "Ошибка загрузки файла" . "</br>";
			$i = 0;
		}
		if ($i == 1) {
			$PathToFile = "Files/". $new_name;
			$query = "INSERT INTO books (BookName, BookYear, PathToFile) VALUES ('$BookName', '$BookYear', '$PathToFile')";
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
			// Обработчик связи таблиц авторов и книг для первого инпута авторов
			$isAuthorExists1 = $connection->query("SELECT count(*) FROM authors WHERE name = '$BookAuthor'");
			$row1 = mysqli_fetch_row($isAuthorExists1);
			if ($row1[0] > 0) {
				// автор уже есть в таблице
				$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
				$result = $connection->query($fatchBookId);
				if ($result->num_rows > 0) {
				    // подбирает id заливаемой книги
				    while($row = $result->fetch_assoc()) {
				    	$BookId = $row["BookID"];
				    }
				} 
				$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor'");
				$result = $connection->query($fatchAuthorId);
				if ($result->num_rows > 0) {
				    // подбирает id автора книги
				    while($row = $result->fetch_assoc()) {
				    	$AuthorId = $row["AuthorID"];
				    }
				} 
				$link = "INSERT INTO books_and_authors (BookID, AuthorID) VALUES ('$BookId', '$AuthorId')";
				$result = $connection->query($link);
			} else {
				// автора нет в талице
				// заливка нового автора
				$insertNewAuthor = "INSERT INTO authors (Name) VALUES ('$BookAuthor')";
				$result = $connection->query($insertNewAuthor);
				// связь
				$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
				$result = $connection->query($fatchBookId);
				if ($result->num_rows > 0) {
				    // подбирает id заливаемой книги
				    while($row = $result->fetch_assoc()) {
				    	$BookId = $row["BookID"];
				    }
				} 
				$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor'");
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
			// Обработчик связи для второго интупа авторов
			if ($BookAuthor2 != '') {
				$isAuthorExists1 = $connection->query("SELECT count(*) FROM authors WHERE name = '$BookAuthor2'");
				$row1 = mysqli_fetch_row($isAuthorExists1);
				if ($row1[0] > 0) {
					// автор уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor2'");
					$result = $connection->query($fatchAuthorId);
					if ($result->num_rows > 0) {
					    // подбирает id автора книги
					    while($row = $result->fetch_assoc()) {
					    	$AuthorId = $row["AuthorID"];
					    }
					} 
					$link = "INSERT INTO books_and_authors (BookID, AuthorID) VALUES ('$BookId', '$AuthorId')";
					$result = $connection->query($link);
				} else {
					// автора нет в талице
					// заливка нового автора
					$insertNewAuthor = "INSERT INTO authors (Name) VALUES ('$BookAuthor2')";
					$result = $connection->query($insertNewAuthor);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor2'");
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
			// Обработчик связи для третьего интупа авторов
			if ($BookAuthor3 != '') {
				$isAuthorExists1 = $connection->query("SELECT count(*) FROM authors WHERE name = '$BookAuthor3'");
				$row1 = mysqli_fetch_row($isAuthorExists1);
				if ($row1[0] > 0) {
					// автор уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor3'");
					$result = $connection->query($fatchAuthorId);
					if ($result->num_rows > 0) {
					    // подбирает id автора книги
					    while($row = $result->fetch_assoc()) {
					    	$AuthorId = $row["AuthorID"];
					    }
					} 
					$link = "INSERT INTO books_and_authors (BookID, AuthorID) VALUES ('$BookId', '$AuthorId')";
					$result = $connection->query($link);
				} else {
					// автора нет в талице
					// заливка нового автора
					$insertNewAuthor = "INSERT INTO authors (Name) VALUES ('$BookAuthor3')";
					$result = $connection->query($insertNewAuthor);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor3'");
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
			// Обработчик связи для четвертого интупа авторов
			if ($BookAuthor4 != '') {
				$isAuthorExists1 = $connection->query("SELECT count(*) FROM authors WHERE name = '$BookAuthor4'");
				$row1 = mysqli_fetch_row($isAuthorExists1);
				if ($row1[0] > 0) {
					// автор уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor4'");
					$result = $connection->query($fatchAuthorId);
					if ($result->num_rows > 0) {
					    // подбирает id автора книги
					    while($row = $result->fetch_assoc()) {
					    	$AuthorId = $row["AuthorID"];
					    }
					} 
					$link = "INSERT INTO books_and_authors (BookID, AuthorID) VALUES ('$BookId', '$AuthorId')";
					$result = $connection->query($link);
				} else {
					// автора нет в талице
					// заливка нового автора
					$insertNewAuthor = "INSERT INTO authors (Name) VALUES ('$BookAuthor4')";
					$result = $connection->query($insertNewAuthor);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor4'");
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
			// Обработчик связи для пятого интупа авторов
			if ($BookAuthor5 != '') {
				$isAuthorExists1 = $connection->query("SELECT count(*) FROM authors WHERE name = '$BookAuthor5'");
				$row1 = mysqli_fetch_row($isAuthorExists1);
				if ($row1[0] > 0) {
					// автор уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor5'");
					$result = $connection->query($fatchAuthorId);
					if ($result->num_rows > 0) {
					    // подбирает id автора книги
					    while($row = $result->fetch_assoc()) {
					    	$AuthorId = $row["AuthorID"];
					    }
					} 
					$link = "INSERT INTO books_and_authors (BookID, AuthorID) VALUES ('$BookId', '$AuthorId')";
					$result = $connection->query($link);
				} else {
					// автора нет в талице
					// заливка нового автора
					$insertNewAuthor = "INSERT INTO authors (Name) VALUES ('$BookAuthor5')";
					$result = $connection->query($insertNewAuthor);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchAuthorId =  ("SELECT AuthorID FROM authors WHERE Name = '$BookAuthor5'");
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
		//	Обработчики категорий
		if ($BookCategory != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory'");
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
		if ($BookCategory2 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory2'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory2'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory2')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory2'");
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
		if ($BookCategory3 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory3'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory3'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory3')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory3'");
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
		if ($BookCategory4 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory4'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory4'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory4')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory4'");
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
		if ($BookCategory5 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory5'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory5'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory5')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory5'");
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
		if ($BookCategory6 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory6'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory6'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory6')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory6'");
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
		if ($BookCategory7 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory7'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory7'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory7')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory7'");
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
		if ($BookCategory8 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory8'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory8'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory8')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory8'");
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
		if ($BookCategory9 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory9'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory9'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory9')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory9'");
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
		if ($BookCategory10 != '') {
				$isCategoryExists1 = $connection->query("SELECT count(*) FROM categories WHERE name = '$BookCategory10'");
				$row1 = mysqli_fetch_row($isCategoryExists1);
				if ($row1[0] > 0) {
					// категория уже есть в таблице
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory10'");
					$result = $connection->query($fatchCategoryId);
					if ($result->num_rows > 0) {
					    // подбирает id категории книги
					    while($row = $result->fetch_assoc()) {
					    	$CategoryId = $row["CategoryID"];
					    }
					} 
					$link = "INSERT INTO books_and_categories (BookID, CategoryID) VALUES ('$BookId', '$CategoryId')";
					$result = $connection->query($link);
				} else {
					// категории нет в талице
					// заливка новой категории
					$insertNewCategory = "INSERT INTO categories (Category) VALUES ('$BookCategory10')";
					$result = $connection->query($insertNewCategory);
					// связь
					$fatchBookId =  "SELECT BookID FROM books WHERE BookName = '$BookName'";
					$result = $connection->query($fatchBookId);
					if ($result->num_rows > 0) {
					    // подбирает id заливаемой книги
					    while($row = $result->fetch_assoc()) {
					    	$BookId = $row["BookID"];
					    }
					} 
					$fatchCategoryId =  ("SELECT CategoryID FROM categories WHERE Name = '$BookCategory10'");
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
							<input type="text" class="TextInput BookYear" name="BookYear" required>
					</div>
					<!-- АВТОРЫ -->
					<div class="Category">
						<p class="CategoryName">Автор(ы):</p>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox" class="TextInput TagSearch" name="BookAuthor1" required>
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik" id="testik1">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox1" class="TextInput TagSearch" name="BookAuthor2">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors1" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox2" class="TextInput TagSearch" name="BookAuthor3">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors2" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox3" class="TextInput TagSearch" name="BookAuthor4">
								<button Class="FormButton AddBookCategory Add" type="button" >
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseAuthors3" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBox4" class="TextInput TagSearch" name="BookAuthor5">
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
								<input type="text" id="SearchBoxCategory1" class="TextInput TagSearch" name="BookCategory1" required>
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory1" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory2" class="TextInput TagSearch" name="BookCategory2">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory2" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory3" class="TextInput TagSearch" name="BookCategory3">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory3" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory4" class="TextInput TagSearch" name="BookCategory4">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory4" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory5" class="TextInput TagSearch" name="BookCategory5">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory5" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory6" class="TextInput TagSearch" name="BookCategory6">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory6" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory7" class="TextInput TagSearch" name="BookCategory7">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory7" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory8" class="TextInput TagSearch" name="BookCategory8">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory8" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory9" class="TextInput TagSearch" name="BookCategory9">
								<button Class="FormButton AddBookCategory Add" type="button">
									<svg x="0px" y="0px" width="30" height="30" viewBox="0 0 192 192" style=" fill:#FFF;"><path d="M88,24v64h-64v16h64v64h16v-64h64v-16h-64v-64z"></path></svg>
								</button>
							</div>
							<div id="responseCategory9" class="HintBox"></div>
							<br>
						</div>
						<div class="Testik">
							<div class="AddTagContainer">
								<input type="text" id="SearchBoxCategory10" class="TextInput TagSearch" name="BookCategory10">
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