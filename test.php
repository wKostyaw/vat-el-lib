<?php 
	/*$file1 = 'book.pdf';
		header('Content-type: application/pdf');
		header('Content-Disposition: inline; filename="' . $file1 . '"');
		header('Content-Transfer-Encoding: binary');
		header('Accept-Ranges: bytes');
		@readfile($file1);*/

	if (isset($_POST['search'])) {
		$response = "<ul><li>No data found!</li></ul>";

		$connection = new mysqli('vat', 'root', '', 'vat');
		$q = $connection->real_escape_string($_POST['q']);

		$sql = $connection->query("SELECT Name FROM authors WHERE Name LIKE '%$q%'");
		if ($sql->num_rows > 0) {
			$response = "<ul>";

				while ($data = $sql->fetch_array())
					$response .= "<li>" . $data['Name'] . "</li>";

			$response .= "</ul>";
		}


		exit($response);
	}
 ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Тест</title>
		<style type="text/css">
			 ul {
			 	float: left;
			 	list-style: none;
			 	padding: 0px;
			 	border: 1px solid black;
			 	margin-top: 0px;
			 }
			 input, ul {
			 	width: 250px;
			 }
			 li:hover {
			 	color: white;
			 	background: #0088cc;
			 }
		</style>
	</head>
	<body>
		<input type="text" name="SearchBox">			
		<div id="response"></div>
		<script 
			src="Js/JQuerry.js" type="text/javascript">
		</script>
		<script type="text/javascript">
			$(document).ready(function() {
				$(document).ready(), function() {
	// autocomplete для категорий
	// 1
				$("#SearchBoxCategory1").keyup(function() {
					var query5 = $("#SearchBoxCategory1").val();
					
					if (query5.length > 0) {
						$.ajax (
							{
								url: 'autocomplete.php',
								method: 'POST',
								data: {
									search5: 1,
									q5: query5
								},
								success: function (data) {
									$("#responseCategory1").html(data);
								},
								dataType: 'text'
							}
						);			
					}
				});

				$(document).on('click', '#li5', function (){
					var Category1 = $(this).text();
					$("#SearchBoxCategory1").val(Category1);
					$("#responseCategory1").html("");
				});
			}();
		</script>
		<a href="PDFjs/web/viewer.html?file=../../Files/kniga.pdf">read</a>
		<iframe src="PDFjs/web/viewer.html?file=../../Files/Пособие для занятий по русскому языку в старших классах2002.pdf" width="1000px" height="1000px;"></iframe>
	</body>
</html>