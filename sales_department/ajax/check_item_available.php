<?php
	include('../../codes/connect.php');
	$reference = mysqli_real_escape_string($conn,$_POST['reference']);
	$sql_item = "SELECT COUNT(*) AS jumlah FROM itemlist WHERE reference = '" . $reference . "'";
	$result_item = $conn->query($sql_item);
	$item = $result_item->fetch_object();
	if($item->jumlah > 0){
		echo (0); // Item ada//
	} else {
		echo (1); //Item belum terdaftar//
	}
?>