<?php
	include('../codes/connect.php');
	$invoice_id			= $_POST['invoice_id'];
	$sql				= "UPDATE code_goodreceipt SET isinvoiced = '0', invoice_id = NULL WHERE invoice_id = '$invoice_id'";
	$result				= $conn->query($sql);
	
	if($result){
		$sql_delete		= "DELETE FROM purchases WHERE id = '$invoice_id'";
		$conn->query($sql_delete);
	}
?>