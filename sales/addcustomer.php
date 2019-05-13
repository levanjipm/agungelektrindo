<?php
	include("../codes/Connect.php");
	//Check if the length of NPWP is valid//
	$name=$_POST['namaperusahaan'];
	$address=$_POST['alamat'] . " Blok " . $_POST['blok'] . " no." . $_POST['nomor'] . ", RT" . $_POST['rt'] . ", RW" . $_POST['rw'];
	$phone=$_POST['phone'];
	$npwp=$_POST['npwp'];
	$city = $_POST['city'];
	$prefix = $_POST['prefix'];
	$pic = $_POST['pic'];
	$sql = "INSERT INTO customer (name, address, phone, npwp,city,prefix,pic) VALUES ('$name','$address','$phone','$npwp','$city','$prefix','$pic')";
	if ($conn->query($sql) === TRUE) {
		echo "New record created successfully";
	} else {
		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	header("Location: sales.php");
	die();
?>
