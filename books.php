<?php

require('dvconnect.inc.php');
$title = "book table";
// include("header.inc.php");
$row_class = "odd";
// Create connection
$conn = new mysqli($host, $db_user, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// inserting new record
if($_SERVER["REQUEST_METHOD"] == "POST" && empty($_POST["update_flag"])){

  $title = filter_var($_POST["book_title"], FILTER_SANITIZE_STRING);
  $author = filter_var($_POST["book_author"], FILTER_SANITIZE_STRING);
  $year = filter_var($_POST["book_year"], FILTER_SANITIZE_NUMBER_INT);
  $country = filter_var($_POST["book_author"], FILTER_SANITIZE_STRING);


  $sql_insert = "INSERT INTO books (book_id, title, author, year, country) VALUES (NULL, '$title' , '$author', '$year', '$country')";
  if ($conn->query($sql_insert) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql_insert . "<br>" . $conn->error;
    }
}

//delete requested record
if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete_book_id"])){
    $delete_book_id = $_GET["delete_book_id"];
    $sql_delete = "DELETE FROM books WHERE book_id = '$delete_book_id'";
    if($conn->query($sql_delete) === TRUE) {
        echo "Record deleted";
    } else {
        echo "Error on delete:" . $sql_delete . "<br>" .$conn->error;
    }
}

// Updating a record
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update_flag"])){ 
  $title_update = filter_var($_POST["book_title"], FILTER_SANITIZE_STRING);
  $author_update = filter_var($_POST["book_author"], FILTER_SANITIZE_STRING);
  $year_update = filter_var($_POST["book_year"], FILTER_SANITIZE_NUMBER_INT);
  $country_update = filter_var($_POST["book_country"], FILTER_SANITIZE_STRING);
  $id_update = $_POST["update_flag"];
  $sql_update = "UPDATE books SET
                title = '$title_update',
                author = '$author_update',
                year = '$year_update',
                country = '$country_update'
                WHERE book_id = $id_update";
  if ($conn->query($sql_update) === TRUE) {
    echo "Record updated successfully";
  } else {
    echo "Error: " . $sql_update . "<br>" . $conn->error;
  }
}




// reading current books
//$sql = "SELECT * FROM books";
$sql = "SELECT * FROM books INNER JOIN images ON books.book_id = images.book_id";
$result = $conn->query($sql);

// reading about


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
              <!-- <li><a href="index.php">Home</a></li> -->
              <li><a href="search.php">Search</a></li>
              <li class="active"><a href="books.php">Browse</a></li>
            </ul>        
          </div><!-- collapse navbar-collapse -->
        </div><!-- container -->
      </nav>
  </header>
  <body>
    <div class="content container">
      <h2>Browse books</h2>

      <div class="row">
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
          if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){ // start loop
                // print_r($row);
              if(isset($_GET["update_book_id"]) && $_GET["update_book_id"] == $row['book_id']){
                // row to update
                echo "<form method='POST' action='".$_SERVER["PHP_SELF"]."'><tr>";
                echo "<input type='hidden' name='update_flag' value=".$row['book_id'] .">";
                echo "<td><input name='book_title' value=".$row["title"]."> </td>";
                echo "<td><input name='book_author' value=".$row["author"]."> </td>";
                echo "<td><input name='book_year' value=".$row["year"]."> </td>";
                echo "<td><input name='book_country' value=".$row["country"]."> </td>";
                // echo "<td>submit</td></form></tr>";
                

              } else {
                // normal rows
                ?>
              <tr>
             
                  <td><?php echo $row["title"]; ?></td>
                  <td><?php echo $row["author"]; ?></td>
                  <td><?php echo $row["year"]; ?></td>
                  <td><?php echo $row["country"]; ?></td>
                   <!-- <a href="mypage.php?delete_id=2">Delete</a> -->
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
          } else {
            echo "0 results; nope";
          }
          echo "</table>";
          $conn->close();
          ?>
          </table>
          </div>
       </div>    
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="js/jquery-2.1.4.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>
        <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php

?>