<?php
	include('../codes/connect.php');
	if(empty($_POST['id']) || empty($_POST['date'])){
		header('location:/agungelektrindo/accounting');
	} else {
		$invoice_id			= (int)$_POST['id'];
		$date 				= $_POST['date'];
		
		$sql 				= "SELECT invoices.value, invoices.ongkir, code_delivery_order.customer_id, SUM(receivable.value) as received
								FROM invoices JOIN code_delivery_order ON invoices.do_id = code_delivery_order.id
								JOIN receivable ON receivable.invoice_id = invoices.id
								WHERE invoices.id = '$invoice_id'";
								echo $sql;
		$result 			= $conn->query($sql);
		$row 				= $result->fetch_assoc();		
			
		$value 				= $row['value'];
		$delivery_fee		= $row['ongkir'];
		$paid				= $row['received'];
		$dilunaskan 		= $value + $delivery_fee - $paid;
		
		$sql_update 		= "UPDATE invoices SET isdone = '1', date_done = '$date' WHERE id = '$invoice_id'";
		$result_update 		= $conn->query($sql_update);
		
		$sql_insert 		= "INSERT INTO receivable (invoice_id,date,value) VALUES ('$invoice_id','$date','$dilunaskan')";
		$conn->query($sql_insert);
?>
	<script>
		window.history.back();
	</script>
<?php
	}
?>