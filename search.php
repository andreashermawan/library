

<?php
// search on mysql database
print_r($_POST);
echo "books".isset($_POST['book_country']);
if(isset($_POST['book_country']) || isset($_POST['book_author']) || isset($_POST['book_title'])){
	$book_title = filter_var($_POST['book_title'], FILTER_SANITIZE_STRING);
	$book_author = filter_var($_POST['book_author'], FILTER_SANITIZE_STRING);
	$book_country = filter_var($_POST['book_country'], FILTER_SANITIZE_STRING);
	
	if (empty($book_title)){
		$book_title = "-1";
	}
	if (empty($book_author)){
		$book_author = "-1";
	}
	if (empty($book_country)){
		$book_country = "-1";
	}

	require('dvconnect.inc.php');



	$conn = new mysqli($host, $db_user, $db_password, $dbname);
	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}
echo "x";
	$sql = "SELECT * FROM books WHERE title LIKE '%$book_title%' or author LIKE '%$book_author%' or country LIKE '%$book_country%'";
	echo $sql;
	/* strict
	$sql = "SELECT * FROM books WHERE title = '$book_title'";
	*/
	$result = $conn->query($sql);
	echo "did we die?" . $result->error;
	print_r($result);
	if($result->num_rows > 0){
		while($row = $result -> fetch_assoc()){
			echo "hello";
			print_r($row);
		}

	}
	
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>search books</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
  </head>
	<body>
		<div class="content container">
		  <h2>Search</h2>
		    <div class="content">
		        <form class="search-form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
		        	<div class="col-md-4">
						<label class="entrada" for="">Search by Author</label>
						<input class="col-md-12" type="text" name="book_author">
					</div>
					<div class="col-md-4">
						<label class="entrada" for="">Search by Title</label>
						<input class="col-md-12" type="text" name="book_title">
					</div>
					<div class="col-md-4">
						<label class="entrada" for="">Search by Country</label>
						<input class="col-md-12" type="text" name="book_country">
					</div>
					<!-- <button type="submit">go</button> -->
					<div class="col-md-12 entrada">
		                <button class="btn btn-lg" type="submit">Go</button>
		            </div>
				</form>
		    </div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>
	</body>
</html>