<?php
	include('../codes/connect.php');
	$invoice_id			= $_POST['invoice_id'];
	$description		= mysqli_real_escape_string($conn, $_POST['description']);
    $date				= $_POST['date'];
    $name				= mysqli_real_escape_string($conn,$_POST['name']);
    $tax				= $_POST['tax'];
	$value				= $_POST['value'];
	
	$sql				= "UPDATE purchases SET name = '$name', faktur = '$tax', date = '$date', value = '$value' WHERE id = '$invoice_id'";
	echo $sql;
	$conn->query($sql);
?>