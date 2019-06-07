<?php
	include_once "auth.php";
	// Проверка на админа
	$username = $_SESSION['login'];
	$admin = ("SELECT admin FROM loginparol WHERE login='$username'");
	$result = $connection->query ($admin);
	if ($result->num_rows > 0) {
		while ($row = $result->fetch_assoc()) {
			$kek = $row["admin"] ;
		}
	}
	if ($kek != 1) {
		header('Location: MainPage.php');
		exit();
	}
	
	function drawingList($sliderId, $whatToDo, $catOrAutName, $amount, $connection) {
		
		echo '<div class="sliderBox flexContainer">';
			echo '<span class="SBCell">';
				if ($whatToDo == 0) {
					echo '<span class="SBText">Последние загруженные книги</span>';
				} else if ($whatToDo == 1) {
					echo '<span class="SBText">Книги автора: </span>';
					echo '<span class="SBText">' . $catOrAutName . '</span>';
				} else if ($whatToDo == 2) {
					echo '<span class="SBText">Книги категории: </span>';
					echo '<span class="SBText">' . $catOrAutName . '</span>';
				}
			echo '</span>';
				echo '<span class="SBSpace"></span>';
				echo '<span class="SBCell">';
				echo '<span class="SBText">Максимальное количество элементов: </span>';
				echo '<span class="SBText">' . $amount .  '</span>';
			echo '</span>';
			echo '<button type="button" id="' . $sliderId . '" Class="deleteSlider" title="удалить" id="SlId">';
				echo '<svg class="SButtonIcon" x="0px" y="0px" width="16" height="16" viewBox="0 0 192 192">';
					echo '<path d="M45.65625,34.34375l-11.3125,11.3125l50.34375,50.34375l-50.34375,50.34375l11.3125,11.3125l50.34375,-50.34375l50.34375,50.34375l11.3125,-11.3125l-50.34375,-50.34375l50.34375,-50.34375l-11.3125,-11.3125l-50.34375,50.34375z"></path>';
				echo '</svg>';
			echo '</button>';
		echo '</div>';
	}
	function collectInfo($connection) {
		$sqlSliderInfo = $connection->query("SELECT * FROM slideroptions");
		while ($sliderInfo = $sqlSliderInfo->fetch_assoc()) {
			$sliderId = $sliderInfo['sliderId'];
			$amount = $sliderInfo['amount'];
			$whatToDo = $sliderInfo['whatToDo'];
			$catOrAutId = $sliderInfo['categoryOrAuthorID'];
			$catOrAutName = '';
			
			if ($whatToDo == 1) {
				$sqlAuthorInfo = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE $catOrAutId");
				$catOrAutName = $sqlAuthorInfo->fetch_assoc()['Name'];
			} else if ($whatToDo == 2) {
				$sqlCategoryInfo = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE $catOrAutId");
				$catOrAutName = $sqlCategoryInfo->fetch_assoc()['Category'];
			}
			drawingList($sliderId, $whatToDo, $catOrAutName, $amount, $connection);
		}
	}
	if (isset($_POST['refreshSliderInfo'])) {
		$i = 1;
		$Sliders = array();
		$sqlSliderInfo = $connection->query("SELECT * FROM slideroptions");
		while ($sliderInfo = $sqlSliderInfo->fetch_assoc()) {
			$catOrAutId = $sliderInfo['categoryOrAuthorID'];
			$catOrAutName = '';
			$whatToDo = $sliderInfo['whatToDo'];
			if ($whatToDo == 1) {
				$sqlAuthorInfo = $connection->query("SELECT Name FROM authors WHERE AuthorID LIKE $catOrAutId");
				$catOrAutName = $sqlAuthorInfo->fetch_assoc()['Name'];
			} else if ($whatToDo == 2) {
				$sqlCategoryInfo = $connection->query("SELECT Category FROM categories WHERE CategoryID LIKE $catOrAutId");
				$catOrAutName = $sqlCategoryInfo->fetch_assoc()['Category'];
			}
			
			$Sliders[$i]['sliderId'] = $sliderInfo['sliderId'];
			$Sliders[$i]['amount'] = $sliderInfo['amount'];
			$Sliders[$i]['whatToDo'] = $whatToDo;
			$Sliders[$i]['categoryOrAuthorID'] = $sliderInfo['categoryOrAuthorID'];
			$Sliders[$i]['catOrAutName'] = $catOrAutName;
			$i = $i + 1;
		}
		$Sliders = json_encode($Sliders);
		exit($Sliders);
	}
	
	if (isset($_POST['delSlider'])) {
		$SliderId = $_POST['SliderId'];
		$SqlDel = $connection->query("DELETE FROM slideroptions WHERE Sliderid = $SliderId");
		collectInfo($connection);
	}
	
	if (isset($_POST['addNewSlider'])) {
		$whatToDo = $_POST['whatToDo'];
		$amount = $_POST['amount'];
		$sliderName = $_POST['sliderName'];
		if ($amount == "") {
			$amount = 25;
		}
		if ($whatToDo == 0) {
			$catOrAutId = 0;
		} else if ($whatToDo == 1) {
			$sqlcatOrAutId = $connection->query("SELECT AuthorID FROM authors WHERE Name LIKE '$sliderName'");
			$catOrAutId = $sqlcatOrAutId->fetch_assoc()['AuthorID'];
		} else if ($whatToDo == 2) {
			$sqlcatOrAutId = $connection->query("SELECT CategoryID FROM categories WHERE Category LIKE '$sliderName'");
			$catOrAutId = $sqlcatOrAutId->fetch_assoc()['CategoryID'];
		}

		$query = "INSERT INTO slideroptions (amount, whatToDo, categoryOrAuthorID) VALUES ('$amount', '$whatToDo', '$catOrAutId')";
		$sqlSlider = mysqli_query ($connection, $query);
	}
	
	
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Настройки слайдеров</title>
		<link rel="stylesheet" type="text/css" href="Css/AdminPage.css">
		<link rel="stylesheet" type="text/css" href="Css/sliderCustomize.css">
		<script src="Js/JQuerry.js" type="text/javascript"></script>
		<script src="Js/SliderCustomize.js" type="text/javascript"></script>
		<script src="Js/AddOneMore.js" type="text/javascript"></script>
	</head>
	<body>
		<div class="Wrapper">
			<div class="Sidebar">
				<? include_once "AdminNavigation.php"; ?>
			</div>
			<div class="Option">
				<h2 class="MainHeader">Настройки слайдеров</h2>
				<form class="sliderOptions">
					<div class="FormElemContainer">
						<p>Содержание:</p>
						<select class="sliderOptField HalfWidth whatToDo" name="whatToDo">
							<option value="0">Последние добавленные книги</option>
							<option value="1">Автор</option>
							<option value="2">Категория</option>
						</select>
					</div>
					<div class="FormElemContainer SOHide">
						<p>[Название категории/Имя автора]: </p>
						<div class="sliderNameContainer SBorder HalfWidth">
							<div class="flexContainer">
								<input type="text" name="sliderName" class="TextInput sliderOptField sliderName" autocomplete="off">
							</div>
							<div class="HintBox responseAuthors"></div>
							<div class="HintBox responseCategory"></div>
						</div>
					</div>
					<div class="FormElemContainer">
						<p>Максимальное количество элементов: </p>
						<input placeholder="25" type="text" name="amount" class="TextInput amount sliderOptField HalfWidth">
					</div>
					<div class="FormElemContainer">
						<button type="reset" class="FormButton ResetButton">Очистить</button>
						<button type="button" id="AddSlider" class="FormButton SubmitButton">Добавить</button>
					</div>
				</form>
				<div class="FormElemContainer" id="SliderPreview">
					<!-- Шаблон строки
					
						<div class="sliderBox flexContainer">
						<span class="SBCell">
							<span class="SBText">[Тип]</span>
							<span class="SBText">[Название категории/имя автора]</span>
							<span class="SBSpace"></span>
						</span>
						<span class="SBCell">
							<span class="SBText">Количество элементов: </span>
							<span class="SBText">40</span>
						</span>
						<button type="button" Class="deleteSlider" title="удалить" id="SlId">
							<svg class="SButtonIcon" x="0px" y="0px" width="16" height="16" viewBox="0 0 192 192">
								<path d="M45.65625,34.34375l-11.3125,11.3125l50.34375,50.34375l-50.34375,50.34375l11.3125,11.3125l50.34375,-50.34375l50.34375,50.34375l11.3125,-11.3125l-50.34375,-50.34375l50.34375,-50.34375l-11.3125,-11.3125l-50.34375,50.34375z"></path>
							</svg>
						</button>
					</div>-->
					<?php
						collectInfo($connection);
					?>
				</div>
			</div>
		</div>
	</body>
</html>