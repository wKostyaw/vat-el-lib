<?php
	include_once "auth.php";
	function sliderBookAuthors($connection, $BookIdValue) 
	{ // Авторы книги
		$sqlbookauthors = $connection->query("SELECT AuthorID FROM books_and_authors WHERE BookID LIKE '$BookIdValue'");
		$BookAuthors = array();
		$i = 0;
		while ($BookAuthorsId = $sqlbookauthors -> fetch_assoc()) {
			$AuthorID = $BookAuthorsId["AuthorID"];
			$sqlauthors = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE '$AuthorID'");
				$AuthorName = $sqlauthors->fetch_assoc();
				$BookAuthors[$i] = $AuthorName["Name"];
				$i = $i + 1;
		} 
		$BookAuthors = implode(', ',$BookAuthors); 
		return $BookAuthors;
	}
	
	function sliderBookCategories($connection, $BookIdValue) 
	{ // Категории книги
		$sqlbookcategories = $connection->query("SELECT CategoryID FROM books_and_categories WHERE BookID LIKE '$BookIdValue'");
		$BookCategories = array();
		$i = 0;
		while ($BookCategoriesId = $sqlbookcategories -> fetch_assoc()) {
			$CategoryID = $BookCategoriesId["CategoryID"];
			$sqlcategory = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE '$CategoryID'");
				$CategoryName = $sqlcategory->fetch_assoc();
				$BookCategories[$i] = $CategoryName["Category"];
				$i = $i + 1;
		}
		$BookCategories = implode(', ',$BookCategories);
		return $BookCategories;
	}
	
	if (isset($_POST['SliderRequest'])) {
		$sqlSliderInfo = $connection->query("SELECT * FROM slideroptions");
		$slidersInfo = array();
		$i = 0;
		while ($sliderInfo = $sqlSliderInfo->fetch_assoc()) {
			$sliderId = $sliderInfo['sliderId'];
			$whatToDo = $sliderInfo['whatToDo'];
			$catOrAutId = $sliderInfo['categoryOrAuthorID'];
			$catOrAutName = 'Последние добавленные книги';
			
			if ($whatToDo == 1) {
				$sqlAuthorInfo = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE $catOrAutId");
				$catOrAutName = 'Автор: ' . $sqlAuthorInfo->fetch_assoc()['Name'];
			} else if ($whatToDo == 2) {
				$sqlCategoryInfo = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE $catOrAutId");
				$catOrAutName = 'Категория: ' .$sqlCategoryInfo->fetch_assoc()['Category'];
			}
			$sliderInfo['catOrAutName'] = $catOrAutName;
			$slidersInfo[$i] = $sliderInfo;
			$i = $i + 1;
		}
		$slidersInfo = json_encode($slidersInfo);
		exit ($slidersInfo);
	}
	
	if (isset($_POST['SliderLastItemRequest'])) 
	{
		$Amount = $_POST['SliderLastItemRequest'];
		$LastBooks = array();
		$j = 0;
		
		$sqlbook = $connection->query("SELECT * FROM books ORDER BY BookID DESC LIMIT $Amount") or die;
		while($BookInfo = $sqlbook-> fetch_assoc())
		{
			$BookIdValue = $BookInfo["BookID"];
			$BookInfo['BookAuthors'] = sliderBookAuthors($connection, $BookIdValue);
			$BookInfo['BookCategories'] = sliderBookCategories($connection, $BookIdValue);
			$LastBooks[$j] = $BookInfo;
			$j = $j + 1;
		}
		$LastBooks = json_encode($LastBooks);
		exit($LastBooks);
	}
		
	if (isset($_POST['SliderCategoryRequest'])) 
	{
		$Amount = ($_POST['SliderAmountOfItems']);
		$SelectedCategoryId = ($_POST['SliderCategoryRequest']);
		$ListOfBooks = array();
		$j = 0;
		$sqlbookIds = $connection->query("SELECT BookID FROM books_and_categories WHERE CategoryID LIKE '$SelectedCategoryId' LIMIT $Amount") or die;
		while($BookId = $sqlbookIds-> fetch_assoc()) 
		{
			$BookIdValue = $BookId['BookID'];
			$sqlbook = $connection->query("SELECT * FROM books WHERE BookID LIKE '$BookIdValue'");
			$BookInfo = $sqlbook-> fetch_assoc();
			$BookInfo['BookAuthors'] = sliderBookAuthors($connection, $BookIdValue);
			$BookInfo['BookCategories'] = sliderBookCategories($connection, $BookIdValue);
			$ListOfBooks[$j] = $BookInfo;
			$j = $j + 1;
		}
		$ListOfBooks = json_encode($ListOfBooks);
		exit($ListOfBooks);
	}
	if (isset($_POST['SliderAuthorRequest'])) 
	{
		$Amount = ($_POST['SliderAmountOfItems']);
		$SelectedAuthorId = ($_POST['SliderAuthorRequest']);
		$ListOfBooks = array();
		$j = 0;
		$sqlbookIds = $connection->query("SELECT BookID FROM books_and_authors WHERE AuthorID LIKE '$SelectedAuthorId' LIMIT $Amount") or die;
		while($BookId = $sqlbookIds-> fetch_assoc()) 
		{
			$BookIdValue = $BookId['BookID'];
			$sqlbook = $connection->query("SELECT * FROM books WHERE BookID LIKE '$BookIdValue'");
			$BookInfo = $sqlbook-> fetch_assoc();
			$BookInfo['BookAuthors'] = sliderBookAuthors($connection, $BookIdValue);
			$BookInfo['BookCategories'] = sliderBookCategories($connection, $BookIdValue);
			$ListOfBooks[$j] = $BookInfo;
			$j = $j + 1;
		}
		$ListOfBooks = json_encode($ListOfBooks);
		exit($ListOfBooks);
	}
	
	
	
	header('Location: MainPage.php');
	exit();
?>