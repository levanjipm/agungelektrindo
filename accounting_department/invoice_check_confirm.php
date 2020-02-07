<?php
	include('../codes/connect.php');
	$invoice_id		= $_GET['invoice_id'];
	
	$sql			= "SELECT id FROM invoices WHERE id = '$invoice_id' AND isconfirm = '1'";
	$result			= $conn->query($sql);
	
	echo (mysqli_num_rows($result));	
?>