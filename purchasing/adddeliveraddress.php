<?php
	include('../Codes/connect.php');
?>

<?php

$name=$_POST['tag'];
$address=$_POST['alamat'] . " Blok " . $_POST['blok'] . " no." . $_POST['nomor'] . ", RT" . $_POST['rt'] . ", RW" . $_POST['rw'];
$city = $_POST['city'];

$sql = "INSERT INTO delivery_address (tag,address,city) VALUES ('$name','$address','$city')";
if ($conn->query($sql) === TRUE) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

header("Location: purchasing.php");
die();

?>
