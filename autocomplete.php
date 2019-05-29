<?php 
	include_once "auth.php";
// Проверка, есть ли вводимый автор в таблице авторов
	if (isset($_POST['searchAuthor'])) 
	{
		$q = $connection->real_escape_string($_POST['q']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%'");
		if ($sql->num_rows > 0) 
		{
			$responseAuthors = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint authorHint'>" . $data['Name'] . "</li>";
			$responseAuthors .= "</ul>";
		}
		exit($responseAuthors);
	}
	
	//Проверка, есть ли вводимая категория в таблице категорий
	if (isset($_POST['searchCategory'])) {
		$q5 = $connection->real_escape_string($_POST['q5']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q5%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li5' class='Hint categoryHint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
 ?>