<?php
	$servername = "localhost";
	$username = "root";
	$password = "root";
	$dbname = "cats";

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "SELECT * FROM kitties";
	$result = $conn->query($sql);

?>

<html>
<head>
	<title>Kitties</title>
	<style type="text/css">
		img {
			display: block;
			max-height: 200px;
			max-width: 200px;
		}
		.cat {
			width:auto;
			max-width: 250px;
			min-height: 250px;
			float:left;
			border:1px solid red;
			padding:10px;
		}
	</style>
</head>
<body>
	<h1>Kitties</h1>
	<div>
		<?php
			if($result->num_rows > 0){
				echo "<div class='wrapper'>\n";
				while($row = $result -> fetch_assoc()){
					/*print_r($row);*/
					echo "<div class='cat'>\n";
					echo "\t<div><strong>" . $row['name'] . " </strong></div>\n";
					echo "\t<div class='text'>" .  $row['comments']  . " </div>\n";
					echo "\t<div><img src='kittens/" . $row['image']  . "'></div>\n";
					echo "</div>\n";
				}
				echo "</div>";
			}
		?>
	</div>
</body>
</html>