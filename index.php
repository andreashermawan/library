
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
	          <a class="navbar-brand" href="#featured"><h1>Mi Club de Lectura</h1><span class="subhead"><p>Literatura hispanoamericana</p></span></a>
	        </div><!-- navbar-header -->
	        <div class="collapse navbar-collapse" id="collapse">
	          <ul class="nav navbar-nav navbar-right">
	          	<li class="active"><a href="#featured">Home</a></li>
	            <li><a href="search.php">Search</a></li>
	            <li><a href="books.php">Browse</a></li>
	          </ul>        
	        </div><!-- collapse navbar-collapse -->
	      </div><!-- container -->
	    </nav>
	</header>
		<div class="container">
			<div class="fix-search" id="search">
			  <h2>Search</h2>
			    <div class="row">
			        <form class="search-form" action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
			        	<div class="col-md-4 col-xs-12">
							<label class="entrada col-xs-12" for="">Search by Author</label>
							<input class="col-md-12 col-xs-12" type="text" name="book_author">
						</div>
						<div class="col-md-4 col-xs-12">
							<label class="entrada" for="">Search by Title</label>
							<input class="col-md-12 col-xs-12" type="text" name="book_title">
						</div>
						<div class="col-md-4 col-xs-12">
							<label class="entrada" for="">Search by Country</label>
							<input class="col-md-12 col-xs-12" type="text" name="book_country">
						</div>
						<!-- <button type="submit">go</button> -->
						<div class="col-md-12 col-xs-12 entrada">
			                <button class="btn btn-lg" type="submit">Go</button>
			            </div>
					</form>
			    </div>
			</div>
			<div>
		  		<div class="col-sm-6">
		  			<img  src="images/Ay-amor.png" class="img-responsive featured-book">
		  		</div>
		  		<div class=" col-sm-6">
		  			<h3>September featured book:</h3><h2> Ay Amor</h2>
		  			<?php
			  			require('dvconnect.inc.php');

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
		  		</div>
		  	</div>
		</div>

	<?php 
       
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

			$sql = "SELECT * 
			        FROM books 
			        	INNER JOIN images ON books.book_id = images.book_id 
			        WHERE 
			        	title LIKE '%$book_title%' or 
			         	author LIKE '%$book_author%' or 
			        	country LIKE '%$book_country%'";
			$result = $conn->query($sql);

        	if($result->num_rows > 0) {
    ?>
    			<div class="table responsive">
        			<table class="table table-striped">
          			<tr>
            
	            		<td>title</td>
	            		<td>author</td>
				        <td>Year</td>
				        <td>country</td>
				        <td>image</td>
          
          			</tr>
    <?php
          		while($row = $result->fetch_assoc()){ // start loop
            		if(isset($_GET["update_book_id"]) && $_GET["update_book_id"] == $row['book_id']){
	          			echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."'><tr>";
	          			echo "<input type='hidden' name='update_flag' value=".$row['book_id'] .">";
	          			echo "<td><input name='book_title' value=".$row["title"]."> </td>";
	          			echo "<td><input name='book_author' value=".$row["author"]."> </td>";
	          			echo "<td><input name='book_year' value=".$row["year"]."> </td>";
	          			echo "<td><input name='book_country' value=".$row["country"]."> </td>";
            		} else {
    ?>
            			<tr>
           
                			<td><?php echo $row["title"]; ?></td>
                			<td><?php echo $row["author"]; ?></td>
                			<td><?php echo $row["year"]; ?></td>
                			<td><?php echo $row["country"]; ?></td>
                			<td><img src="images/<?php echo $row["thumbnail_url"] ?>"></td>
              
            			</tr>
    <?php
            		}
        
            		if($row_class == "odd"){
              			$row_class = "even";
            		} else if($row_class == "even") {
              			$row_class = "odd";
            		}
          		}
    ?>
    				</table>
       			</div> 
    <?php
        	} else {
    ?>
        		<div>
        			<h1>No results match search criteria</h1>
        		</div>
    <?php
        	}

        	$conn->close();
    	}
    ?>

	  
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<!-- Include all compiled plugins (below), or include individual files as needed -->
	    <script src="js/bootstrap.min.js"></script>
	    <script src="js/myscript.js"></script>
	</body>
</html>