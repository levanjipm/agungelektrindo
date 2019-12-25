<?php
	include('../codes/connect.php');
	$bank_id			= $_POST['bank_id'];
	$sql				= "SELECT id FROM code_bank WHERE major_id = '$bank_id'";
	$result				= $conn->query($sql);
	
	if(mysqli_num_rows($result) == 0){
		$sql_delete		= "DELETE FROM code_bank_other WHERE bank_id = '$bank_id'";
		$conn->query($sql_delete);
		
		
		$sql_delete		= "DELETE FROM code_bank WHERE id = '$bank_id'";
		$conn->query($sql_delete);
	}
?>