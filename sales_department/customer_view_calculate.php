<?php
	include('../codes/connect.php');
	$customer_id		= $_POST['customer_id'];
	$start_date			= date('Y-m-d',strtotime($_POST['start_date']));
	$end_date			= date('Y-m-d',strtotime($_POST['end_date']));
	
	$sql				= "SELECT SUM(invoices.value) as value FROM invoices
							JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
							WHERE code_delivery_order.customer_id = '$customer_id'
							AND invoices.date > '$start_date' AND invoices.date < '$end_date'";
	$result				= $conn->query($sql);
	$row				= $result->fetch_assoc();
	
	echo $row['value'];
?>