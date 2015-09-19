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
  $year = filter_var($_POST["book_year"], FILTER_SANITIZE_STRING);
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
$sql = "SELECT * FROM books";
$result = $conn->query($sql);

// reading about


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>update book records</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
  </head>
  <body>
    <div class="content container">
      <h2>book Records</h2>
        <div class="content">
          <div class="input-form">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newbooktitle"> title:
                    <input class="col-md-12" type="text" name="book_title" id="newbookType" />
                </label>
              </div>
         

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newbookauthor"> author:
                  <input class="col-md-12" type="text" name="book_author" id="newbookauthor" />
                </label>
              </div>

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newbookYear"> Year:
                  <input class="col-md-12" type="text" name="book_year" id="newbookYear" />
                </label>
              </div>

              <div class="col-md-6 entrada">
                <label class="col-md-12" for="newbookcountry"> country:
                  <input class="col-md-12" type="text" name="book_author" id="newbookcountry" />
                </label>
              </div>
              
                    <?php
                      if($result_about->num_rows > 0){
                        while($maker_row = $result_about->fetch_assoc()){
                          echo "<option value='".$book_row["book_id"]."'>".$book_row["name"]."</option>";
                        }
                      }
                    ?>
                  </select>
              </div>

              <div class="col-md-12 entrada">
                </label>
                <button class="btn btn-lg" type="submit">Insert new book</button>
              </div>
            </div>

          </form>
        </div>
      </div>
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="js/bootstrap.min.js"></script>
  </body>
</html>
<?php

?>