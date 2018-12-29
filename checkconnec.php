
<html>

<body>

<?php

$servername = "localhost";

$username = "acnh450";

$password = "150044043";



// Create connection

$conn = new mysqli($servername, $username, $password);



//Check connection

if ($conn->connect_error) {

	die("Connection failed: " . $conn->connect_error);

}

echo "Connected successfully";



//close the connection

mysqli_close($conn);



?>

</body>

<html>