<?php
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"])){
	//handle registration
	//first, hash the password
	$hashed_password = password_hash(filter_var($_POST["password"], FILTER_SANITIZE_STRING),  PASSWORD_DEFAULT);
	$firstname = filter_var($_POST["firstname"], FILTER_SANITIZE_STRING);
	$lastname = filter_var($_POST["lastname"], FILTER_SANITIZE_STRING);
	$username = filter_var($_POST["username"], FILTER_SANITIZE_STRING);
	// TODO: validate email first
	$email = filter_var($_POST["email"], FILTER_SANITIZE_STRING);
	require('dvconnect.inc.php');
	$conn = new mysqli($servername, $username, $password, $dbname);

	// Check connection
	if ($conn->connect_error) {
	    die("Connection failed: " . $conn->connect_error);
	}

	$sql = "INSERT into users (username, first_name, last_name, email, password) VALUES ('$username', '$firstname', '$lastname', '$email', '$hashed_password')";

	if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }



}

?>

<html>
<head>
	<title>Register</title>
	<style type="text/css">
		label {
			display: block;
			margin: 20px 0;
		}
	</style>
</head>
<body>
	<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
		<label for=""> First Name
			<input type="text" name="firstname">
		</label>
		<label for=""> Last Name
			<input type="text" name="lastname">
		</label>
		<label for=""> Username
			<input type="text" name="username">
		</label>
		<label for=""> Email
			<input type="text" name="email">
		</label>
		<label for=""> Password
			<input type="password" name="password">
		</label>
		<button type="submit">Register Me!</button>
		
	</form>
</body>
</html>