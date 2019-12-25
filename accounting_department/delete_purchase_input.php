<?php
	include('../codes/connect.php');
	$id 					= $_POST['id'];
	$sql_select 			= "SELECT id FROM code_goodreceipt WHERE invoice_id = '$id'";
	$result_select 			= $conn->query($sql_select);
	while($select 			= $result_select->fetch_assoc()){
		$good_receipt_id	= $select['id'];
		$sql_update 		= "UPDATE code_goodreceipt SET isinvoiced = '0', invoice_id = NULL WHERE id ='$good_receipt_id'";
		echo $sql_update;
		$conn->query($sql_update);
	};
	
	$sql = "DELETE FROM purchases WHERE id = '$id'";
	$conn->query($sql);
?>	