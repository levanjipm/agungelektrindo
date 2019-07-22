<?php
	include('../Codes/connect.php');
	//Get every data on Input//
	$name=$_POST['namaperusahaan'];
	$address = $_POST['alamat'] . " Blok " . $_POST['blok'] . " no." . $_POST['nomor'] . ", RT" . $_POST['rt'] . ", RW" . $_POST['rw'];
	$phone=$_POST['phone'];
	$npwp=$_POST['npwp'];
	$city = $_POST['city'];
	//Inserting data into database//
	$sql = "INSERT INTO supplier (name, address, phone, npwp,city) VALUES ('$name','$address','$phone','$npwp','$city')";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}
	//Going back to purchasing.php//
	header("Location: purchasing.php");
	die();
?>
