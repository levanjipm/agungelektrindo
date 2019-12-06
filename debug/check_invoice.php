<?php
	include('../codes/connect.php');
	$sql				= "SELECT code_delivery_order.id, code_delivery_order.date, invoices.id as invoice_id
							FROM code_delivery_order 
							JOIN invoices ON code_delivery_order.id = invoices.do_id
							WHERE MONTH(code_delivery_order.date) = '10' AND YEAR(code_delivery_order.date) = '2019' AND code_delivery_order.isinvoiced = '1'";
	$result				= $conn->query($sql);
	while($row			= $result->fetch_assoc()){
		$date			= $row['date'];
		$invoice_id		= $row['invoice_id'];
			
		$sql_update			= "UPDATE invoices SET date = '$date' WHERE id = '$invoice_id'";
		$conn->query($sql_update);
	};
?>