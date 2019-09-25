<?php
$servername 	= "localhost";
$username 		= "root";
$password 		= "";
$name 			= "agungelektrindo";

global $conn;
$conn = mysqli_connect($servername, $username, $password);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$selected = mysqli_select_db($conn, $name);

?>
