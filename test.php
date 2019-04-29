<?php 
	if (isset($_POST['search'])) {
		$response = "<ul><li>No data found!</li></ul>";

		$connection = new mysqli(host: 'vat', username: 'root', passwd: '', dbname: 'vat');
		$q = $connection->real_escape_string($_POST['q']);

		$sql = $connection->query( query: "SELECT tags FROM test WHERE tags LIKE '%$q%'");
		if ($sql->nub_rows > 0) {
			$response = "<ul>";

				while ($data = $sql->fetch_array())
					$response .= "<li>" . $data['name'] . "</li>";

			$response .= "</ul>";
		}

		
		exit($response);
	}
 ?>
<!DOCTYPE html>
<html>
	<head>
		<title>Тест</title>

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
					
					if (query.length > 2) {
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
			});
		</script>
	</body>
</html>