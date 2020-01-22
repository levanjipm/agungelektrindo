<?php
include('../codes/connect.php');

if(empty($_POST['invoice_id'])){
	header('location:/agungelektrindo/accounting');
} else {
	$id 			= $_POST['invoice_id'];
	if(!empty($_POST['faktur'])){
		$faktur 	= $_POST['faktur'];
		$sql_update = "UPDATE invoices SET isconfirm = '1', faktur = '" . $faktur . "' WHERE id = '" . $id . "'";
	} else {
		$sql_update = "UPDATE invoices SET isconfirm = '1' WHERE id = '" . $id . "'";
	}
	
	$conn->query($sql_update);
}
	
	header('location:/agungelektrindo/accounting');
?>
	