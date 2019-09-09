<?php
	include('../codes/connect.php');
	$reference		= $_POST['reference'];
	$sql_stock		= "SELECT stock FROM stock WHERE reference = '" . mysqli_real_escape_string($conn,$reference) . "' ORDER BY id DESC LIMIT 1";
	$result_stock	= $conn->query($sql_stock);
	$stock			= $result_stock->fetch_assoc();
	
	if(mysqli_num_rows($result_stock) == 0){
		echo ('0');
	} else {
		echo $stock['stock'];
	}
?>