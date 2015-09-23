
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Library</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
  </head>
<body>
	<header>
	    <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	      <div class="container">
	        <div class="navbar-header">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#featured"><a href="index.php"><h1>Library</h1></a><span class="subhead"><h2>Literatura hispanoamericana</h2></span></a>
	        </div><!-- navbar-header -->
	        <div class="collapse navbar-collapse" id="collapse">
	          <ul class="nav navbar-nav navbar-right">
	          	<!-- <li class="active"><a href="#featured">Home</a></li> -->
	            <li><a href="search.php">Search</a></li>
	            <li><a href="books.php">Browse</a></li>
	          </ul>        
	        </div><!-- collapse navbar-collapse -->
	      </div><!-- container -->
	    </nav>
	</header>
		<div class="container-fluid">
			
			<div class="wrapper">
				<!-- <div class="row"> -->
			  		<div class="col-md-6">
			  			<img  src="images/Ay-amor.png" class="img-responsive featured-book">
			  		</div>
			  		<div class=" col-md-6">
			  			<h3>September featured book:</h3><h2> Ay Amor</h2>
			  			<?php
				  			require '../../dbconnection.inc.php';

							$conn = new mysqli($host, $db_user, $db_password, $dbname);

							// Check connection
							
							if ($conn->connect_error) {
					    		die("Connection failed: " . $conn->connect_error);
							}



							$sql = "SELECT about 
							        FROM books 
							        WHERE book_id = 6";
							$conn->query("set character_set_results='utf8'");   
							$result = $conn->query($sql);

				        	if($result->num_rows > 0) {
				        		$row = $result->fetch_assoc();
				        		echo "<p>".$row["about"]."</p>";
				        	}
				        	$conn->close();
	        			?>
			  		<!-- </div> -->
			  		</div>
		  	</div>
		</div>


		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
		<script src="js/jquery-2.1.4.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>