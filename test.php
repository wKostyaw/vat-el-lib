<?php 
	if (isset($_POST['search'])) {
		$response = "<ul><li>No data found!</li></ul>";

		$connection = new mysqli('vat', 'root', '', 'vat');
		$q = $connection->real_escape_string($_POST['q']);

		$sql = $connection->query("SELECT tags FROM test WHERE tags LIKE '%$q%'");
		if ($sql->num_rows > 0) {
			$response = "<ul>";

				while ($data = $sql->fetch_array())
					$response .= "<li>" . $data['tags'] . "</li>";

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
		<input type="text" id="SearchBox">
		<div id="response"></div>
		<script 
			src="js/JQuerry.js" type="text/javascript"></script>
		<script type="text/javascript">
			$(document).ready(function () {
				$("#SearchBox").keyup(function() {
					var query = $("#SearchBox").val();
					
					if (query.length > 0) {
						$.ajax (
							{
								url: 'test.php',
								method: 'POST',
								data: {
									search: 1,
									q: query
								},
								success: function (data) {
									$("#response").html(data);
								},
								dataType: 'text'
							}
						);			
					}
				});

				$(document).on('click', 'li', function (){
					var author = $(this).text();
					$("#SearchBox").val(author);
					$("#response").html("");
				}) 
			});
		</script>
	</body>
</html>