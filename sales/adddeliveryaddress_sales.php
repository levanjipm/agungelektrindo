<?php
	include("../codes/connect.php");
	$customer = $_POST['select_customer'];
	$address=$_POST['alamat'] . " Blok " . $_POST['blok'] . " no." . $_POST['nomor'] . ", RT" . $_POST['rt'] . ", RW" . $_POST['rw'];
	$city = $_POST['city'];

$sql = "INSERT INTO customer_deliveryaddress (address,city,customer_id) VALUES ('$address','$city','$customer')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
header("Location: sales.php");
die();
?>
