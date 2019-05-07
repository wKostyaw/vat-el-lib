<?php 
// Проверка, есть ли вводимый автор в таблице авторов
	if (isset($_POST['search'])) {
		$responseAuthors = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q = $connection->real_escape_string($_POST['q']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%'");
		if ($sql->num_rows > 0) {
			$responseAuthors = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseAuthors .= "<li id='li0' class='Hint'>" . $data['Name'] . "</li>";
			$responseAuthors .= "</ul>";
		}
		exit($responseAuthors);
	}
	if (isset($_POST['search1'])) {
		$responseAuthors1 = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q1 = $connection->real_escape_string($_POST['q1']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q1%'");
		if ($sql->num_rows > 0) {
			$responseAuthors1 = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseAuthors1 .= "<li id='li1' class='Hint'>" . $data['Name'] . "</li>";
			$responseAuthors1 .= "</ul>";
		}
		exit($responseAuthors1);
	}
	if (isset($_POST['search2'])) {
		$responseAuthors2 = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q2 = $connection->real_escape_string($_POST['q2']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q2%'");
		if ($sql->num_rows > 0) {
			$responseAuthors2 = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseAuthors2 .= "<li id='li2' class='Hint'>" . $data['Name'] . "</li>";
			$responseAuthors2 .= "</ul>";
		}
		exit($responseAuthors2);
	}
	if (isset($_POST['search3'])) {
		$responseAuthors3 = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q3 = $connection->real_escape_string($_POST['q3']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q3%'");
		if ($sql->num_rows > 0) {
			$responseAuthors3 = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseAuthors3 .= "<li id='li3' class='Hint'>" . $data['Name'] . "</li>";
			$responseAuthors3 .= "</ul>";
		}
		exit($responseAuthors3);
	}
	if (isset($_POST['search4'])) {
		$responseAuthors4 = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q4 = $connection->real_escape_string($_POST['q4']);
		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q4%'");
		if ($sql->num_rows > 0) {
			$responseAuthors4 = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseAuthors4 .= "<li id='li4' class='Hint'>" . $data['Name'] . "</li>";
			$responseAuthors4 .= "</ul>";
		}
		exit($responseAuthors4);
	}
	//Проверка, есть ли вводимая категория в таблице категорий
	if (isset($_POST['search5'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q5 = $connection->real_escape_string($_POST['q5']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q5%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li5' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search6'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q6 = $connection->real_escape_string($_POST['q6']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q6%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li6' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search7'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q7 = $connection->real_escape_string($_POST['q7']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q7%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li7' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search8'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q8 = $connection->real_escape_string($_POST['q8']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q8%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li8' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search9'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q9 = $connection->real_escape_string($_POST['q9']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q9%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li9' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search10'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q10 = $connection->real_escape_string($_POST['q10']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q10%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li10' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search11'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q11 = $connection->real_escape_string($_POST['q11']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q11%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li11' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search12'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q12 = $connection->real_escape_string($_POST['q12']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q12%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li12' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search13'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q13 = $connection->real_escape_string($_POST['q13']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q13%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li13' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
	if (isset($_POST['search14'])) {
		$responseCategory = "<ul><li>No data found!</li></ul>";
		$connection = new mysqli('vat', 'root', '', 'vat');
		$q14 = $connection->real_escape_string($_POST['q14']);
		$sql = $connection->query("SELECT Category FROM categories WHERE Category LIKE '%$q14%'");
		if ($sql->num_rows > 0) {
			$responseCategory = "<ul class='HintList'>";
				while ($data = $sql->fetch_array())
					$responseCategory .= "<li id='li14' class='Hint'>" . $data['Category'] . "</li>";
			$responseCategory .= "</ul>";
		}
		exit($responseCategory);
	}
 ?>