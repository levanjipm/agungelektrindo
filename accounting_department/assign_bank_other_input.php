<?php	
	include('../codes/connect.php');
	$bank_id = $_POST['id'];
	$keterangan = mysqli_real_escape_string($conn,$_POST['keterangan']);
	$type = $_POST['type'];
	
	$sql_insert = "INSERT INTO code_bank_other (bank_id,class,information) VALUES ('$bank_id','$type','$keterangan')";
	$result_insert = $conn->query($sql_insert);
	
	$sql_update = "UPDATE code_bank SET isdone = '1' WHERE id = '" . $bank_id . "'";
	$result_update = $conn->query($sql_update);
	
	header('location:accounting.php');
?>